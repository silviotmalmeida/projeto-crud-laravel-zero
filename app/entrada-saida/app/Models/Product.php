<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// criando a model de Product
class Product extends Model
{

    protected $fillable = [
        'name',
        'description',
        'value',
        'qtd'
    ];
}
