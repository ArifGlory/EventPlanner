<?php
namespace App\Enums;

enum LayananBookingStatus: string {
    case scheduled = 'Scheduled';
    case check_in = 'Check in';
    case process = 'Process';
    case done = 'Done';
}
