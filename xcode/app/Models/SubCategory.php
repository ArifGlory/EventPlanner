<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class SubCategory extends Model
{

    use LogsActivity;
    use HasFactory;



    const TABLE = 'master_sub_category';
    const PRIMARYKEY = 'subcategory_id';
    const FIELDSTATUS = 'subcategory_status';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'subcategory_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('xpoint')
            ->logOnly(['subkategori', 'status'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "subkategori {$this->kategori} {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }

    public function scopeActive($query)
    {
        $query->select('subcategory_id', 'subcategory_name')->where('subcategory_status', 1)->orderBy('subcategory_name', 'ASC');
    }



}
