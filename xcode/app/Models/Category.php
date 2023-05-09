<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Category extends Model
{

    use LogsActivity;
    use HasFactory,SoftDeletes;



    const TABLE = 'category';
    const PRIMARYKEY = 'id';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('xpoint')
            ->logOnly(['category_name'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "kategori {$this->kategori} {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }




}
