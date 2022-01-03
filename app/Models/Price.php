<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'value',
        'start_date',
        'room_category_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function room_category()
    {
        return $this->belongsTo(Room_category::class);
    }
}
