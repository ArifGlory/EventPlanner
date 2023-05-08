<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class LogSaldoPoint extends Model
{

    use LogsActivity;
    use HasFactory;
    use SoftDeletes;


    const TABLE = 'log_saldo_point';
    const PRIMARYKEY = 'log_saldo_id';
    const FIELDSTATUS = 'log_saldo_status';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'log_saldo_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_saldo_point')
            ->logOnly(['log_saldo_nominal', 'log_saldo_status','log_saldo_description'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "log saldo {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('name', 'email', 'id','wallet_address');
    }




}
