<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ListUsers extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'user:list';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Lista todos os usuários';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // obtendo os usuarios cadastrados no banco de dados, conforme atributos abaixo:
        $users = User::all(['id', 'name', 'username', 'password']);

        // caso não retornem resultados:
        if ($users->isEmpty()) {

            // imprimindo mensagem
            $this->info('Não existem usuários cadastrados!');
            $this->info('');

            // encerra o programa
            return;
        }
        // senao prossegue:
        else {

            // imprimindo tabela de registros na tela
            $this->info('Lista de Usuários');
            $this->table(['ID', 'Nome', 'Usuário', 'Senha'], $users);
            $this->info('');
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
