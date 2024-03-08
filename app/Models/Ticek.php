<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticek extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation');
    }

    public function event()
    {
        return $this->belongsTo(Evenment::class, 'evenemont_id');
    }
    
}
