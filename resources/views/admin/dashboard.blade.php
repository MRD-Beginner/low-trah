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
    <div class="card shadow-md">
        <div class="card-body">
            <div class="d-flex flex-column align-items-start mb-4">
                <h5 class="mb-3 text-dark fs-5 fw-bold">
                    Daftar Trah Keluarga
                </h5>
                <button type="button"
                    class="text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center gap-2"
                    style="background-color: #696cff;" onmouseover="this.style.backgroundColor='#5a5de8'"
                    onmouseout="this.style.backgroundColor='#696cff'" data-bs-toggle="modal" data-bs-target="#addModal">
                    <span>Tambah Keluarga</span>
                </button>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="datatables">
                    <thead class="table-warning">
                        <tr>
                            <th class="text-center"
                                style="width: 8%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                No</th>
                            <th class="text-center"
                                style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Nama Trah</th>
                            <th class="text-center"
                                style="width: 16%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Pemilik</th>
                            <th class="text-center"
                                style="width: 16%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Tipe Keluarga</th>
                            <th class="text-center"
                                style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Deskripsi</th>
                            <th class="text-center"
                                style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trah as $Trah)
                            <tr class="{{ $loop->iteration % 2 == 1 ? 'odd-row' : 'even-row' }}">
                                <td class="text-center text-muted fw-medium" style="border: 1px solid #dee2e6;">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div>
                                            <h6 class="mb-0">{{ $Trah->trah_name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="fw-medium">{{ $Trah->created_by }}</span>
                                    </div>
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    @if($Trah->visibility === 'public')
                                        <span class="badge bg-success-subtle text-success rounded-pill">
                                            Publik
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning rounded-pill">
                                            Privat
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <span class="text-muted">
                                        {{ $Trah->description ?? 'Tidak ada deskripsi' }}
                                    </span>
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Detail Button -->
                                        @if ($Trah->visibility === 'public')
                                            <a href="{{ route('keluarga.detail.public', $Trah->id) }}"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                title="Lihat Detail">
                                                Detail
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#passwordModal{{ $Trah->id }}" data-bs-toggle="tooltip"
                                                title="Akses Privat">
                                                Detail
                                            </button>
                                        @endif

                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $Trah->id }}" data-bs-toggle="tooltip"
                                            title="Edit">
                                            Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $Trah->id }}" data-bs-toggle="tooltip"
                                            title="Hapus">
                                            Hapus
                                        </button>

                                        <!-- Share Button -->
                                        <button class="btn btn-sm btn-outline-info"
                                            onclick="copyShareLink('{{ route('keluarga.detail.public', $Trah->id) }}')"
                                            data-bs-toggle="tooltip" title="Bagikan Link">
                                            Bagikan
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5" style="border: 1px solid #dee2e6;">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>Belum ada data keluarga</h5>
                                        <p>Mulai dengan menambahkan keluarga pertama Anda</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addModal">
                                            <i class="fas fa-plus me-2"></i>Tambah Keluarga
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-group">
        <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('keluarga.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Tambah Keluarga Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-4">
                                    <label for="nama-trah" class="form-label">Nama Keluarga<span
                                            style="color: red">*</span></label>
                                    <input type="text" id="nama-trah" name="family_name" class="form-control"
                                        placeholder="Masukkan Nama Keluarga Anda" required>
                                </div>
                            </div>
                            <div class="row g-4 mb-4">
                                <div class="col mb-0">
                                    <label for="deskripsi-trah" class="form-label">Deskripsi</label>
                                    <input type="text" id="deskripsi-trah" name="description" class="form-control"
                                        placeholder="Deskripsi Singkat Keluarga">
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col d-flex justify-content-start">
                                    <div class="form-check-reverse form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" />
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Keluarga
                                            Privat</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-x-4 password-section" style="display: none;">
                                <!-- Tambahkan class dan sembunyikan awal -->
                                <label class="form-label">Password<span style="color: red">*</span></label>
                                <div class="input-group mb-4">
                                    <input type="password" id="passwordSection" name="password" class="form-control"
                                        aria-label="Password input">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($trah as $Trah)
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModal{{ $Trah->id }}" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content"> <!-- Ubah dari <form> ke <div> untuk wrapper -->
                        <div class="modal-header text-center">
                            <h5 class="modal-title fw-bold" id="backDropModalTitle">Hapus Keluarga Ini?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body justify-content-center text-center">
                            <i class="fa-solid fa-triangle-exclamation fa-beat"
                                style="color: #FF0000; font-size: 100px"></i>
                            <span class="d-block mt-5">kamu Yakin Ingin Mengahapus Keluarga Ini? Data yang terhapus
                                tidak dapat dipulihkan</span>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form method="POST" action="{{ route('keluarga.delete', $Trah->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $Trah->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('keluarga.update', $Trah->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Edit Keluarga</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-4">
                                        <label for="nama-trah" class="form-label">Nama Keluarga</label>
                                        <input type="text" id="nama-trah" name="family_name" class="form-control"
                                            placeholder="Masukkan Nama Keluarga Anda" value="{{ $Trah->trah_name }}"
                                            required>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col mb-0">
                                        <label for="deskripsi-trah" class="form-label">Deskripsi</label>
                                        <input type="text" id="deskripsi-trah" name="description" class="form-control"
                                            placeholder="Deskripsi Singkat Keluarga" value="{{ $Trah->description }}">
                                    </div>
                                    <div class="col mb-0">
                                        <label for="created-by" class="form-label">Pemilik</label>
                                        <input type="text" id="created-by" name="owner" class="form-control"
                                            value="{{ auth()->user()->name }}" required readonly>
                                    </div>
                                </div>
                                <div class="row g-x-4">
                                    <label class="form-label">Password (*Kosongkan Jika Tidak Diubah)</label>
                                    <div class="input-group mb-4">
                                        <input type="password" id="password" name="password" class="form-control"
                                            aria-label="Password input">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($trah as $Trah)
            @if ($Trah->visibility === 'private')
                <!-- Modal untuk setiap trah private -->
                <div class="modal fade" id="passwordModal{{ $Trah->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('keluarga.verify.password', $Trah->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Akses Trah {{ $Trah->trah_name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="password{{ $Trah->id }}" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password{{ $Trah->id }}" name="password"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Custom Styles -->
    <style>
        .avatar {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .avatar-sm {
            width: 24px;
            height: 24px;
            font-size: 12px;
        }

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
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
            border-color: #696cff;
        }

        .btn {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-check-input:checked {
            background-color: #696cff;
            border-color: #696cff;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
        }

        /* Gradient backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #696cff 0%, #5a5de8 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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

        /* Badge styling */
        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 1rem;
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

        /* Enhanced form styling */
        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .input-group .btn {
            border-left: none;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .form-control:focus+.btn {
            border-color: #696cff;
        }
    </style>

    <!-- JavaScript -->
    <script>
        // Function to copy share link to clipboard
        function copyShareLink(url) {
            navigator.clipboard.writeText(url).then(function () {
                // Show success message with SweetAlert
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Link berhasil disalin ke clipboard',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: {
                        container: 'high-z-index'
                    }
                });
            }).catch(function (err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);

                // Show success message with SweetAlert
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Link berhasil disalin ke clipboard',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: {
                        container: 'high-z-index'
                    }
                });
            });
        }

        // Toggle password visibility for add modal
        document.getElementById('flexSwitchCheckDefault').addEventListener('change', function () {
            const passwordSection = document.querySelector('.password-section');
            const passwordInput = document.getElementById('passwordSection');

            if (this.checked) {
                passwordSection.style.display = 'block';
                passwordInput.required = true;
            } else {
                passwordSection.style.display = 'none';
                passwordInput.required = false;
                passwordInput.value = '';
            }
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Form validation for add modal
        document.querySelector('#addModal form').addEventListener('submit', function (e) {
            const isPrivate = document.getElementById('flexSwitchCheckDefault').checked;
            const password = document.getElementById('passwordSection').value;

            if (isPrivate && !password.trim()) {
                e.preventDefault();
                alert('Password diperlukan untuk keluarga privat!');
                document.getElementById('passwordSection').focus();
            }
        });
    </script>
</x-app-layout>