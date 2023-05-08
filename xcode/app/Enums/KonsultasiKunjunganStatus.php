<?php
namespace App\Enums;

enum KonsultasiKunjunganStatus: string {
    case scheduled = 'Dijadwalkan';
    case on_proses = 'Sedang Diproses';
    case declined = 'Ditolak';
    case done = 'Selesai';
}
