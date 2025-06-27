<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trah;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function keluarga()
    {
        $user = auth()->user();

        $trah = Trah::where('created_by', $user->name)
            ->withCount('anggotaKeluarga')
            ->latest()
            ->get();

        return view('user.dashboard', compact('user', 'trah'));
    }
}
