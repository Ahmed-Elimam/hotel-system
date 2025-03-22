<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
class Floor extends Model
{
    use HasFactory;
    protected $table = 'floors';

    protected $fillable = ['name', 'creator_id', 'floor_number'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($floor) {
            $floor->floor_number = self::generateFloorNumber();
        });
    }

    private static function generateFloorNumber()
    {
        $lastFloor = self::orderBy('id', 'desc')->first();
        return $lastFloor ? $lastFloor->floor_number + 1 : 1000;
    }
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

}
