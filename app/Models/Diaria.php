<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diaria extends Model
{
    use HasFactory;

    public function orcamentos() {
        return $this->belongsToMany('App\Models\Orcamento');
    }
}
