<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'package_id',
        'start_at',
        'end_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function package()
    {
        return $this->belongsTo(Package::class)->withDefault();
    }


    public static function rules()
    {
        return [
            'user_id' => 'nullable|int|exists:users,id',
            'package_id' => 'nullable|int|exists:users,id',
            'start_at' => 'nullable',
            'end_at' => 'nullable',
        ];
    }
}
