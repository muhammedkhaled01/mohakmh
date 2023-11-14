<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunicationForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'subject',
        'purpos',
        'message',
        'note',
    ];

    public static function rules()
    {
        return [
            'firstName' => [
                'required',
                'string',
            ],
            'lastName' => [
                'required',
                'string',
            ],
            'email' => 'nullable',
            'subject' => 'nullable',
            'purpos' => 'nullable',
            'message' => 'nullable',
            'note' => 'nullable',
        ];
    }
}
