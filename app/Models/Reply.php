<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'form_id',
        'message',
        'note',
    ];

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('packages.name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false) {
            if ($filters['status'] != 'all') {
                $builder->where('packages.status', '=', $filters['status']);
            }
        }
    }

    public static function rules()
    {
        return [
            'user_id' => 'required',
            'form_id' => 'required',
            'message' => 'required',
            'note' => 'nullable',
        ];
    }

    public function form()
    {
        return $this->belongsTo(Form::class)->withDefault();
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
