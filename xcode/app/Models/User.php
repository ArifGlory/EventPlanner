<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use LogsActivity;
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;


    const PRIMARYKEY = 'id';
    const FIELDSTATUS = 'status';
    const TABLE = 'users';
    protected $table = 'users';
    protected $primaryKey = self::PRIMARYKEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
//    protected $fillable = [
//        'username',
//        'name',
//        'email',
//        'password',
//        'avatar',
//        'is_active',
//    ];
    //protected static $logFillable = true;

    protected $guarded = [
        'id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user')
            ->logOnly(['name', 'email', 'avatar'])
            ->logOnlyDirty(true)
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent
            (fn(string $eventName) => "pengguna {$this->name} {$eventName}"
            )
            ->dontSubmitEmptyLogs();
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsToMany(
            Role::class,
            'user_has_role',
            'user_id',
            'role_id',
            'id',
            'id_role'
        );
    }

    /*public function role()
    {
        return $this->hasManyDeepFromRelations($this->member(), (new Member())->role());
    }*/

}
