<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'number_of_apartments',
        'guests',
        'square',
        'number_of_rooms',
        'description',

    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function service_icons()
    {
        return $this->belongsToMany(Service_icon::class, 'service_icons_accesses');
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }


}

