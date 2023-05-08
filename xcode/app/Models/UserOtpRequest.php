<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtpRequest extends Model
{
    use HasFactory;
    protected $table = 'user_otp_request';
    protected $primaryKey = 'id_otp';
    protected $guarded = [];
    public $timestamps = false;


}
