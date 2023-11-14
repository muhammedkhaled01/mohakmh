<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'category_id',
        'paid',
        'file',
        'description',
        'note',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
    public function bookimages()
    {
        return $this->hasMany(BookImage::class, 'book_id', 'id');
    }

    public function firstImage()
    {
        return $this->bookimages()->one()->withDefault();
    }

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('books.name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false) {
            if ($filters['status'] != 'all') {
                $builder->where('books.status', '=', $filters['status']);
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
                "unique:books,name,$id", // $id ليستثني نفسه من الفحص
                'filter:php,laravel,admin'
            ],
            'file' => 'required|file|mimes:pdf|max:512000', // 5MB
            'category_id' => 'required|int|exists:categories,id',
            'subCategory_id' => 'required|int',
            'description' => 'nullable',
            'paid' => 'nullable',
            'note' => 'nullable',
            'status' => 'required',
        ];
    }
}
