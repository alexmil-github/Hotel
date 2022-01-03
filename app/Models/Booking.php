<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'arr_date',
        'dep_date',
        'room_category_id',
        'email',
        'phone',
        'city',
        'code',
        'booking_status_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
