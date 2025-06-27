<x-guest-layout>
    <div class="container shadow-lg m-5">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Left Column - Carousel -->
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div id="carouselExampleControls" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item active h-100">
                                <img src="https://images.unsplash.com/photo-1733039898491-b4f469c6cd1a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    class="d-block w-100 h-100 object-fit-cover" alt="Login Image">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="col-xl-4 col-lg-4 col-md-12 bg-body">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="w-100 p-4 p-lg-5" style="max-width: 450px;">
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Header -->
                            <div class="text-center mb-5">
                                <h2 class="fw-bold fs-3 mb-2">TrahJawa.Com</h2>
                                <p class="text-body-secondary fs-6">Silahkan Masuk Ke Akun Anda</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                @csrf

                                <!-- Email Field -->
                                <div class="form-floating mb-4">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="name@example.com"
                                        value="{{ old('email') }}" required autofocus autocomplete="username">
                                    <label for="email" class="text-body-secondary">Email <span
                                            class="text-danger">*</span></label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="form-floating mb-4 position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Password" required
                                        autocomplete="current-password">
                                    <label for="password" class="text-body-secondary">Password <span
                                            class="text-danger">*</span></label>
                                    <button
                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-1 text-body-secondary"
                                        type="button" id="togglePassword"
                                        style="z-index: 10; border: none; background: none;">
                                        <i class="fas fa-eye-slash me-2"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember_me"
                                            name="remember">
                                        <label class="form-check-label text-body-secondary" for="remember_me">
                                            {{ __('Ingat saya') }}
                                        </label>
                                    </div>
                                    <!-- @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-decoration-none text-primary-emphasis">
                                            {{ __('Lupa Kata Sandi?') }}
                                        </a>
                                    @endif -->
                                </div>

                                <!-- Submit Button -->
                                <button class="btn btn-primary w-100 py-2 mb-4 fw-semibold" type="submit">
                                    {{ __('Masuk') }}
                                </button>
                            </form>

                            <!-- Registration Link -->
                            <div class="text-center mb-4">
                                <p class="text-body-secondary mb-0">
                                    Belum Memiliki Akun?
                                    <a href="{{ route('register') }}"
                                        class="text-decoration-none fw-semibold text-primary-emphasis">
                                        Daftar Disini
                                    </a>
                                </p>
                            </div>

                            <hr class="my-4">

                            <!-- Footer -->
                            <div class="text-center">
                                <p class="text-body-secondary small mb-2">Dikembangkan oleh:</p>
                                <a href="/developer" target="_blank" class="text-decoration-none">
                                    <strong class="small text-body-emphasis underline">TIM PRODI TEKNIK INFORMATIKA</strong>
                                </a>
                                <p class="text-body-secondary small mt-2 mb-0">2025 © TrahJawa.Com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // Bootstrap form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</x-guest-layout>