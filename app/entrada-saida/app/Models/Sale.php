<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// criando a model de Sale
class Sale extends Model
{
    use HasFactory;

    // atributos da tabela no banco de dados
    protected $fillable = [
        'client_id',
        'user_id',
        'total'
    ];

    // função que representa o relacionamento nxn entre Product e Sale
    public function products()
    {

        return $this->belongsToMany(Product::class);
    }
}
