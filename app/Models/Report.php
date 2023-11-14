<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'note',
    ];

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('reports.name', 'LIKE', "%{$filters['name']}%");
        }
    }

    public static function rules()
    {
        return [
            'name' => ['required', 'string'],
            'note' => 'nullable',
        ];
    }

    public static function filePath($path)
    {
        return response()->file($path, ['content-type' => 'application/pdf']);;
    }



    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
