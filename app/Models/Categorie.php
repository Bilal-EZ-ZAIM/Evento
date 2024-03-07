<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function even()
    {
        return $this->belongsTo(Evenment::class, 'id' , 'categorie_id');
    }
}
