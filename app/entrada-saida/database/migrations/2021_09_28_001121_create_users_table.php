<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // acoes a serem realizadas na aplicacao da migration
    public function up()
    {
        // criando a tabela users
        Schema::create('users', function (Blueprint $table) {

            // chave primaria
            $table->id();

            // coluna de nome, obrigatoria
            $table->string('name');

            // coluna de username, obrigatoria e unica
            $table->string('username')->unique();

            // coluna de password
            $table->string('password');

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
        // apagando a tabela users
        Schema::dropIfExists('users');
    }
}
