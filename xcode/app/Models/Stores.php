<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Stores extends Model
{

    use LogsActivity;
    use HasFactory;
    use SoftDeletes;



    const TABLE = 'store';
    const PRIMARYKEY = 'store_id';
    const FIELDSTATUS = 'status';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'store_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('stores')
            ->logOnly(['store_name', 'store_id'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "stores {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->select('id', 'name', 'email');
    }




}
