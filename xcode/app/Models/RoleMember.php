<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMember extends Model
{
    use HasFactory;
    protected $table = 'role_member';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;


}
