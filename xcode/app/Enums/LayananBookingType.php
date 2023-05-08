<?php
namespace App\Enums;

enum LayananBookingType: string {
    case vaksin = 'Vaksinasi';
    case pengobatan = 'Pengobatan';
    case operasi = 'Tindakan Operasi';
}
