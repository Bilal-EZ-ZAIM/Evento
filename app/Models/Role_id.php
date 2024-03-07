<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_id extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class, 'role_id','id');
    }
}
