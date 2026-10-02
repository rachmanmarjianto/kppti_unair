{{--
    Modal verifikasi teks peringatan (reusable): peserta harus mengetik ulang
    persis $teksPeringatan (tanpa bisa paste) sebelum tombol konfirmasi aktif.

    Expected variables:
    - string $id             id HTML modal ini (tanpa "#")
    - string $judul          judul modal
    - string $teksPeringatan teks yang harus diketik ulang persis
--}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $judul }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="verifikasi-ringkasan mb-3"></div>

                <p>
                    Untuk melanjutkan, ketik ulang persis teks berikut (tidak bisa ditempel/paste):
                </p>
                <p class="fw-bold">{{ $teksPeringatan }}</p>

                <input type="text" class="form-control input-verifikasi-teks" autocomplete="off" data-teks-peringatan="{{ $teksPeringatan }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-konfirmasi-verifikasi" disabled>
                    <span class="btn-label">Konfirmasi & Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>
