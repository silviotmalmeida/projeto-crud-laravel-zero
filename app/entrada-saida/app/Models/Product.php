<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// criando a model de Product
class Product extends Model
{

    use HasFactory;

    // atributos da tabela no banco de dados
    protected $fillable = [
        'name',
        'description',
        'value',
        'qtd'
    ];
}
