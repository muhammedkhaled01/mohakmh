<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'user_id',
        'price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('transactions.bank_name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['status'] ?? false) {
            if ($filters['status'] != 'all') {
                $builder->where('transactions.status', '=', $filters['status']);
            }
        }
    }
}
