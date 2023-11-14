<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'email_verified_code',
        'email_verified_code_times',
        'email_verified_login_code',
        'password',
        'phone_number',
        'image',
        'job',
        'package_id',
        'package_start_at',
        'package_end_at',
        'role',
        'note',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_code',
        'email_verified_code_times',
        'email_verified_login_code',
    ];

    protected $dates = ['package_end_at' , 'package_start_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'package_end_at' => 'datetime',
        'package_start_at' => 'datetime',
    ];

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('users.name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false) {
            if ($filters['status'] != 'all') {
                $builder->where('users.status', '=', $filters['status']);
            }
        }
    }

    public static function rules($id = 0)
    {
        $passwordRules = $id === 0 ? 'required|string|min:8' : 'nullable|string|min:8';
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email' => "required|unique:users,email,$id|email",
            'password' => $passwordRules,
            'phone_number' => "required|unique:users,phone_number,$id|phone_with_country_code", // لقد اضفت هذا الفلتر في app service provider
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'package_id' => 'nullable',
            'package_start_at' => 'date',
            'package_end_at' => 'date',
            'job' => 'nullable|string',
            'note' => 'nullable|string',
            'role' => 'in:user,admin,super-admin',
            'status' => 'required|in:active,archived',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function forms()
    {
        return $this->hasMany(Form::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault();
    }

    public function getImageAttribute($value)
    {
        return url('storage/' . $value);
    }
    public function languages()
    {
        return $this->hasMany(Language::class);
    }
    public function transactionsMoyasar()
    {
        return $this->hasMany(transactionsMoyasar::class);
    }
}
