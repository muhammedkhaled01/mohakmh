<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'subject',
        'purpos',
        'message',
        'reply',
        'user_id',
        'note',
    ];

    // local scope for search
    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['firstName'] ?? false) {
            $builder->where('forms.firstName', 'LIKE', "%{$filters['firstName']}%");
        }
        /* if ($filters['reply'] ?? false) {
            if ($filters['reply'] != 'all') {
                $builder->where('forms.reply', $filters['reply']);
            }
        } */
    }

    public static function rules()
    {
        return [
            'firstName' => 'nullable',
            'lastName' => 'nullable',
            'email' => 'nullable',
            'subject' => 'nullable',
            'purpos' => 'nullable',
            'message' => 'nullable',
            'note' => 'nullable',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
