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

    // função para retornar os produtos da venda, com colunas pivot de qtd e value da tabela product_sale
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qtd')->withPivot('value');
    }
}
