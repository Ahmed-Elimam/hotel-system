<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';


    protected $fillable = [
        'accompany_number',
        'check_in',
        'check_out',
        'paid_price',
        'room_id',
        'client_id',
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
