<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'birthday',
        'gender',
        'document_type_id',
        'document_number',
        'booking_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


}
