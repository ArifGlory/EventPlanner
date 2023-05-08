<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Submission extends Model
{

    use LogsActivity;
    use HasFactory;


    const TABLE = 'mission_submission';
    const PRIMARYKEY = 'submission_id';
    const FIELDSTATUS = 'submission_status';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'submission_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('submission')
            //->logOnly(['submission', 'mission_id'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "submission {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }



}
