@extends('layout.layout')

@section('title', 'Admin / SC Users')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/tomSelect/tom-select.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        #modal-user-baru-admin .modal-content,
        #modal-user-lama-admin .modal-content,
        #modal-user-baru-sc .modal-content,
        #modal-user-lama-sc .modal-content,
        #modal-detail-pengguna .modal-content,
        #modal-edit-pengguna .modal-content {
            background: #fff;
        }

        #modal-user-lama-admin .form-control[readonly],
        #modal-user-lama-sc .form-control[readonly],
        #modal-detail-pengguna .form-control[readonly],
        #modal-edit-pengguna .form-control[readonly] {
            color: #000;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Admin / SC</li>
@endsection

@section('content')
    @include('admin.partials.user-role-box', [
        'boxId' => 'admin',
        'boxTitle' => 'Admin Users',
        'users' => $adminUsers,
    ])

    @include('admin.partials.user-role-box', [
        'boxId' => 'sc',
        'boxTitle' => 'SC Users',
        'users' => $scUsers,
    ])

    <div class="modal fade" id="modal-detail-pengguna" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="detail-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="detail-content d-none">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control detail-nama" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control detail-email" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. WA</label>
                            <input type="text" class="form-control detail-no-wa" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Institusi Asal</label>
                            <input type="text" class="form-control detail-institusi" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Dibuat</label>
                            <input type="text" class="form-control detail-created-at" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Akun</label>
                            <input type="text" class="form-control detail-status-akun" readonly>
                        </div>

                        <hr>

                        <label class="form-label">Role</label>
                        <ul class="list-group detail-roles-list"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-pengguna" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-edit-pengguna">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="edit-loading text-center py-4">
                            <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                        </div>

                        <div class="edit-content d-none">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control edit-nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control edit-email" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. WA</label>
                                <input type="text" name="no_wa" class="form-control edit-no-wa" inputmode="numeric" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Dibuat</label>
                                <input type="text" class="form-control edit-created-at" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Akun</label>
                                <input type="text" class="form-control edit-status-akun" readonly>
                            </div>

                            <hr>

                            <button type="button" class="btn btn-outline-danger btn-reset-password">
                                <i class="fa-solid fa-key me-1"></i> Reset Password
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-edit-pengguna" disabled>
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchPenggunaUrl = '{{ route('admin.admin-users.search-pengguna') }}';
            var tambahBaruUrl = '{{ route('admin.admin-users.tambah-baru') }}';
            var tambahLamaUrl = '{{ route('admin.admin-users.tambah-lama') }}';
            var detailUrl = '{{ route('admin.admin-users.detail') }}';
            var ubahRoleAktifUrl = '{{ route('admin.admin-users.ubah-role-aktif') }}';
            var updatePenggunaUrl = '{{ route('admin.admin-users.update') }}';
            var resetPasswordUrl = '{{ route('admin.admin-users.reset-password') }}';
            var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            var boxIds = ['admin', 'sc'];
            var dataTables = {};

            boxIds.forEach(function (boxId) {
                initUserRoleBox(boxId);
            });

            initModalDetailPengguna();
            initModalEditPengguna();

            function updatePenggunaRowEverywhere(idpengguna, nama, noWa) {
                boxIds.forEach(function (boxId) {
                    var table = dataTables[boxId];

                    if (!table) {
                        return;
                    }

                    var changed = false;

                    table.rows().every(function () {
                        if ($(this.node()).find('[data-idpengguna="' + idpengguna + '"]').length) {
                            var rowData = this.data();
                            rowData[0] = escapeHtml(nama);
                            rowData[2] = escapeHtml(noWa);
                            this.data(rowData);
                            changed = true;
                        }
                    });

                    if (changed) {
                        table.draw(false);
                    }
                });
            }

            function escapeHtml(value) {
                var div = document.createElement('div');
                div.textContent = value == null ? '' : value;

                return div.innerHTML;
            }

            function showPageAlert(type, message) {
                var container = document.getElementById('page-alert-container');

                if (!container) {
                    return;
                }

                var alertEl = document.createElement('div');
                alertEl.className = 'alert alert-' + type + ' solid alert-dismissible fade show';
                alertEl.innerHTML = '<button type="button" class="close h-100" data-bs-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>' + escapeHtml(message);
                container.prepend(alertEl);
            }

            function showModalAlert(modalEl, type, message) {
                var alertEl = modalEl.querySelector('.modal-alert');

                if (!alertEl) {
                    return;
                }

                alertEl.className = 'modal-alert alert alert-' + type + ' mb-3';
                alertEl.textContent = message;
            }

            function hideModalAlert(modalEl) {
                var alertEl = modalEl.querySelector('.modal-alert');

                if (!alertEl) {
                    return;
                }

                alertEl.className = 'modal-alert alert d-none mb-3';
                alertEl.textContent = '';
            }

            function initModalDetailPengguna() {
                var modalEl = document.getElementById('modal-detail-pengguna');
                var loadingEl = modalEl.querySelector('.detail-loading');
                var contentEl = modalEl.querySelector('.detail-content');
                var rolesListEl = modalEl.querySelector('.detail-roles-list');
                var currentIdpengguna = null;

                function renderRoles(roles) {
                    rolesListEl.innerHTML = roles.map(function (role) {
                        var badge = role.status
                            ? '<span class="badge bg-success">Aktif</span>'
                            : '<span class="badge bg-secondary">Tidak Aktif</span>';

                        var actionBtn = role.status
                            ? ''
                            : '<button type="button" class="btn btn-sm btn-outline-primary btn-jadikan-aktif" data-idrole="' + role.idrole + '">Jadikan Aktif</button>';

                        return '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                            '<span>' + escapeHtml(role.nama_role) + ' ' + badge + '</span>' +
                            actionBtn +
                            '</li>';
                    }).join('');
                }

                function renderDetail(data) {
                    modalEl.querySelector('.detail-nama').value = data.pengguna.nama || '';
                    modalEl.querySelector('.detail-email').value = data.pengguna.email || '';
                    modalEl.querySelector('.detail-no-wa').value = data.pengguna.no_wa || '';
                    modalEl.querySelector('.detail-institusi').value = data.pengguna.nama_institusi || '-';
                    modalEl.querySelector('.detail-created-at').value = data.pengguna.created_at || '-';
                    modalEl.querySelector('.detail-status-akun').value = data.pengguna.is_deleted ? 'Dihapus' : 'Aktif';

                    renderRoles(data.roles);
                }

                function loadDetail(idpengguna, token) {
                    currentIdpengguna = idpengguna;
                    loadingEl.classList.remove('d-none');
                    contentEl.classList.add('d-none');
                    hideModalAlert(modalEl);

                    fetch(detailUrl + '?token=' + encodeURIComponent(token))
                        .then(function (response) {
                            return response.json().then(function (body) {
                                return { ok: response.ok, body: body };
                            });
                        })
                        .then(function (result) {
                            loadingEl.classList.add('d-none');

                            if (result.ok) {
                                contentEl.classList.remove('d-none');
                                renderDetail(result.body.data);
                            } else {
                                showModalAlert(modalEl, 'danger', result.body.message || 'Gagal mengambil detail pengguna.');
                            }
                        })
                        .catch(function () {
                            loadingEl.classList.add('d-none');
                            showModalAlert(modalEl, 'danger', 'Gagal mengambil detail pengguna. Silakan coba lagi.');
                        });
                }

                document.addEventListener('click', function (e) {
                    var trigger = e.target.closest('[data-action^="detail-"]');

                    if (!trigger) {
                        return;
                    }

                    e.preventDefault();
                    loadDetail(trigger.getAttribute('data-idpengguna'), trigger.getAttribute('data-token'));

                    var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalInstance.show();
                });

                rolesListEl.addEventListener('click', function (e) {
                    var btn = e.target.closest('.btn-jadikan-aktif');

                    if (!btn || btn.disabled) {
                        return;
                    }

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                    hideModalAlert(modalEl);

                    fetch(ubahRoleAktifUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            idpengguna: currentIdpengguna,
                            idrole: btn.getAttribute('data-idrole'),
                        }),
                    })
                        .then(function (response) {
                            return response.json().then(function (body) {
                                return { ok: response.ok, body: body };
                            });
                        })
                        .then(function (result) {
                            if (result.ok) {
                                renderRoles(result.body.data.roles);
                                showModalAlert(modalEl, 'success', result.body.message);
                            } else {
                                showModalAlert(modalEl, 'danger', result.body.message || 'Gagal mengubah role aktif.');
                                btn.disabled = false;
                                btn.textContent = 'Jadikan Aktif';
                            }
                        })
                        .catch(function () {
                            showModalAlert(modalEl, 'danger', 'Gagal mengubah role aktif. Silakan coba lagi.');
                            btn.disabled = false;
                            btn.textContent = 'Jadikan Aktif';
                        });
                });

                modalEl.addEventListener('hidden.bs.modal', function () {
                    currentIdpengguna = null;
                    hideModalAlert(modalEl);
                });
            }

            function initModalEditPengguna() {
                var modalEl = document.getElementById('modal-edit-pengguna');
                var form = modalEl.querySelector('.form-edit-pengguna');
                var loadingEl = modalEl.querySelector('.edit-loading');
                var contentEl = modalEl.querySelector('.edit-content');
                var namaInput = modalEl.querySelector('.edit-nama');
                var emailInput = modalEl.querySelector('.edit-email');
                var noWaInput = modalEl.querySelector('.edit-no-wa');
                var createdAtInput = modalEl.querySelector('.edit-created-at');
                var statusInput = modalEl.querySelector('.edit-status-akun');
                var btnSubmit = modalEl.querySelector('.btn-submit-edit-pengguna');
                var btnResetPassword = modalEl.querySelector('.btn-reset-password');

                var currentIdpengguna = null;
                var noWaFromDb = null;

                function resetSubmitButton() {
                    btnSubmit.disabled = false;
                    btnSubmit.querySelector('.btn-label').textContent = 'Simpan';
                }

                function resetResetPasswordButton() {
                    btnResetPassword.disabled = false;
                    btnResetPassword.innerHTML = '<i class="fa-solid fa-key me-1"></i> Reset Password';
                }

                function loadDetail(idpengguna, token) {
                    currentIdpengguna = idpengguna;
                    loadingEl.classList.remove('d-none');
                    contentEl.classList.add('d-none');
                    btnSubmit.disabled = true;
                    hideModalAlert(modalEl);

                    fetch(detailUrl + '?token=' + encodeURIComponent(token))
                        .then(function (response) {
                            return response.json().then(function (body) {
                                return { ok: response.ok, body: body };
                            });
                        })
                        .then(function (result) {
                            loadingEl.classList.add('d-none');

                            if (result.ok) {
                                var data = result.body.data.pengguna;

                                namaInput.value = data.nama || '';
                                emailInput.value = data.email || '';
                                noWaInput.value = data.no_wa || '';
                                createdAtInput.value = data.created_at || '-';
                                statusInput.value = data.is_deleted ? 'Dihapus' : 'Aktif';
                                noWaFromDb = data.no_wa || '';

                                contentEl.classList.remove('d-none');
                                btnSubmit.disabled = false;
                            } else {
                                showModalAlert(modalEl, 'danger', result.body.message || 'Gagal mengambil data pengguna.');
                            }
                        })
                        .catch(function () {
                            loadingEl.classList.add('d-none');
                            showModalAlert(modalEl, 'danger', 'Gagal mengambil data pengguna. Silakan coba lagi.');
                        });
                }

                document.addEventListener('click', function (e) {
                    var trigger = e.target.closest('[data-action^="edit-"]');

                    if (!trigger) {
                        return;
                    }

                    e.preventDefault();
                    loadDetail(trigger.getAttribute('data-idpengguna'), trigger.getAttribute('data-token'));

                    var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalInstance.show();
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if (btnSubmit.disabled) {
                        return;
                    }

                    btnSubmit.disabled = true;
                    btnSubmit.querySelector('.btn-label').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                    hideModalAlert(modalEl);

                    var payload = {
                        idpengguna: currentIdpengguna,
                        nama: namaInput.value.trim(),
                        no_wa: noWaInput.value.trim(),
                    };

                    fetch(updatePenggunaUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(payload),
                    })
                        .then(function (response) {
                            return response.json().then(function (body) {
                                return { ok: response.ok, body: body };
                            });
                        })
                        .then(function (result) {
                            if (result.ok) {
                                namaInput.value = result.body.data.nama;
                                noWaInput.value = result.body.data.no_wa;
                                noWaFromDb = result.body.data.no_wa;

                                updatePenggunaRowEverywhere(currentIdpengguna, result.body.data.nama, result.body.data.no_wa);

                                var modalInstance = bootstrap.Modal.getInstance(modalEl);

                                if (modalInstance) {
                                    modalInstance.hide();
                                }

                                showPageAlert('success', result.body.message);
                                resetSubmitButton();
                            } else {
                                showModalAlert(modalEl, 'danger', result.body.message || 'Gagal memperbarui data pengguna.');
                                resetSubmitButton();
                            }
                        })
                        .catch(function () {
                            showModalAlert(modalEl, 'danger', 'Gagal memperbarui data pengguna. Silakan coba lagi.');
                            resetSubmitButton();
                        });
                });

                btnResetPassword.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Reset Password?',
                        text: 'Password akan dikirim ke no WA ' + noWaFromDb,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, reset',
                        cancelButtonText: 'Batal',
                    }).then(function (result) {
                        if (!result.isConfirmed) {
                            return;
                        }

                        btnResetPassword.disabled = true;
                        btnResetPassword.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                        hideModalAlert(modalEl);

                        fetch(resetPasswordUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({ idpengguna: currentIdpengguna }),
                        })
                            .then(function (response) {
                                return response.json().then(function (body) {
                                    return { ok: response.ok, body: body };
                                });
                            })
                            .then(function (result) {
                                console.log(result);
                                if (result.ok) {
                                    showModalAlert(modalEl, 'success', result.body.message);
                                } else {
                                    showModalAlert(modalEl, 'danger', result.body.message || 'Gagal mereset password.');
                                }

                                resetResetPasswordButton();
                            })
                            .catch(function () {
                                showModalAlert(modalEl, 'danger', 'Gagal mereset password. Silakan coba lagi.');
                                resetResetPasswordButton();
                            });
                    });
                });

                modalEl.addEventListener('hidden.bs.modal', function () {
                    currentIdpengguna = null;
                    noWaFromDb = null;
                    form.reset();
                    hideModalAlert(modalEl);
                });
            }

            function initUserRoleBox(boxId) {
                var dataTable = $('#table-users-' + boxId).DataTable({
                    dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    buttons: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                className: 'btn btn-outline-success btn-sm',
                                text: '<i class="fa-solid fa-file-excel me-1"></i>Excel',
                                exportOptions: { columns: [0, 1, 2] },
                            },
                        ],
                    },
                    lengthMenu: [10, 25, 50],
                    pageLength: 10,
                    columnDefs: [{ orderable: false, targets: -1 }],
                });

                dataTables[boxId] = dataTable;

                initModalUserBaru(boxId, dataTable);
                initModalUserLama(boxId, dataTable);
            }

            function initModalUserBaru(boxId, dataTable) {
                var modalEl = document.getElementById('modal-user-baru-' + boxId);
                var form = modalEl.querySelector('.form-user-baru');
                var emailInput = modalEl.querySelector('.input-email');
                var emailConfirmationInput = modalEl.querySelector('.input-email-confirmation');
                var emailMatchHint = modalEl.querySelector('.email-match-hint');
                var btnSubmit = modalEl.querySelector('.btn-submit-user-baru');
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                var isEmailMatch = false;
                var isWaMatch = false;

                function updateSubmitState() {
                    btnSubmit.disabled = !(isEmailMatch && isWaMatch);
                }

                function validateEmailMatch() {
                    var email = emailInput.value.trim();
                    var confirmation = emailConfirmationInput.value.trim();
                    var isValidEmail = emailRegex.test(email);
                    isEmailMatch = isValidEmail && email === confirmation;

                    if (confirmation.length === 0) {
                        emailMatchHint.textContent = '';
                    } else if (!isEmailMatch) {
                        emailMatchHint.textContent = 'Email tidak sama.';
                        emailMatchHint.style.color = '#e7515a';
                    } else {
                        emailMatchHint.textContent = 'Email cocok.';
                        emailMatchHint.style.color = '#00ab55';
                    }

                    updateSubmitState();
                }

                emailInput.addEventListener('input', validateEmailMatch);
                emailConfirmationInput.addEventListener('input', validateEmailMatch);
                emailConfirmationInput.addEventListener('paste', function (e) {
                    e.preventDefault();
                });

                var noWaInput = modalEl.querySelector('.input-no-wa');
                var noWaConfirmationInput = modalEl.querySelector('.input-no-wa-confirmation');
                var waMatchHint = modalEl.querySelector('.wa-match-hint');
                var waRegex = /^0[0-9]{9,14}$/;

                function validateWaMatch() {
                    var noWa = noWaInput.value.trim();
                    var confirmation = noWaConfirmationInput.value.trim();
                    var isValidWa = waRegex.test(noWa);
                    isWaMatch = isValidWa && noWa === confirmation;

                    if (confirmation.length === 0) {
                        waMatchHint.textContent = '';
                    } else if (!isWaMatch) {
                        waMatchHint.textContent = 'Nomor WhatsApp tidak sama.';
                        waMatchHint.style.color = '#e7515a';
                    } else {
                        waMatchHint.textContent = 'Nomor WhatsApp cocok.';
                        waMatchHint.style.color = '#00ab55';
                    }

                    updateSubmitState();
                }

                noWaInput.addEventListener('input', validateWaMatch);
                noWaConfirmationInput.addEventListener('input', validateWaMatch);
                noWaConfirmationInput.addEventListener('paste', function (e) {
                    e.preventDefault();
                });

                modalEl.addEventListener('show.bs.modal', function () {
                    form.reset();
                    emailMatchHint.textContent = '';
                    waMatchHint.textContent = '';
                    isEmailMatch = false;
                    isWaMatch = false;
                    btnSubmit.disabled = true;
                    btnSubmit.querySelector('.btn-label').textContent = 'Tambah Pengguna';
                    hideModalAlert(modalEl);
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if (btnSubmit.disabled) {
                        return;
                    }

                    btnSubmit.disabled = true;
                    btnSubmit.querySelector('.btn-label').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                    hideModalAlert(modalEl);

                    var payload = {
                        boxId: boxId,
                        nama: form.querySelector('[name="nama"]').value.trim(),
                        email: emailInput.value.trim(),
                        no_wa: noWaInput.value.trim(),
                    };

                    function resetSubmitButton() {
                        btnSubmit.disabled = false;
                        btnSubmit.querySelector('.btn-label').textContent = 'Tambah Pengguna';
                    }

                    fetch(tambahBaruUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(payload),
                    })
                        .then(function (response) {
                            return response.json().then(function (body) {
                                return { ok: response.ok, body: body };
                            });
                        })
                        .then(function (result) {
                            if (result.ok) {
                                var idpengguna = result.body.data.idpengguna;
                                var token = result.body.data.token;

                                dataTable.row.add([
                                    escapeHtml(payload.nama.toUpperCase()),
                                    escapeHtml(payload.email),
                                    escapeHtml(payload.no_wa),
                                    '<a href="javascript:void(0);" class="btn btn-sm btn-outline-info" title="Lihat Detail" data-action="detail-' + boxId + '" data-idpengguna="' + idpengguna + '" data-token="' + token + '"><i class="fa-solid fa-eye"></i></a> ' +
                                        '<a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" title="Edit" data-action="edit-' + boxId + '" data-idpengguna="' + idpengguna + '" data-token="' + token + '"><i class="fa-solid fa-pen"></i></a>',
                                ]).draw(false);

                                var modalInstance = bootstrap.Modal.getInstance(modalEl);

                                if (modalInstance) {
                                    modalInstance.hide();
                                }

                                showPageAlert('success', result.body.message);
                                resetSubmitButton();
                            } else {
                                showModalAlert(modalEl, 'danger', result.body.message || 'Gagal menambahkan pengguna.');
                                resetSubmitButton();
                            }
                        })
                        .catch(function () {
                            showModalAlert(modalEl, 'danger', 'Gagal menambahkan pengguna. Silakan coba lagi.');
                            resetSubmitButton();
                        });
                });
            }

            function initModalUserLama(boxId, dataTable) {
                var modalEl = document.getElementById('modal-user-lama-' + boxId);
                var form = modalEl.querySelector('.form-user-lama');
                var selectEl = document.getElementById('select-pengguna-lama-' + boxId);
                var btnSubmit = modalEl.querySelector('.btn-submit-user-lama');

                var tomSelectInstance = new TomSelect(selectEl, {
                    valueField: 'idpengguna',
                    labelField: 'nama',
                    searchField: ['nama', 'email'],
                    options: [],
                    create: false,
                    placeholder: 'Ketik nama pengguna...',
                    load: function (query, callback) {
                        if (!query.length) {
                            return callback();
                        }

                        fetch(searchPenggunaUrl + '?q=' + encodeURIComponent(query))
                            .then(function (response) { return response.json(); })
                            .then(function (data) { callback(data); })
                            .catch(function () { callback(); });
                    },
                    render: {
                        option: function (item, escape) {
                            return '<div><strong>' + escape(item.nama) + '</strong><br><small>' + escape(item.email) + '</small></div>';
                        },
                        item: function (item, escape) {
                            return '<div>' + escape(item.nama) + '</div>';
                        },
                    },
                    onChange: function (value) {
                        if (!value) {
                            form.reset();
                            btnSubmit.disabled = true;

                            return;
                        }

                        var data = this.options[value];

                        form.querySelector('[name="idpengguna"]').value = data.idpengguna;
                        form.querySelector('[name="nama"]').value = data.nama;
                        form.querySelector('[name="email"]').value = data.email;
                        form.querySelector('[name="no_wa"]').value = data.no_wa || '';

                        btnSubmit.disabled = false;
                    },
                });

                modalEl.addEventListener('show.bs.modal', function () {
                    form.reset();
                    tomSelectInstance.clear(true);
                    btnSubmit.disabled = true;
                    btnSubmit.querySelector('.btn-label').textContent = 'Tambah Pengguna';
                    hideModalAlert(modalEl);
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if (btnSubmit.disabled) {
                        return;
                    }

                    btnSubmit.disabled = true;
                    btnSubmit.querySelector('.btn-label').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                    hideModalAlert(modalEl);

                    var payload = {
                        boxId: boxId,
                        idpengguna: form.querySelector('[name="idpengguna"]').value,
                    };

                    var nama = form.querySelector('[name="nama"]').value;
                    var email = form.querySelector('[name="email"]').value;
                    var noWa = form.querySelector('[name="no_wa"]').value;

                    function resetSubmitButton() {
                        btnSubmit.disabled = false;
                        btnSubmit.querySelector('.btn-label').textContent = 'Tambah Pengguna';
                    }

                    fetch(tambahLamaUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(payload),
                    })
                        .then(function (response) {
                            return response.json().then(function (body) {
                                return { ok: response.ok, body: body };
                            });
                        })
                        .then(function (result) {
                            if (result.ok) {
                                var token = result.body.data.token;

                                dataTable.row.add([
                                    escapeHtml(nama),
                                    escapeHtml(email),
                                    escapeHtml(noWa),
                                    '<a href="javascript:void(0);" class="btn btn-sm btn-outline-info" title="Lihat Detail" data-action="detail-' + boxId + '" data-idpengguna="' + payload.idpengguna + '" data-token="' + token + '"><i class="fa-solid fa-eye"></i></a> ' +
                                        '<a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" title="Edit" data-action="edit-' + boxId + '" data-idpengguna="' + payload.idpengguna + '" data-token="' + token + '"><i class="fa-solid fa-pen"></i></a>',
                                ]).draw(false);

                                var modalInstance = bootstrap.Modal.getInstance(modalEl);

                                if (modalInstance) {
                                    modalInstance.hide();
                                }

                                showPageAlert('success', result.body.message);
                                resetSubmitButton();
                            } else {
                                showModalAlert(modalEl, 'danger', result.body.message || 'Gagal menambahkan role pengguna.');
                                resetSubmitButton();
                            }
                        })
                        .catch(function () {
                            showModalAlert(modalEl, 'danger', 'Gagal menambahkan role pengguna. Silakan coba lagi.');
                            resetSubmitButton();
                        });
                });
            }
        });
    </script>
@endsection
