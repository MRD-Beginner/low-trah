<x-app-layout>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        container: 'high-z-index' // Kelas custom untuk container
                    }
                });
            });
        </script>
    @endif

    @auth
        <div class="modal-group">
            <div class="modal fade" id="familyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel3">Tambah Anggota Keluarga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('anggota.keluarga.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                @if ($trah->id)
                                    <input type="hidden" name="tree_id" value="{{ $trah->id }}">
                                @endif
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="nama_anggota_keluarga" class="form-label">Nama<span
                                                style="color: red">*</span></label>
                                        <input type="text" id="nama_anggota_keluarga" name="nama_anggota_keluarga"
                                            class="form-control" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin<span
                                                style="color: red">*</span></label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="urutan" class="form-label">Urutan<span
                                                style="color: red">*</span></label>
                                        <select id="urutan" name="urutan" class="form-select" required>
                                            <option value="">Pilih Urutan</option>
                                            @for ($i = 1; $i <= 14; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="parent1_id" class="form-label">Orang Tua 1</label>
                                        <select id="parent1_id" name="parent1_id" class="form-select"
                                            onchange="loadPartners()">
                                            <option value="">Pilih Orang Tua</option>
                                            @foreach ($anggota_keluarga as $member)
                                                <option value="{{ $member->id }}" {{ old('parent1_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->nama }}
                                                    @if ($member->jenis_kelamin === 'Laki-Laki')
                                                        (Pak)
                                                    @else
                                                        (Ibu)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="parent2_id" class="form-label">Orang Tua 2 (Pasangan)</label>
                                        <select id="parent2_id" name="parent2_id" class="form-select" disabled>
                                            <option value="">Pilih Pasangan</option>
                                            <!-- Partners will be loaded via JavaScript -->
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="status_kehidupan" class="form-label">Status Kehidupan<span
                                                style="color: red">*</span></label>
                                        <select id="status_kehidupan" name="status_kehidupan" class="form-select" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Hidup">Hidup</option>
                                            <option value="Wafat">Wafat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_kematian" class="form-label">Tanggal Kematian</label>
                                        <input type="date" id="tanggal_kematian" class="form-control"
                                            name="tanggal_kematian">
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="3"
                                            placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="keluarga_image_link" class="form-label">Link Foto (Media Sosial, Drive,
                                            dll)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="" class="img-thumbnail image-preview"
                                                style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                            <input class="form-control" type="url" id="keluarga_image_link"
                                                name="keluarga_image_link" placeholder="https://example.com/image.jpg"
                                                onchange="previewImageFromLink()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($anggota_keluarga as $anggota)
                <div class="modal fade" id="editMemberModal{{ $anggota->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="exampleModalLabel3">Edit Anggota Keluarga</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('anggota.keluarga.update', $anggota->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" name="tree_id" value="{{ $anggota->tree_id }}">
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label for="nama_anggota_keluarga_edit" class="form-label">Nama<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="nama_anggota_keluarga_edit" name="nama_anggota_keluarga_edit"
                                                class="form-control" placeholder="Masukkan nama lengkap"
                                                value="{{ $anggota->nama }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jenis_kelamin_edit" class="form-label">Jenis Kelamin<span
                                                    style="color: red">*</span></label>
                                            <select id="jenis_kelamin_edit" name="jenis_kelamin_edit" class="form-select"
                                                required>
                                                <option value="Laki-laki" {{ $anggota->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="Perempuan" {{ $anggota->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label for="tanggal_lahir_edit" class="form-label">Tanggal Lahir</label>
                                            <input type="date" id="tanggal_lahir_edit" name="tanggal_lahir_edit"
                                                class="form-control" value="{{ $anggota->tanggal_lahir }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="urutan_edit" class="form-label">Urutan<span
                                                    style="color: red">*</span></label>
                                            <select id="urutan_edit" name="urutan_edit" class="form-select" required>
                                                <option value="">Pilih Urutan</option>
                                                @for ($i = 1; $i <= 14; $i++)
                                                    <option value="{{ $i }}" {{ $anggota->urutan == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label for="parent_id_edit" class="form-label">Orang Tua</label>
                                            <select id="parent_id_edit" name="parent_id_edit" class="form-select"
                                                onload="loadPartnersEdit(this.value)">
                                                <option value="">Pilih Orang Tua</option>
                                                @foreach ($existingMembers as $member)
                                                    <option value="{{ $member->id }}" {{ $anggota->parent_id == $member->id ? 'selected' : '' }}>
                                                        {{ $member->nama }}
                                                        @if ($member->jenis_kelamin === 'Laki-Laki')
                                                            (Pak)
                                                        @else
                                                            (Ibu)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="parent2_id_edit" class="form-label">Orang Tua 2 (Pasangan)</label>
                                            <select id="parent2_id_edit" name="parent2_id_edit" class="form-select">
                                                <option value="">Pilih Pasangan</option>
                                                @foreach ($rootPartner as $partner)
                                                    <option value="{{ $partner->id }}" {{ $anggota->parent_partner_id == $partner->id ? 'selected' : '' }}>
                                                        {{ $partner->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label for="status_kehidupan_edit" class="form-label">Status Kehidupan<span
                                                    style="color: red">*</span></label>
                                            <select id="status_kehidupan_edit" name="status_kehidupan_edit" class="form-select"
                                                required>
                                                <option value="">Pilih Status</option>
                                                <option value="Hidup" {{ $anggota->status_kehidupan == 'Hidup' ? 'selected' : '' }}>Hidup
                                                </option>
                                                <option value="Wafat" {{ $anggota->status_kehidupan == 'Wafat' ? 'selected' : '' }}>Wafat
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_kematian_edit" class="form-label">Tanggal Kematian</label>
                                            <input type="date" id="tanggal_kematian_edit" class="form-control"
                                                name="tanggal_kematian_edit" value="{{ $anggota->tanggal_kematian }}">
                                        </div>
                                    </div>
                                    <div class="row g-4 mb-4">
                                        <div class="col-12">
                                            <label for="alamat_edit" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat_edit" rows="3"
                                                placeholder="Masukkan alamat lengkap">{{ $anggota->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label for="keluarga_image_link_edit" class="form-label">Link Foto (Media Sosial,
                                                Drive, dll)</label>
                                            <div class="d-flex align-items-center gap-3">
                                                @if ($anggota->photo)
                                                    <img src="{{ asset('storage/' . $anggota->photo) }}"
                                                        class="img-thumbnail image-preview"
                                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                                @else
                                                    <img src="" class="img-thumbnail image-preview"
                                                        style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                                @endif
                                                <input class="form-control" type="url" id="keluarga_image_link_edit"
                                                    name="keluarga_image_link_edit" placeholder="https://example.com/image.jpg"
                                                    onchange="previewImageFromLinkEdit()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteMemberModal{{ $anggota->id }}" data-bs-backdrop="static" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h5 class="modal-title fw-bold" id="backDropModalTitle">Hapus Anggota Keluarga Ini?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body justify-content-center text-center">
                                <i class="fa-solid fa-triangle-exclamation fa-beat"
                                    style="color: #FF0000; font-size: 100px"></i>
                                <span class="d-block mt-5">Anda yakin ingin menghapus anggota keluarga
                                    <strong>{{ $anggota->nama }}</strong>? Data yang terhapus tidak dapat dipulihkan.</span>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <form method="POST" action="{{ route('anggota.keluarga.delete', $anggota->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="modal fade" id="addPartnerModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel3">Tambah Pasangan Keluarga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pasangan.anggota.keluarga.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="tree_id" value="{{ $trahs->id }}">
                                <div class="row g-4 mb-4">
                                    <div class="col-12">
                                        <label for="nama_pasangan_anggota_keluarga" class="form-label">Nama<span
                                                style="color: red">*</span></label>
                                        <input type="text" id="nama_pasangan_anggota_keluarga"
                                            name="nama_pasangan_anggota_keluarga" class="form-control"
                                            placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin<span
                                                style="color: red">*</span></label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="partner_id" class="form-label">Pasangan Dari<span
                                                style="color: red">*</span></label>
                                        <select id="partner_id" name="partner_id" class="form-select" required>
                                            <option value="">Pilih Anggota Keluarga</option>
                                            @foreach ($existingMembers as $member)
                                                <option value="{{ $member->id }}">
                                                    {{ $member->nama }}
                                                    @if ($member->jenis_kelamin === 'Laki-Laki')
                                                        (Tn)
                                                    @else
                                                        (Ny)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="urutan" class="form-label">Urutan<span
                                                style="color: red">*</span></label>
                                        <select id="urutan" name="urutan" class="form-select" required>
                                            <option value="">Pilih Urutan</option>
                                            @for ($i = 1; $i <= 14; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="status_kehidupan" class="form-label">Status Kehidupan<span
                                                style="color: red">*</span></label>
                                        <select id="status_kehidupan" name="status_kehidupan" class="form-select" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Hidup">Hidup</option>
                                            <option value="Wafat">Wafat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_kematian" class="form-label">Tanggal Kematian</label>
                                        <input type="date" id="tanggal_kematian" name="tanggal_kematian"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="3"
                                            placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="partner_image_link" class="form-label">Link Foto (Media Sosial, Drive,
                                            dll)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="" class="img-thumbnail image-preview"
                                                style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                            <input class="form-control" type="url" id="partner_image_link"
                                                name="partner_image_link" placeholder="https://example.com/image.jpg"
                                                onchange="previewImageFromLinkPartner()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($anggota_keluarga as $anggota)
                @foreach ($anggota->partners as $partner)
                    <div class="modal fade" id="editPartnerMemberModal{{ $partner->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="exampleModalLabel3">Edit Pasangan Keluarga</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('pasangan.anggota.keluarga.update', $partner->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <input type="hidden" name="tree_id" value="{{ $trah->id }}">
                                        <div class="row g-4 mb-4">
                                            <div class="col-12">
                                                <label for="nama_pasangan_edit" class="form-label">Nama<span
                                                        style="color: red">*</span></label>
                                                <input type="text" id="nama_pasangan_edit" name="nama_pasangan_edit"
                                                    class="form-control" placeholder="Masukkan nama lengkap"
                                                    value="{{ $partner->nama }}" required>
                                            </div>
                                        </div>
                                        <div class="row g-4 mb-4">
                                            <div class="col-md-6">
                                                <label for="jenis_kelamin_edit" class="form-label">Jenis Kelamin<span
                                                        style="color: red">*</span></label>
                                                <select id="jenis_kelamin_edit" name="jenis_kelamin_edit" class="form-select"
                                                    required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki" {{ $partner->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="Perempuan" {{ $partner->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggal_lahir_edit" class="form-label">Tanggal Lahir</label>
                                                <input type="date" id="tanggal_lahir_edit" name="tanggal_lahir_edit"
                                                    class="form-control"
                                                    value="{{ $partner->tanggal_lahir ? \Carbon\Carbon::parse($partner->tanggal_lahir)->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>
                                        <div class="row g-4 mb-4">
                                            <div class="col-md-6">
                                                <label for="partner_id_edit" class="form-label">Pasangan Dari<span
                                                        style="color: red">*</span></label>
                                                <select id="partner_id_edit" name="partner_id_edit" class="form-select" required>
                                                    <option value="">Pilih Anggota Keluarga</option>
                                                    @foreach ($existingMembers as $member)
                                                        <option value="{{ $member->id }}" {{ $partner->anggota_keluarga_id == $member->id ? 'selected' : '' }}>
                                                            {{ $member->nama }}
                                                            @if ($member->jenis_kelamin === 'Laki-Laki')
                                                                (Tn)
                                                            @else
                                                                (Ny)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="urutan_edit" class="form-label">Urutan Ke<span
                                                        style="color: red">*</span></label>
                                                <select id="urutan_edit" name="urutan_edit" class="form-select" required>
                                                    <option value="">Pilih Urutan</option>
                                                    @for ($i = 1; $i <= 14; $i++)
                                                        <option value="{{ $i }}" {{ $partner->urutan_anak == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-4 mb-4">
                                            <div class="col-md-6">
                                                <label for="status_kehidupan_edit" class="form-label">Status Kehidupan<span
                                                        style="color: red">*</span></label>
                                                <select id="status_kehidupan_edit" name="status_kehidupan_edit" class="form-select"
                                                    required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Hidup" {{ $partner->status_kehidupan == 'Hidup' ? 'selected' : '' }}>Hidup
                                                    </option>
                                                    <option value="Wafat" {{ $partner->status_kehidupan == 'Wafat' ? 'selected' : '' }}>Wafat
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggal_kematian_edit" class="form-label">Tanggal Kematian</label>
                                                <input type="date" id="tanggal_kematian_edit" name="tanggal_kematian_edit"
                                                    class="form-control"
                                                    value="{{ $partner->tanggal_kematian ? \Carbon\Carbon::parse($partner->tanggal_kematian)->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>
                                        <div class="row g-4 mb-4">
                                            <div class="col-12">
                                                <label for="alamat_edit" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat_edit" name="alamat_edit" rows="3"
                                                    placeholder="Masukkan alamat lengkap">{{ $partner->alamat }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <label for="foto_pasangan_link_edit" class="form-label">Link Foto (Media Sosial,
                                                    Drive, dll)</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($partner->photo)
                                                        <img src="{{ asset('storage/' . $partner->photo) }}"
                                                            class="img-thumbnail image-preview"
                                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                                    @else
                                                        <img src="" class="img-thumbnail image-preview"
                                                            style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                                    @endif
                                                    <input class="form-control" type="url" id="foto_pasangan_link_edit"
                                                        name="foto_pasangan_link_edit" placeholder="https://example.com/image.jpg"
                                                        onchange="previewImageFromLinkPartnerEdit()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deletePartnerMemberModal{{ $partner->id }}" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h5 class="modal-title fw-bold" id="backDropModalTitle">Hapus Pasangan Ini?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body justify-content-center text-center">
                                    <i class="fa-solid fa-triangle-exclamation fa-beat"
                                        style="color: #FF0000; font-size: 100px"></i>
                                    <span class="d-block mt-5">Anda yakin ingin menghapus pasangan
                                        <strong>{{ $partner->nama }}</strong>? Data yang terhapus tidak dapat dikembalikan.</span>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <form method="POST" action="{{ route('pasangan.anggota.keluarga.delete', $partner->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>
    @endauth

    <div class="bg-gray-100 mb-3">
        <div class="py-3 px-3 md:px-5 bg-white rounded-lg shadow-md">
            @if ($trahs->trah_name)
                <h5 class="d-flex flex-column fw-bold mb-0 gap-2 px-4">
                    {{ $trahs->trah_name }}
                    @if ($trahs->description)
                        <small class="fw-light">{{ $trahs->description }}</small>
                    @endif
                </h5>
            @endif
        </div>
    </div>

    <div class="nav-align-top shadow-md">
        <ul class="nav nav-pills mb-4 nav-fill bg-white p-2" role="tablist">
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                    aria-selected="true">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        <i class="fa-solid fa-person me-2"></i>Data Keluarga
                    </span>
                    <i class="fa-solid fa-person icon-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item mb-1 mb-sm-0">
                <a href="{{ route('keluarga.detail.pohon', $tree_id) }}"
                    class="nav-link {{ request()->is('detail/private/data/keluarga/pohon/*') ? 'active' : '' }}"
                    role="tab">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        <i class="fa-solid fa-sitemap me-2"></i>Pohon Keluarga
                    </span>
                    <i class="fa-solid fa-sitemap icon-sm d-sm-none"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('keluarga.detail.hubungan', $tree_id) }}"
                    class="nav-link {{ request()->is('detail/private/data/keluarga/hubungan/*') ? 'active' : '' }}"
                    role="tab">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        <i class="fa-solid fa-link me-2"></i>Hubungan
                    </span>
                    <i class="fa-solid fa-link icon-sm d-sm-none"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="card shadow-md p-4">
        <div class="card-body">
            <div class="d-flex flex-column align-items-start mb-4">
                <h5 class="mb-3 text-dark fs-5 fw-bold">
                    Data Anggota Keluarga
                </h5>
                <p class="text-muted mb-0">Kelola data anggota keluarga dan pasangan</p>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade {{ !request()->has('compare') ? 'show active' : '' }}"
                    id="navs-pills-justified-home" role="tabpanel">
                    <div class="">
                        <div class="nav-align-top">
                            <ul class="nav nav-underline" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-align-home" aria-controls="navs-top-align-home"
                                        aria-selected="true">
                                        Anggota Keluarga
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-align-profile" aria-controls="navs-top-align-profile"
                                        aria-selected="false">
                                        Pasangan Anggota Keluarga
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="navs-top-align-home" role="tabpanel">
                                    <button type="button"
                                        class="text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center gap-2 mt-3 mb-3"
                                        style="background-color: #696cff;"
                                        onmouseover="this.style.backgroundColor='#5a5de8'"
                                        onmouseout="this.style.backgroundColor='#696cff'" data-bs-toggle="modal"
                                        data-bs-target="#familyModal">
                                        <span>Tambah Anggota Keluarga</span>
                                    </button>

                                    <div class="row mb-3 g-2 align-items-center">
                                        <div class="col-md-6">
                                            <div class="dataTables_length">
                                                <label class="mb-0">
                                                    Menampilkan
                                                    <select id="entriesPerPageAnggota"
                                                        class="form-select form-select-sm d-inline-block w-auto mx-1">
                                                        <option value="5" selected>5</option>
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    data
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <div class="dataTables_filter">
                                                <label class="mb-0">
                                                    Search:
                                                    <input type="search" id="searchInputAnggota"
                                                        class="form-control form-control-sm d-inline-block w-auto ms-1"
                                                        placeholder="Type to search...">
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="datatablesAnggota">
                                            <thead class="table-warning">
                                                <tr>
                                                    <th class="text-center"
                                                        style="width: 8%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        No</th>
                                                    <th class="text-center"
                                                        style="width: 25%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Nama Lengkap</th>
                                                    <th class="text-center"
                                                        style="width: 15%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Jenis Kelamin</th>
                                                    <th class="text-center"
                                                        style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Tanggal Lahir</th>
                                                    <th class="text-center"
                                                        style="width: 15%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Status Kehidupan</th>
                                                    <th class="text-center"
                                                        style="width: 17%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($anggota_keluarga as $anggota)
                                                    <tr class="{{ $loop->iteration % 2 == 1 ? 'odd-row' : 'even-row' }}">
                                                        <td class="text-center text-muted fw-medium"
                                                            style="border: 1px solid #dee2e6;">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td class="text-center" style="border: 1px solid #dee2e6;">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <div>
                                                                    <h6 class="mb-0">{{ $anggota->nama }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" style="border: 1px solid #dee2e6;">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <span class="fw-medium">{{ $anggota->jenis_kelamin }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" style="border: 1px solid #dee2e6;">
                                                            <span class="text-muted">
                                                                {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d-F-Y') : 'Belum diketahui' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center" style="border: 1px solid #dee2e6;">
                                                            @if($anggota->status_kehidupan === 'Hidup')
                                                                <span class="badge bg-success-subtle text-success rounded-pill">
                                                                    Hidup
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger-subtle text-danger rounded-pill">
                                                                    Wafat
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="border: 1px solid #dee2e6;">
                                                            <div class="d-flex justify-content-center gap-1">
                                                                <!-- Edit Button -->
                                                                <button class="btn btn-sm btn-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editMemberModal{{ $anggota->id }}"
                                                                    title="Edit">
                                                                    Edit
                                                                </button>

                                                                <!-- Delete Button -->
                                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteMemberModal{{ $anggota->id }}"
                                                                    title="Delete">
                                                                    Hapus
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-5"
                                                            style="border: 1px solid #dee2e6;">
                                                            <div class="text-muted">
                                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                                <h5>Belum ada data anggota keluarga</h5>
                                                                <p>Mulai dengan menambahkan anggota keluarga
                                                                    pertama</p>
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal" data-bs-target="#familyModal">
                                                                    <i class="fas fa-plus me-2"></i>Tambah
                                                                    Anggota
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-3 g-2 align-items-center">
                                        <div class="col-md-6">
                                            <div class="dataTables_info" id="datatables_info_anggota" role="status"
                                                aria-live="polite">
                                                Showing 1 to {{ count($anggota_keluarga) }} of
                                                {{ count($anggota_keluarga) }} entries
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <div class="dataTables_paginate paging_simple_numbers float-end">
                                                <ul class="pagination" id="paginationAnggota">
                                                    <li class="paginate_button page-item previous disabled">
                                                        <a href="#" class="page-link">Previous</a>
                                                    </li>
                                                    <li class="paginate_button page-item active">
                                                        <a href="#" class="page-link">1</a>
                                                    </li>
                                                    <li class="paginate_button page-item next disabled">
                                                        <a href="#" class="page-link">Next</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-top-align-profile" role="tabpanel">
                                    <button type="button"
                                        class="text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center gap-2 mt-3 mb-3"
                                        style="background-color: #696cff;"
                                        onmouseover="this.style.backgroundColor='#5a5de8'"
                                        onmouseout="this.style.backgroundColor='#696cff'" data-bs-toggle="modal"
                                        data-bs-target="#addPartnerModal">
                                        <span>Tambah Pasangan Anggota Keluarga</span>
                                    </button>

                                    <div class="row mb-3 g-2 align-items-center">
                                        <div class="col-md-6">
                                            <div class="dataTables_length">
                                                <label class="mb-0">
                                                    Menampilkan
                                                    <select id="entriesPerPagePasangan"
                                                        class="form-select form-select-sm d-inline-block w-auto mx-1">
                                                        <option value="5" selected>5</option>
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    data
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <div class="dataTables_filter">
                                                <label class="mb-0">
                                                    Search:
                                                    <input type="search" id="searchInputPasangan"
                                                        class="form-control form-control-sm d-inline-block w-auto ms-1"
                                                        placeholder="Type to search...">
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="datatablesPasangan">
                                            <thead class="table-warning">
                                                <tr>
                                                    <th class="text-center"
                                                        style="width: 8%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        No</th>
                                                    <th class="text-center"
                                                        style="width: 25%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Nama Lengkap</th>
                                                    <th class="text-center"
                                                        style="width: 15%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Jenis Kelamin</th>
                                                    <th class="text-center"
                                                        style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Tanggal Lahir</th>
                                                    <th class="text-center"
                                                        style="width: 15%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Status Kehidupan</th>
                                                    <th class="text-center"
                                                        style="width: 17%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                                        Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $counter = 1; @endphp
                                                @forelse ($anggota_keluarga as $anggota)
                                                    @foreach ($anggota->partners as $partner)
                                                        <tr class="{{ $counter % 2 == 1 ? 'odd-row' : 'even-row' }}">
                                                            <td class="text-center text-muted fw-medium"
                                                                style="border: 1px solid #dee2e6;">
                                                                {{ $counter++ }}
                                                            </td>
                                                            <td class="text-center" style="border: 1px solid #dee2e6;">
                                                                <div class="d-flex align-items-center justify-content-center">
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $partner->nama }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center" style="border: 1px solid #dee2e6;">
                                                                <div class="d-flex align-items-center justify-content-center">
                                                                    <span class="fw-medium">{{ $partner->jenis_kelamin }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-center" style="border: 1px solid #dee2e6;">
                                                                <span class="text-muted">
                                                                    {{ $partner->tanggal_lahir ? \Carbon\Carbon::parse($partner->tanggal_lahir)->translatedFormat('d-F-Y') : 'Belum diketahui' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center" style="border: 1px solid #dee2e6;">
                                                                @if($partner->status_kehidupan === 'Hidup')
                                                                    <span class="badge bg-success-subtle text-success rounded-pill">
                                                                        Hidup
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger rounded-pill">
                                                                        Wafat
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center" style="border: 1px solid #dee2e6;">
                                                                <div class="d-flex justify-content-center gap-1">
                                                                    <!-- Edit Button -->
                                                                    <button class="btn btn-sm btn-warning"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editPartnerMemberModal{{ $partner->id }}"
                                                                        title="Edit">
                                                                        Edit
                                                                    </button>

                                                                    <!-- Delete Button -->
                                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                                        data-bs-target="#deletePartnerMemberModal{{ $partner->id }}"
                                                                        title="Delete">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-5"
                                                            style="border: 1px solid #dee2e6;">
                                                            <div class="text-muted">
                                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                                <h5>Belum ada data pasangan anggota keluarga</h5>
                                                                <p>Mulai dengan menambahkan pasangan anggota keluarga
                                                                    pertama</p>
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#addPartnerModal">
                                                                    <i class="fas fa-plus me-2"></i>Tambah Pasangan
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-3 g-2 align-items-center">
                                        <div class="col-md-6">
                                            <div class="dataTables_info" id="datatables_info_pasangan" role="status"
                                                aria-live="polite">
                                                @php
                                                    $totalPartners = 0;
                                                    foreach ($anggota_keluarga as $anggota) {
                                                        $totalPartners += count($anggota->partners);
                                                    }
                                                @endphp
                                                Showing 1 to {{ $totalPartners }} of {{ $totalPartners }} entries
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <div class="dataTables_paginate paging_simple_numbers float-end">
                                                <ul class="pagination" id="paginationPasangan">
                                                    <li class="paginate_button page-item previous disabled">
                                                        <a href="#" class="page-link">Previous</a>
                                                    </li>
                                                    <li class="paginate_button page-item active">
                                                        <a href="#" class="page-link">1</a>
                                                    </li>
                                                    <li class="paginate_button page-item next disabled">
                                                        <a href="#" class="page-link">Next</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const partnersData = {
            @foreach ($anggota_keluarga as $member)
                "{{ $member->id }}": [
                @foreach ($member->partners as $partner)
                                                            {
                        id: "{{ $partner->id }}",
                        nama: "{{ $partner->nama }}",
                        jenis_kelamin: "{{ $partner->jenis_kelamin }}"
                    },
                @endforeach
                ],
            @endforeach
        };

        function loadPartners() {
            const parent1Select = document.getElementById('parent1_id');
            const parent2Select = document.getElementById('parent2_id');
            const selectedId = parent1Select.value;

            // Reset partner dropdown
            parent2Select.innerHTML = '<option value="">Pilih Pasangan</option>';
            parent2Select.disabled = true;

            if (!selectedId) return;

            // Enable and load partners if available
            const partners = partnersData[selectedId];
            if (partners && partners.length > 0) {
                parent2Select.disabled = false;

                partners.forEach(partner => {
                    const option = document.createElement('option');
                    option.value = partner.id;
                    option.textContent =
                        `${partner.nama} (${partner.jenis_kelamin === 'Laki-Laki' ? 'Pak' : 'Ibu'})`;

                    // Set selected if this was the old value
                    if ("{{ old('parent2_id') }}" == partner.id) {
                        option.selected = true;
                    }

                    parent2Select.appendChild(option);
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('parent1_id').value) {
                loadPartners();
            }
        });

        // Function to preview image from link in add modal
        function previewImageFromLink() {
            const linkInput = document.getElementById('keluarga_image_link');
            const previewImg = linkInput.parentElement.querySelector('.image-preview');

            if (linkInput.value.trim() !== '') {
                previewImg.src = linkInput.value;
                previewImg.style.display = 'block';
            } else {
                previewImg.style.display = 'none';
            }
        }

        // Function to preview image from link in edit modal
        function previewImageFromLinkEdit() {
            const linkInput = document.getElementById('keluarga_image_link_edit');
            const previewImg = linkInput.parentElement.querySelector('.image-preview');

            if (linkInput.value.trim() !== '') {
                previewImg.src = linkInput.value;
                previewImg.style.display = 'block';
            } else {
                previewImg.style.display = 'none';
            }
        }

        // Function to preview image from link in partner modal
        function previewImageFromLinkPartner() {
            const linkInput = document.getElementById('partner_image_link');
            const previewImg = linkInput.parentElement.querySelector('.image-preview');

            if (linkInput.value.trim() !== '') {
                previewImg.src = linkInput.value;
                previewImg.style.display = 'block';
            } else {
                previewImg.style.display = 'none';
            }
        }

        // Function to preview image from link in edit partner modal
        function previewImageFromLinkPartnerEdit() {
            const linkInput = document.getElementById('foto_pasangan_link_edit');
            const previewImg = linkInput.parentElement.querySelector('.image-preview');

            if (linkInput.value.trim() !== '') {
                previewImg.src = linkInput.value;
                previewImg.style.display = 'block';
            } else {
                previewImg.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // --- Anggota Keluarga Table ---
            const tableAnggota = document.getElementById('datatablesAnggota');
            if (tableAnggota) {
                const tbodyAnggota = tableAnggota.querySelector('tbody');
                const rowsAnggota = Array.from(tbodyAnggota.querySelectorAll('tr'));
                const entriesSelectAnggota = document.getElementById('entriesPerPageAnggota');
                const searchInputAnggota = document.getElementById('searchInputAnggota');
                const infoLabelAnggota = document.getElementById('datatables_info_anggota');
                const paginationAnggota = document.getElementById('paginationAnggota');

                let currentPageAnggota = 1;
                let entriesPerPageAnggota = parseInt(entriesSelectAnggota.value);
                let filteredRowsAnggota = rowsAnggota;

                function filterRowsAnggota() {
                    const searchTerm = searchInputAnggota.value.toLowerCase();
                    if (searchTerm === '') {
                        filteredRowsAnggota = rowsAnggota;
                    } else {
                        filteredRowsAnggota = rowsAnggota.filter(row => {
                            const cells = row.querySelectorAll('td');
                            return Array.from(cells).some(cell =>
                                cell.textContent.toLowerCase().includes(searchTerm)
                            );
                        });
                    }
                    currentPageAnggota = 1;
                    updateTableAnggota();
                }

                function updateTableAnggota() {
                    const startIndex = (currentPageAnggota - 1) * entriesPerPageAnggota;
                    const endIndex = startIndex + entriesPerPageAnggota;
                    const paginatedRows = filteredRowsAnggota.slice(startIndex, endIndex);
                    rowsAnggota.forEach(row => row.style.display = 'none');
                    paginatedRows.forEach(row => row.style.display = '');
                    const totalRows = filteredRowsAnggota.length;
                    const startRow = totalRows > 0 ? startIndex + 1 : 0;
                    const endRow = Math.min(endIndex, totalRows);
                    infoLabelAnggota.textContent = `Showing ${startRow} to ${endRow} of ${totalRows} entries`;
                    updatePaginationAnggota(totalRows);
                }

                function updatePaginationAnggota(totalRows) {
                    paginationAnggota.innerHTML = '';
                    const totalPages = Math.ceil(totalRows / entriesPerPageAnggota);
                    const prevLi = document.createElement('li');
                    prevLi.className = `paginate_button page-item previous ${currentPageAnggota === 1 ? 'disabled' : ''}`;
                    prevLi.innerHTML = '<a href="#" class="page-link">Previous</a>';
                    prevLi.addEventListener('click', e => {
                        e.preventDefault();
                        if (currentPageAnggota > 1) {
                            currentPageAnggota--;
                            updateTableAnggota();
                        }
                    });
                    paginationAnggota.appendChild(prevLi);
                    const maxVisiblePages = 5;
                    let startPage = Math.max(1, currentPageAnggota - Math.floor(maxVisiblePages / 2));
                    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                    if (endPage - startPage + 1 < maxVisiblePages) {
                        startPage = Math.max(1, endPage - maxVisiblePages + 1);
                    }
                    if (startPage > 1) {
                        const firstLi = document.createElement('li');
                        firstLi.className = 'paginate_button page-item';
                        firstLi.innerHTML = '<a href="#" class="page-link">1</a>';
                        firstLi.addEventListener('click', e => {
                            e.preventDefault();
                            currentPageAnggota = 1;
                            updateTableAnggota();
                        });
                        paginationAnggota.appendChild(firstLi);
                        if (startPage > 2) {
                            const ellipsisLi = document.createElement('li');
                            ellipsisLi.className = 'paginate_button page-item disabled';
                            ellipsisLi.innerHTML = '<a href="#" class="page-link">...</a>';
                            paginationAnggota.appendChild(ellipsisLi);
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        const pageLi = document.createElement('li');
                        pageLi.className = `paginate_button page-item ${i === currentPageAnggota ? 'active' : ''}`;
                        pageLi.innerHTML = `<a href=\"#\" class=\"page-link\">${i}</a>`;
                        pageLi.addEventListener('click', e => {
                            e.preventDefault();
                            currentPageAnggota = i;
                            updateTableAnggota();
                        });
                        paginationAnggota.appendChild(pageLi);
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            const ellipsisLi = document.createElement('li');
                            ellipsisLi.className = 'paginate_button page-item disabled';
                            ellipsisLi.innerHTML = '<a href="#" class="page-link">...</a>';
                            paginationAnggota.appendChild(ellipsisLi);
                        }
                        const lastLi = document.createElement('li');
                        lastLi.className = 'paginate_button page-item';
                        lastLi.innerHTML = `<a href=\"#\" class=\"page-link\">${totalPages}</a>`;
                        lastLi.addEventListener('click', e => {
                            e.preventDefault();
                            currentPageAnggota = totalPages;
                            updateTableAnggota();
                        });
                        paginationAnggota.appendChild(lastLi);
                    }
                    const nextLi = document.createElement('li');
                    nextLi.className = `paginate_button page-item next ${currentPageAnggota === totalPages ? 'disabled' : ''}`;
                    nextLi.innerHTML = '<a href="#" class="page-link">Next</a>';
                    nextLi.addEventListener('click', e => {
                        e.preventDefault();
                        if (currentPageAnggota < totalPages) {
                            currentPageAnggota++;
                            updateTableAnggota();
                        }
                    });
                    paginationAnggota.appendChild(nextLi);
                }
                entriesSelectAnggota.addEventListener('change', function () {
                    entriesPerPageAnggota = parseInt(this.value);
                    currentPageAnggota = 1;
                    updateTableAnggota();
                });
                searchInputAnggota.addEventListener('input', function () {
                    filterRowsAnggota();
                });
                updateTableAnggota();
            }

            // --- Pasangan Table ---
            const tablePasangan = document.getElementById('datatablesPasangan');
            if (tablePasangan) {
                const tbodyPasangan = tablePasangan.querySelector('tbody');
                const rowsPasangan = Array.from(tbodyPasangan.querySelectorAll('tr'));
                const entriesSelectPasangan = document.getElementById('entriesPerPagePasangan');
                const searchInputPasangan = document.getElementById('searchInputPasangan');
                const infoLabelPasangan = document.getElementById('datatables_info_pasangan');
                const paginationPasangan = document.getElementById('paginationPasangan');

                let currentPagePasangan = 1;
                let entriesPerPagePasangan = parseInt(entriesSelectPasangan.value);
                let filteredRowsPasangan = rowsPasangan;

                function filterRowsPasangan() {
                    const searchTerm = searchInputPasangan.value.toLowerCase();
                    if (searchTerm === '') {
                        filteredRowsPasangan = rowsPasangan;
                    } else {
                        filteredRowsPasangan = rowsPasangan.filter(row => {
                            const cells = row.querySelectorAll('td');
                            return Array.from(cells).some(cell =>
                                cell.textContent.toLowerCase().includes(searchTerm)
                            );
                        });
                    }
                    currentPagePasangan = 1;
                    updateTablePasangan();
                }

                function updateTablePasangan() {
                    const startIndex = (currentPagePasangan - 1) * entriesPerPagePasangan;
                    const endIndex = startIndex + entriesPerPagePasangan;
                    const paginatedRows = filteredRowsPasangan.slice(startIndex, endIndex);
                    rowsPasangan.forEach(row => row.style.display = 'none');
                    paginatedRows.forEach(row => row.style.display = '');
                    const totalRows = filteredRowsPasangan.length;
                    const startRow = totalRows > 0 ? startIndex + 1 : 0;
                    const endRow = Math.min(endIndex, totalRows);
                    infoLabelPasangan.textContent = `Showing ${startRow} to ${endRow} of ${totalRows} entries`;
                    updatePaginationPasangan(totalRows);
                }

                function updatePaginationPasangan(totalRows) {
                    paginationPasangan.innerHTML = '';
                    const totalPages = Math.ceil(totalRows / entriesPerPagePasangan);
                    const prevLi = document.createElement('li');
                    prevLi.className = `paginate_button page-item previous ${currentPagePasangan === 1 ? 'disabled' : ''}`;
                    prevLi.innerHTML = '<a href="#" class="page-link">Previous</a>';
                    prevLi.addEventListener('click', e => {
                        e.preventDefault();
                        if (currentPagePasangan > 1) {
                            currentPagePasangan--;
                            updateTablePasangan();
                        }
                    });
                    paginationPasangan.appendChild(prevLi);
                    const maxVisiblePages = 5;
                    let startPage = Math.max(1, currentPagePasangan - Math.floor(maxVisiblePages / 2));
                    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                    if (endPage - startPage + 1 < maxVisiblePages) {
                        startPage = Math.max(1, endPage - maxVisiblePages + 1);
                    }
                    if (startPage > 1) {
                        const firstLi = document.createElement('li');
                        firstLi.className = 'paginate_button page-item';
                        firstLi.innerHTML = '<a href="#" class="page-link">1</a>';
                        firstLi.addEventListener('click', e => {
                            e.preventDefault();
                            currentPagePasangan = 1;
                            updateTablePasangan();
                        });
                        paginationPasangan.appendChild(firstLi);
                        if (startPage > 2) {
                            const ellipsisLi = document.createElement('li');
                            ellipsisLi.className = 'paginate_button page-item disabled';
                            ellipsisLi.innerHTML = '<a href="#" class="page-link">...</a>';
                            paginationPasangan.appendChild(ellipsisLi);
                        }
                    }
                    for (let i = startPage; i <= endPage; i++) {
                        const pageLi = document.createElement('li');
                        pageLi.className = `paginate_button page-item ${i === currentPagePasangan ? 'active' : ''}`;
                        pageLi.innerHTML = `<a href=\"#\" class=\"page-link\">${i}</a>`;
                        pageLi.addEventListener('click', e => {
                            e.preventDefault();
                            currentPagePasangan = i;
                            updateTablePasangan();
                        });
                        paginationPasangan.appendChild(pageLi);
                    }
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            const ellipsisLi = document.createElement('li');
                            ellipsisLi.className = 'paginate_button page-item disabled';
                            ellipsisLi.innerHTML = '<a href="#" class="page-link">...</a>';
                            paginationPasangan.appendChild(ellipsisLi);
                        }
                        const lastLi = document.createElement('li');
                        lastLi.className = 'paginate_button page-item';
                        lastLi.innerHTML = `<a href=\"#\" class=\"page-link\">${totalPages}</a>`;
                        lastLi.addEventListener('click', e => {
                            e.preventDefault();
                            currentPagePasangan = totalPages;
                            updateTablePasangan();
                        });
                        paginationPasangan.appendChild(lastLi);
                    }
                    const nextLi = document.createElement('li');
                    nextLi.className = `paginate_button page-item next ${currentPagePasangan === totalPages ? 'disabled' : ''}`;
                    nextLi.innerHTML = '<a href="#" class="page-link">Next</a>';
                    nextLi.addEventListener('click', e => {
                        e.preventDefault();
                        if (currentPagePasangan < totalPages) {
                            currentPagePasangan++;
                            updateTablePasangan();
                        }
                    });
                    paginationPasangan.appendChild(nextLi);
                }
                entriesSelectPasangan.addEventListener('change', function () {
                    entriesPerPagePasangan = parseInt(this.value);
                    currentPagePasangan = 1;
                    updateTablePasangan();
                });
                searchInputPasangan.addEventListener('input', function () {
                    filterRowsPasangan();
                });
                updateTablePasangan();
            }
        });
    </script>

    <!-- Custom Styles -->
    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
            padding: 1rem 0.75rem;
        }

        .table td {
            vertical-align: middle;
            border-color: #e9ecef;
            padding: 1rem 0.75rem;
        }

        /* Zebra striping custom CSS */
        .odd-row {
            background-color: #f8f9fa;
        }

        .even-row {
            background-color: #f5f5f5;
        }

        .odd-row:hover {
            background-color: #e9ecef;
        }

        .even-row:hover {
            background-color: #e8e8e8;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Enhanced Modal Styling */
        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem;
            background-color: #f8f9fa;
            color: #495057;
        }

        .modal-header .btn-close {
            filter: none;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1.5rem;
            background-color: #f8f9fa;
        }

        .form-control {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
            border-color: #696cff;
        }

        .form-select {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }

        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
            border-color: #696cff;
        }

        .btn {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #696cff;
            border-color: #696cff;
        }

        .btn-primary:hover {
            background-color: #5a5de8;
            border-color: #5a5de8;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        /* Form label styling */
        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #495057;
        }

        /* Image preview styling */
        .image-preview {
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            border-color: #696cff;
            transform: scale(1.05);
        }

        /* Delete modal specific styling */
        .modal-header.text-center {
            text-align: center !important;
        }

        .modal-body.justify-content-center {
            text-align: center;
        }

        .modal-footer.justify-content-center {
            justify-content: center;
        }

        /* Warning icon animation */
        .fa-triangle-exclamation.fa-beat {
            animation: beat 1s infinite;
        }

        @keyframes beat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Badge styling */
        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 1rem;
        }

        /* Card styling */
        .card {
            border-radius: 1rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .card-body {
                padding: 1rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .modal-header,
            .modal-footer {
                padding: 1rem;
            }
        }

        /* Animation for modals */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        /* Nav tabs styling */
        .nav-tabs .nav-link {
            border-radius: 0.5rem 0.5rem 0 0;
            border: 1px solid #dee2e6;
            border-bottom: none;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background-color: #696cff;
            border-color: #696cff;
            color: white;
        }

        .nav-tabs .nav-link:hover {
            border-color: #696cff;
            color: #696cff;
        }

        .nav-tabs .nav-link.active:hover {
            color: white;
        }

        /* Nav underline styling */
        .nav-underline .nav-link {
            color: #000000;
            font-weight: 500;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }

        .nav-underline .nav-link.active {
            color: #696cff;
            border-bottom-color: #696cff;
        }

        .nav-underline .nav-link:hover {
            color: #696cff;
            border-bottom-color: #696cff;
        }

        /* Enhanced form styling */
        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        /* Textarea styling */
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* File input styling */
        input[type="file"].form-control {
            padding: 0.375rem 0.75rem;
        }

        /* Date input styling */
        input[type="date"].form-control {
            padding: 0.375rem 0.75rem;
        }

        /* Select styling */
        select.form-select {
            padding: 0.375rem 0.75rem;
        }

        /* Modal backdrop */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Success/Error states */
        .form-control.is-valid {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>
</x-app-layout>
