<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // acoes a serem realizadas na aplicacao da migration
    public function up()
    {
        // criando a tabela de relacionamento product_sales
        Schema::create('product_sale', function (Blueprint $table) {

            // coluna de produto, chave estrangeira e deleta em cascata
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // coluna de venda, chave estrangeira e deleta em cascata
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();

            // coluna de valor unitario, obrigatoria
            $table->decimal('value');
            
            // coluna de quantidade de itens, obrigatoria
            $table->integer('qtd');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // acoes a serem realizadas no rollback da migration
    public function down()
    {
        // apagando a tabela product_sales
        Schema::dropIfExists('product_sale');
    }
}
