{{--
    Reusable "role box" widget: a DataTable of pengguna holding the role,
    plus modals to add a brand-new pengguna or attach an existing one to the role.

    Expected variables:
    - string $boxId    unique slug used to namespace element ids (e.g. "admin", "sc")
    - string $boxTitle heading shown on the widget (e.g. "Admin Users")
    - \Illuminate\Support\Collection $users  rows with idpengguna, nama, email, no_wa
--}}
<div class="col-lg-12 col-md-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row align-items-center">
                <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                    <h4>{{ $boxTitle }}</h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                    <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modal-user-baru-{{ $boxId }}">
                        <i class="fa-solid fa-user-plus me-1"></i> Pengguna Baru
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-user-lama-{{ $boxId }}">
                        <i class="fa-solid fa-user-check me-1"></i> Pengguna Lama
                    </button>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table id="table-users-{{ $boxId }}" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. WA</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_wa ?? '-' }}</td>
                                <td class="text-center text-nowrap">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-info" title="Lihat Detail" data-action="detail-{{ $boxId }}" data-idpengguna="{{ $user->idpengguna }}" data-token="{{ $user->token }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" title="Edit" data-action="edit-{{ $boxId }}" data-idpengguna="{{ $user->idpengguna }}" data-token="{{ $user->token }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger" title="Hapus Role" data-action="hapus-{{ $boxId }}" data-idpengguna="{{ $user->idpengguna }}" data-nama="{{ $user->nama }}">
                                        <i class="fa-solid fa-user-minus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal: tambah pengguna baru (belum ada di tabel pengguna) --}}
<div class="modal fade" id="modal-user-baru-{{ $boxId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-user-baru" data-box="{{ $boxId }}">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Baru &ndash; {{ $boxTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="mb-3">
                        <label class="form-label" for="nama-baru-{{ $boxId }}">Nama</label>
                        <input type="text" id="nama-baru-{{ $boxId }}" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email-baru-{{ $boxId }}">Email</label>
                        <input type="text" id="email-baru-{{ $boxId }}" name="email" class="form-control input-email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email-confirmation-baru-{{ $boxId }}">Ulangi Email</label>
                        <input type="text" id="email-confirmation-baru-{{ $boxId }}" name="email_confirmation" class="form-control input-email-confirmation" autocomplete="off" required>
                        <div class="email-match-hint mt-1" style="font-size: 12.5px;"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="no_wa-baru-{{ $boxId }}">Nomor WhatsApp</label>
                        <input type="text" id="no_wa-baru-{{ $boxId }}" name="no_wa" class="form-control input-no-wa" inputmode="numeric" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="no_wa-confirmation-baru-{{ $boxId }}">Ulangi Nomor WhatsApp</label>
                        <input type="text" id="no_wa-confirmation-baru-{{ $boxId }}" name="no_wa_confirmation" class="form-control input-no-wa-confirmation" inputmode="numeric" autocomplete="off" required>
                        <div class="wa-match-hint mt-1" style="font-size: 12.5px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit-user-baru" disabled>
                        <span class="btn-label">Tambah Pengguna</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: tambah pengguna lama (sudah ada di tabel pengguna) --}}
<div class="modal fade" id="modal-user-lama-{{ $boxId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-user-lama" data-box="{{ $boxId }}">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Lama &ndash; {{ $boxTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="mb-3">
                        <label class="form-label" for="select-pengguna-lama-{{ $boxId }}">Cari Pengguna</label>
                        <select id="select-pengguna-lama-{{ $boxId }}" class="form-select select-pengguna-lama" placeholder="Ketik nama pengguna..."></select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ID Pengguna</label>
                        <input type="text" name="idpengguna" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. WA</label>
                        <input type="text" name="no_wa" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit-user-lama" disabled>
                        <span class="btn-label">Tambah Pengguna</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
