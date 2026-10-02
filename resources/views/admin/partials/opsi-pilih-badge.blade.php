{{--
    Badge untuk kolom opsi_pilih acara.
    Expected variable: $opsi (string|null) — '1' none, '2' opsional, '3' wajib.
--}}
@switch($opsi)
    @case('2')
        <span class="badge bg-info">Opsional</span>
        @break
    @case('3')
        <span class="badge bg-danger">Wajib</span>
        @break
    @default
        <span class="badge bg-secondary">Tidak Bisa Dipilih</span>
@endswitch
