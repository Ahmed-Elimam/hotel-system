<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'room_number',
        'capacity',
        'price',
        'is_reserved',
        'room_creator_id',
        'floor_id',
    ];
    protected $attributes = [
        'is_reserved' => false,
    ];


    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'room_creator_id');
    }
}
