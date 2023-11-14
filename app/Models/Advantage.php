<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advantage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'package_id',
        'text',
        'updated_by',
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
            'package_id' => 'required',
            'text' => 'required',
            'updated_by' => 'nullable',
        ];
    }
}
