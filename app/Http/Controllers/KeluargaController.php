<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use App\Models\Trah;
use App\Models\Anggota_Keluarga as Anggota_Keluarga;
use App\Models\Partner;
use Illuminate\Support\Facades\Hash;

class KeluargaController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string|min:6'
        ]);

        $visibility = 'public';

        try {
            $family = Trah::create([
                'trah_name' => $validated['family_name'],
                'description' => $validated['description'] ?? null,
                'created_by' => auth()->user()->name,
                'password' => $validated['password'] ? bcrypt($validated['password']) : null,
                'visibility' => $visibility,
            ]);

            return redirect()->route('admin.keluarga')
                ->with('success', 'Keluarga berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->route('admin.keluarga')
                ->with('error', 'Gagal membuat keluarga: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $family = Trah::findOrFail($id);

        $validated = $request->validate([
            'family_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string|min:6'
        ]);

        $visibility = empty($validated['password']) ? 'public' : 'private';

        $updateData = [
            'trah_name' => $validated['family_name'],
            'description' => $validated['description'] ?? null,
            'visibility' => $visibility
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        try {
            $family->update($updateData);

            return redirect()->route('admin.keluarga')
                ->with('success', 'Data keluarga berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.keluarga')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $trah = Trah::findOrFail($id);
            $trah->delete();

            return redirect()->route('admin.keluarga')
                ->with('success', 'Data trah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('trah.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function verifyPassword(Request $request, $id)
    {
        $trah = Trah::findOrFail($id);

        // Verifikasi password menggunakan Hash::check
        if (\Hash::check($request->password, $trah->password)) {
            // Simpan di session bahwa user sudah terautentikasi
            session(['trah_authenticated_' . $id => true]);
            return redirect()->route('keluarga.detail.private', $id);
        }

        return back()->with('error', 'Password salah');
    }

    public function detail_public(Request $request, $id)
    {
        $trah = Trah::with([
            'anggotaKeluarga' => function ($query) {
                $query->orderBy('urutan');
            }
        ])->findOrFail($id);
        $tree_id = $id;
        $anggota_keluarga = $trah->anggotaKeluarga;
        $pasangan_keluarga = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
            ->orderBy('nama')
            ->get();

        $rootMember = $anggota_keluarga->whereNull('parent_id');
        $rootPartner = $pasangan_keluarga;

        $person1 = null;
        $person2 = null;
        $relationshipDetails = null;
        $relationshipDetailsReversed = null;

        if ($request->has('compare') && $request->filled(['name1', 'name2'])) {
            $person1 = AnggotaKeluarga::where('nama', $request->name1)->where('tree_id', $tree_id)->first();
            $person2 = AnggotaKeluarga::where('nama', $request->name2)->where('tree_id', $tree_id)->first();

            if ($person1 && $person2) {
                $logicController = new \App\Http\Controllers\LogicController;

                // Arah Person1 -> Person2 dfs
                $path1 = $logicController->dfs($person1, $person2->id);
                $relationshipDetails = $path1
                    ? $logicController->relationshipPath($path1, $person1->nama, $person2->nama)
                    : ['relation' => 'Tidak ada hubungan yang ditemukan.', 'detailedPath' => []];

                // Arah Person2 -> Person1 (dibalik)
                $path2 = $logicController->dfs($person2, $person1->id);
                $relationshipDetailsReversed = $path2
                    ? $logicController->relationshipPath($path2, $person2->nama, $person1->nama)
                    : ['relation' => 'Tidak ada hubungan yang ditemukan.', 'detailedPath' => []];
            }
        }

        return view('detail.data_keluarga', [
            'trahs' => $trah,
            'trah' => $trah,
            'anggota_keluarga' => $anggota_keluarga,
            'existingMembers' => $anggota_keluarga,
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'pasangan_keluarga' => $pasangan_keluarga,
            'relationshipDetails' => $relationshipDetails,
            'relationshipDetailsReversed' => $relationshipDetailsReversed,
            'tree_id' => $tree_id // Pastikan tree_id dikirim dengan nama key yang benar
        ]);
    }

    public function hubungan($id, Request $request)
    {
        $trah = Trah::with([
            'anggotaKeluarga' => function ($query) {
                $query->orderBy('urutan');
            }
        ])->findOrFail($id);

        $tree_id = $id;
        $anggota_keluarga = $trah->anggotaKeluarga;

        $person1 = null;
        $person2 = null;
        $relationshipDetails = null;
        $relationshipDetailsReversed = null;
        $path = null;
        $pathRev = null;

        if ($request->has('compare') && $request->filled(['name1', 'name2'])) {
            $person1 = AnggotaKeluarga::where('nama', $request->name1)
                ->where('tree_id', $tree_id)
                ->first();
            $person2 = AnggotaKeluarga::where('nama', $request->name2)
                ->where('tree_id', $tree_id)
                ->first();

            if ($person1 && $person2) {
                $logicController = new \App\Http\Controllers\LogicController;

                // Arah Person1 -> Person2 dfs
                $path = $logicController->dfs($person1, $person2->id);
                $relationshipDetails = $path
                    ? $logicController->relationshipPath($path, $person1->nama, $person2->nama)
                    : ['relation' => 'Tidak ada hubungan yang ditemukan.', 'detailedPath' => []];

                // Arah Person2 -> Person1 (dibalik)
                $pathRev = $logicController->dfs($person2, $person1->id);
                $relationshipDetailsReversed = $pathRev
                    ? $logicController->relationshipPath($pathRev, $person2->nama, $person1->nama)
                    : ['relation' => 'Tidak ada hubungan yang ditemukan.', 'detailedPath' => []];
            }
        }

        return view('detail.data_hubungan', [
            'trah' => $trah,
            'anggota_keluarga' => $anggota_keluarga,
            'tree_id' => $tree_id,
            'person1' => $person1,
            'person2' => $person2,
            'relationshipDetails' => $relationshipDetails,
            'relationshipDetailsReversed' => $relationshipDetailsReversed,
            'path' => $path,
            'pathRev' => $pathRev,
            'name1' => $request->name1,
            'name2' => $request->name2
        ]);
    }

    public function pohon($id)
    {
        $tree_id = $id;
        $trah = Trah::with([
            'anggotaKeluarga' => function ($query) {
                $query->orderBy('urutan');
            }
        ])->findOrFail($tree_id);

        $anggota_keluarga = $trah->anggotaKeluarga;
        $pasangan_keluarga = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
            ->orderBy('nama')
            ->get();

        // Anggota tanpa parent (root members)
        $rootMember = $anggota_keluarga->whereNull('parent_id');
        $rootPartner = $pasangan_keluarga;

        return view('detail.data_pohon', [
            'trah' => $trah,
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'tree_id' => $tree_id
        ]);
    }

    public function pohon_output($id)
    {
        $tree_id = $id;
        $trah = Trah::with([
            'anggotaKeluarga' => function ($query) {
                $query->orderBy('urutan');
            }
        ])->findOrFail($tree_id);

        $anggota_keluarga = $trah->anggotaKeluarga;
        $pasangan_keluarga = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
            ->orderBy('nama')
            ->get();

        // Anggota tanpa parent (root members)
        $rootMember = $anggota_keluarga->whereNull('parent_id');
        $rootPartner = $pasangan_keluarga;

        return view('detail.data_pohon_output', [
            'trah' => $trah,
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'tree_id' => $tree_id
        ]);
    }

    public function detail_private($id, Request $request)
    {
        $trah = Trah::with([
            'anggotaKeluarga' => function ($query) {
                $query->orderBy('urutan');
            }
        ])->findOrFail($id);
        $tree_id = $id;
        $anggota_keluarga = $trah->anggotaKeluarga;
        $pasangan_keluarga = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
            ->orderBy('nama')
            ->get();
        // Root member (anggota tanpa parent_id) dari trah ini saja
        $rootMember = $anggota_keluarga->whereNull('parent_id');
        $rootPartner = $pasangan_keluarga;

        $person1 = null;
        $person2 = null;
        $relationshipDetails = null;
        $relationshipDetailsReversed = null;

        if ($request->has('compare') && $request->filled(['name1', 'name2'])) {
            $person1 = Anggota_Keluarga::where('nama', $request->name1)->where('tree_id', $tree_id)->first();
            $person2 = Anggota_Keluarga::where('nama', $request->name2)->where('tree_id', $tree_id)->first();

            if ($person1 && $person2) {
                $logicController = new \App\Http\Controllers\LogicController;

                // Arah Person1 -> Person2 dfs
                $path1 = $logicController->dfs($person1, $person2->id);
                $relationshipDetails = $path1
                    ? $logicController->relationshipPath($path1, $person1->nama, $person2->nama)
                    : ['relation' => 'Tidak ada hubungan yang ditemukan.', 'detailedPath' => []];

                // Arah Person2 -> Person1 (dibalik)
                $path2 = $logicController->dfs($person2, $person1->id);
                $relationshipDetailsReversed = $path2
                    ? $logicController->relationshipPath($path2, $person2->nama, $person1->nama)
                    : ['relation' => 'Tidak ada hubungan yang ditemukan.', 'detailedPath' => []];
            }
        }

        return view('private.data_keluarga', [
            'trahs' => $trah,
            'trah' => $trah,
            'anggota_keluarga' => $anggota_keluarga,
            'existingMembers' => $anggota_keluarga,
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'pasangan_keluarga' => $pasangan_keluarga,
            'relationshipDetails' => $relationshipDetails,
            'relationshipDetailsReversed' => $relationshipDetailsReversed,
            'tree_id' => $tree_id // Pastikan tree_id dikirim dengan nama key yang benar
        ]);
    }


    // User Methods
    public function storeUser(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $validated = $request->validate([
            'family_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $visibility = 'public';

        try {
            $family = Trah::create([
                'trah_name' => $validated['family_name'],
                'description' => $validated['description'] ?? null,
                'created_by' => auth()->user()->name,
                'visibility' => 'public',
            ]);

            return redirect()->route('user.keluarga')
                ->with('success', 'Keluarga berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->route('user.keluarga')
                ->with('error', 'Gagal membuat keluarga: ' . $e->getMessage());
        }
    }

    public function updateUser(Request $request, $id)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $family = Trah::findOrFail($id);

        // Check if user is the creator of this family
        if ($family->created_by !== auth()->user()->name) {
            return redirect()->route('user.keluarga')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah data ini');
        }

        $validated = $request->validate([
            'family_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string|min:6'
        ]);

        $visibility = empty($validated['password']) ? 'public' : 'private';

        $updateData = [
            'trah_name' => $validated['family_name'],
            'description' => $validated['description'] ?? null,
            'visibility' => $visibility
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        try {
            $family->update($updateData);

            return redirect()->route('user.keluarga')
                ->with('success', 'Data keluarga berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('user.keluarga')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $trah = Trah::findOrFail($id);

            // Check if user is the creator of this family
            if ($trah->created_by !== auth()->user()->name) {
                return redirect()->route('user.keluarga')
                    ->with('error', 'Anda tidak memiliki izin untuk menghapus data ini');
            }

            $trah->delete();

            return redirect()->route('user.keluarga')
                ->with('success', 'Data keluarga berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('user.keluarga')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
