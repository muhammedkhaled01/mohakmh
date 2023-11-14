<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name_en',
        'gender',
        'birthdate',
        'whatsapp',
        'nationality',
        'residence_country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }


    public static function rules()
    {
        return [
            'user_id' => 'nullable|int|exists:users,id',
            'name_en' => 'nullable',
            'birthdate' => 'nullable',
            'whatsapp' => 'nullable',
            'nationality' => 'nullable',
            'residence_country' => 'nullable',
        ];
    }
}
