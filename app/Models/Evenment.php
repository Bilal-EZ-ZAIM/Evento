<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenment extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'date',
        'ville_id',
        'nombre_places',
        'user_id',
        'categorie_id',
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class , 'ville_id');
    }
    public function catecory()
    {
        return $this->belongsTo(Categorie::class , 'categorie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
