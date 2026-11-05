<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:generate-slot-pertemuan-mou')]
#[Description('Isi pertemuan_mou dengan slot kombinasi tanggal x sesi x ruang (sejumlah kapasitas ruang) sebagai penanda slot yang available untuk penjadwalan MoU.')]
class GenerateSlotPertemuanMou extends Command
{
    /**
     * Isi pertemuan_mou dengan semua kombinasi idtanggal_mou (hanya yang
     * status aktif) x idsesi_mou x idruang_mou — sebanyak kapasitas tiap
     * ruang (isi_ke = 1..kapasitas). idpengajuan_mou dibiarkan NULL,
     * menandai slot ini masih available untuk dibooking (F21). Idempotent —
     * kombinasi yang sudah ada dilewati, aman dijalankan ulang setelah
     * tanggal_mou/sesi_mou/ruang_mou baru ditambahkan.
     */
    public function handle(): int
    {
        $tanggalAktifList = DB::table('tanggal_mou')->where('status', true)->get();
        $sesiList = DB::table('sesi_mou')->get();
        $ruangList = DB::table('ruang_mou')->get();

        if ($tanggalAktifList->isEmpty() || $sesiList->isEmpty() || $ruangList->isEmpty()) {
            $this->error('Data master tanggal_mou (aktif)/sesi_mou/ruang_mou belum lengkap.');

            return self::FAILURE;
        }

        $existing = DB::table('pertemuan_mou')
            ->select('idtanggal_mou', 'idsesi_mou', 'idruang_mou', 'isi_ke')
            ->get()
            ->map(fn ($baris) => "{$baris->idtanggal_mou}-{$baris->idsesi_mou}-{$baris->idruang_mou}-{$baris->isi_ke}")
            ->flip()
            ->all();

        $barisBaru = [];

        foreach ($tanggalAktifList as $tanggal) {
            foreach ($sesiList as $sesi) {
                foreach ($ruangList as $ruang) {
                    for ($isiKe = 1; $isiKe <= $ruang->kapasitas; $isiKe++) {
                        $kunci = "{$tanggal->idtanggal_mou}-{$sesi->idsesi_mou}-{$ruang->idruang_mou}-{$isiKe}";

                        if (isset($existing[$kunci])) {
                            continue;
                        }

                        $barisBaru[] = [
                            'idtanggal_mou' => $tanggal->idtanggal_mou,
                            'idsesi_mou' => $sesi->idsesi_mou,
                            'idruang_mou' => $ruang->idruang_mou,
                            'isi_ke' => $isiKe,
                        ];
                    }
                }
            }
        }

        if (empty($barisBaru)) {
            $this->info('Semua slot pertemuan MoU sudah tersedia, tidak ada yang ditambahkan.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($barisBaru) {
            foreach (array_chunk($barisBaru, 500) as $chunk) {
                DB::table('pertemuan_mou')->insert($chunk);
            }
        });

        $this->info(count($barisBaru).' slot pertemuan MoU berhasil dibuat.');

        return self::SUCCESS;
    }
}
