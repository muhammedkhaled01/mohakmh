<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'new_price',
        'duration',
        'free_duration',
        'subscribers',
        'note',
        'status',
    ];

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('packages.name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false) {
            if ($filters['status'] == 0 || $filters['status'] == 1) {
                $builder->where('packages.status', '=', $filters['status']);
            }
        }
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                "unique:packages,name,$id", // $id ليستثني نفسه من الفحص
            ],
            'price' => 'required|int',
            'new_price' => 'nullable|int',
            'duration' => 'required|int',
            'free_duration' => 'nullable|int',
            'note' => 'nullable',
            'status' => 'required|in:active,archived',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function advantages()
    {
        return $this->hasMany(Advantage::class);
    }
}
