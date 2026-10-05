@extends('layout.layout')

@section('title', 'Profil Saya')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/users/user-profile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/users/user-profile.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Akun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
@endsection

@section('content')
    @php
        $userdata = session('userdata');
        $namaRoleAktif = optional($role->firstWhere('idrole', $userdata['idrole_aktif']))->nama_role;
    @endphp

    @if ($errors->any())
        <div class="alert alert-danger solid alert-dismissible fade show">
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row user-profile">
        <div class="col-lg-4 col-md-12 layout-spacing">
            <div class="widget-content-area">
                <div class="text-center mt-4">
                    <img src="{{ asset('src/assets/img/profile-30.png') }}" alt="avatar" class="rounded-circle" width="100" height="100">
                    <h3 class="mb-0 mt-3">{{ $userdata['nama'] }}</h3>
                    <span class="badge bg-primary mt-2">{{ $namaRoleAktif ?? '-' }}</span>
                </div>

                <div class="user-info-list mt-4 pb-4">
                    <div>
                        <ul class="contacts-block list-unstyled">
                            <li class="contacts-block__item">
                                <i class="fa-solid fa-envelope me-2"></i>{{ $userdata['email'] }}
                            </li>
                            <li class="contacts-block__item">
                                <i class="fa-solid fa-phone me-2"></i>{{ $userdata['no_wa'] ?? '-' }}
                            </li>
                            <li class="contacts-block__item">
                                <i class="fa-solid fa-building me-2"></i>{{ $institusi ?? '-' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="widget-content-area p-4 mt-4">
                <h3>Role Saya</h3>

                <div class="alert d-none mb-3" id="alertRole" role="alert"></div>

                <ul class="list-group mt-3" id="listRole">
                    @foreach ($rolePengguna as $r)
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-idrole="{{ $r->idrole }}">
                            <span>
                                {{ $r->nama_role }}
                                @if ($r->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </span>
                            @if (! $r->status)
                                <button type="button" class="btn btn-sm btn-outline-primary btn-jadikan-aktif" data-idrole="{{ $r->idrole }}">
                                    <span class="btn-label">Jadikan Aktif</span>
                                </button>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-lg-8 col-md-12 layout-spacing">
            <div class="widget-content-area p-4">
                <h3>Ubah Kata Sandi</h3>

                <form id="formUbahPassword" method="POST" action="{{ route('profile.password.update') }}" class="mt-4">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               required autocomplete="current-password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 8 karakter" required autocomplete="new-password">
                        <div id="passwordStrengthHint" class="mt-1" style="font-size: 12.5px;"></div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Ulangi Kata Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" required autocomplete="new-password">
                        <div id="passwordMatchHint" class="mt-1" style="font-size: 12.5px;"></div>
                    </div>

                    <button type="submit" id="btnSimpanPassword" class="btn btn-primary" disabled>
                        <span class="btn-label">Simpan Kata Sandi</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>

    <script>
        (function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var ubahRoleAktifUrl = '{{ route('profile.role.aktifkan') }}';
            var $alert = $('#alertRole');

            function hideAlert() {
                $alert.addClass('d-none').removeClass('alert-success alert-danger').text('');
            }

            function showAlert(jenis, pesan) {
                $alert.removeClass('d-none alert-success alert-danger').addClass('alert-' + jenis).text(pesan);
            }

            $('#listRole').on('click', '.btn-jadikan-aktif', function () {
                var $btn = $(this);
                var idrole = $btn.data('idrole');
                var labelAsli = $btn.find('.btn-label').html();

                hideAlert();
                $btn.prop('disabled', true);
                $btn.find('.btn-label').html('<i class="fa-solid fa-spinner fa-spin"></i> Memproses...');

                $.ajax({
                    url: ubahRoleAktifUrl,
                    method: 'POST',
                    data: { idrole: idrole },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    window.location.href = res.data.redirect;
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    showAlert('danger', pesan);
                    $btn.prop('disabled', false);
                    $btn.find('.btn-label').html(labelAsli);
                });
            });
        })();

        (function () {
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordStrengthHint = document.getElementById('passwordStrengthHint');
            const passwordMatchHint = document.getElementById('passwordMatchHint');
            const btnSimpanPassword = document.getElementById('btnSimpanPassword');

            const minLength = 8;
            const uppercaseRegex = /[A-Z]/;
            const numberRegex = /[0-9]/;
            const specialCharRegex = /[^A-Za-z0-9]/;

            let isPasswordStrong = false;
            let isPasswordMatch = false;

            passwordConfirmationInput.addEventListener('paste', function (e) {
                e.preventDefault();
            });

            function validatePasswordStrength() {
                const value = passwordInput.value;

                isPasswordStrong = value.length >= minLength
                    && uppercaseRegex.test(value)
                    && numberRegex.test(value)
                    && specialCharRegex.test(value);

                if (value.length === 0) {
                    passwordStrengthHint.textContent = '';
                } else if (!isPasswordStrong) {
                    passwordStrengthHint.textContent = 'Kata sandi minimal 8 karakter dan mengandung huruf kapital, angka, serta karakter khusus.';
                    passwordStrengthHint.style.color = '#e7515a';
                } else {
                    passwordStrengthHint.textContent = 'Kata sandi memenuhi syarat.';
                    passwordStrengthHint.style.color = '#00ab55';
                }

                updateSubmitState();
            }

            function validatePasswordMatch() {
                const value = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;

                isPasswordMatch = value.length > 0 && value === confirmation;

                if (confirmation.length === 0) {
                    passwordMatchHint.textContent = '';
                } else if (!isPasswordMatch) {
                    passwordMatchHint.textContent = 'Kata sandi tidak sama.';
                    passwordMatchHint.style.color = '#e7515a';
                } else {
                    passwordMatchHint.textContent = 'Kata sandi cocok.';
                    passwordMatchHint.style.color = '#00ab55';
                }

                updateSubmitState();
            }

            function updateSubmitState() {
                btnSimpanPassword.disabled = !(isPasswordStrong && isPasswordMatch);
            }

            passwordInput.addEventListener('input', function () {
                validatePasswordStrength();
                validatePasswordMatch();
            });
            passwordConfirmationInput.addEventListener('input', validatePasswordMatch);

            document.getElementById('formUbahPassword').addEventListener('submit', function () {
                if (btnSimpanPassword.disabled) {
                    return;
                }

                btnSimpanPassword.disabled = true;
                btnSimpanPassword.querySelector('.btn-label').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
            });
        })();
    </script>
@endsection
