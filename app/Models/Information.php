<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        'sentence',
        'title',
        'address',
        'email',
        'phone',
        'facebook',
        'instagram',
        'x',
        'linkedin',
        'note',
    ];

    public static function rules()
    {
        return [
            'sentence' => 'nullable',
            'title' => 'nullable',
            'address' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'x' => 'nullable',
            'linkedin' => 'nullable',
            'note' => 'nullable',
        ];
    }
}
