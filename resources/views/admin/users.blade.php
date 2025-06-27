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
                        container: 'high-z-index'
                    }
                });
            });
        </script>
    @endif

    <div class="card shadow-md">
        <div class="card-body">
            <div class="d-flex flex-column align-items-start mb-4">
                <h5 class="mb-3 text-dark fs-5 fw-bold">
                    Data Pengguna
                </h5>
                <p class="text-muted mb-0">Kelola data pengguna sistem</p>
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
                                style="width: 25%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Nama</th>
                            <th class="text-center"
                                style="width: 27%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Email</th>
                            <th class="text-center"
                                style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Role</th>
                            <th class="text-center"
                                style="width: 20%; background-color: #696cff !important; color: white; height: 60px; vertical-align: middle; border: 1px solid white !important;">
                                Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="{{ $loop->iteration % 2 == 1 ? 'odd-row' : 'even-row' }}">
                                <td class="text-center text-muted fw-medium" style="border: 1px solid #dee2e6;">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="fw-medium">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-primary-subtle text-primary rounded-pill">
                                            Admin
                                        </span>
                                    @else
                                        <span class="badge bg-info-subtle text-info rounded-pill">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center" style="border: 1px solid #dee2e6;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span
                                            class="fw-medium">{{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5" style="border: 1px solid #dee2e6;">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>Belum ada data pengguna</h5>
                                        <p>Data pengguna akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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

        /* Enhanced form styling */
        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 600;
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