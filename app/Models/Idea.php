<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'idea_paragraph',
        'image',
        'vision_paragraph',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public static function rules()
    {
        return [
            'idea_paragraph' => 'required',
            'image' => 'required',
            'vision_paragraph' => 'required',
            'updated_by' => 'nullable',
        ];
    }
}
