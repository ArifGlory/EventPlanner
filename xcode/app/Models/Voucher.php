<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Voucher extends Model
{

    use LogsActivity;
    use HasFactory;
    use SoftDeletes;


    const TABLE = 'voucher';
    const PRIMARYKEY = 'voucher_id';
    const FIELDSTATUS = 'coupon_status';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'voucher_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('voucher')
            ->logOnly(['voucher_name', 'voucher_id'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "voucher {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id', 'store_id')->select('store_id', 'store_name', 'store_url');
    }




}
