<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // acoes a serem realizadas na aplicacao da migration
    public function up()
    {
        // criando a tabela products
        Schema::create('products', function (Blueprint $table) {

            // chave primaria
            $table->id();

            // coluna de nome, obrigatoria
            $table->string('name');

            // coluna de descricao, nao obrigatoria
            $table->text('description')->nullable();

            // coluna de valor, com padrao 0
            $table->decimal('value')->default(0);

            // coluna de quantidade, com padrao 0
            $table->integer('qtd')->default(0);

            // colunas de timestamp de cadastro e atualizacao
            $table->timestamps();
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
        // apagando a tabela products
        Schema::dropIfExists('products');
    }
}
