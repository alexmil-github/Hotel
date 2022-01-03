<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path',
        'room_category',
        'owner_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
