<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'etat_id',
        'evenemont_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function etat()
    {
        return $this->belongsTo(Etate::class, 'etat_id');
    }

    public function event()
    {
        return $this->belongsTo(Evenment::class, 'evenemont_id');
    }
    

}
