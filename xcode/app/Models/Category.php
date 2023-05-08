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



    const TABLE = 'master_category';
    const PRIMARYKEY = 'category_id';
    const FIELDSTATUS = 'category_status';
    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'category_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('xpoint')
            ->logOnly(['kategori', 'status'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "kategori {$this->kategori} {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }

    public function scopeActive($query)
    {
        $query->select('category_id', 'category_name')->where('category_status', 1)->orderBy('category_name', 'ASC');
    }

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'category_id');
    }



}
