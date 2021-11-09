<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // acoes a serem realizadas na aplicacao da migration
    public function up()
    {
        // criando a tabela sales
        Schema::create('sales', function (Blueprint $table) {

            // chave primaria
            $table->id();

            // coluna de cliente, chave estrangeira e deleta em cascata
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();

            // coluna de usuario, chave estrangeira e deleta em cascata
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // valor total da compra, obrigatória e default zero
            $table->decimal('total')->default(0);

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
        // apagando a tabela sales
        Schema::dropIfExists('sales');
    }
}
