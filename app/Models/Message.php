<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'text',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public static function rules()
    {
        return [
            'text' => 'required',
            'updated_by' => 'nullable',
        ];
    }
}
