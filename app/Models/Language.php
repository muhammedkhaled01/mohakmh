<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }


    public static function rules()
    {
        return [
            'user_id' => 'nullable|int|exists:users,id',
            'name' => 'nullable',
            'level' => 'nullable',
        ];
    }
}
