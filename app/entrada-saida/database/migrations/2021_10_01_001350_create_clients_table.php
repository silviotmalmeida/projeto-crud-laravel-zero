<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // acoes a serem realizadas na aplicacao da migration
    public function up()
    {
        // criando a tabela clients
        Schema::create('clients', function (Blueprint $table) {

            // chave primaria
            $table->id();

            // coluna de nome, obrigatoria
            $table->string('name');

            // coluna de email, obrigatoria
            $table->string('email');

            // coluna de whatsapp, obrigatoria
            $table->string('whatsapp');

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
        // apagando a tabela clients
        Schema::dropIfExists('clients');
    }
}
