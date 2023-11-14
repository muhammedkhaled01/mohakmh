<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'image',
        'parent_id',
        'note',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => '-'
        ]); // '-' لان عند استدعاء قسم رئيسة سيعطي شرطة وليس فارغ
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('categories.name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false) {
            if ($filters['status'] != 'all') {
                $builder->where('categories.status', '=', $filters['status']);
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
                "unique:categories,name,$id", // $id ليستثني نفسه من الفحص
                // custome rule (filter)
                /*  function ($attribute, $value, $fails) {
                    if (strtolower($value) == 'laravel') {
                        $fails('this name is forbidden!');
                    }
                } */
                'filter:php,laravel,admin'
                //new Filter(['laravel', 'admin', 'php']),
            ],
            'parent_id' => 'nullable|int|exists:categories,id',
            'note' => 'nullable',
            'status' => 'required|in:active,archived',
        ];
    }
}
