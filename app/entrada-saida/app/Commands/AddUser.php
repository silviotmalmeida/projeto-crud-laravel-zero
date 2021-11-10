<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AddUser extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'user:add';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Adiciona um usuário';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // exibe o titulo
        $this->info('Cadastro de usuário');

        // pergunta o nome
        $name = $this->ask('Nome');

        // pergunta a descricao
        $username = $this->ask('Usuário');

        // pergunta o valor
        $password = $this->ask('Senha');

        // parando a execucao e imprimindo os valores na tela
        // dd(compact('name', 'username', 'password'));

        // inserindo os dados no banco de dados
        $user = User::create(compact('name', 'username', 'password'));

        // exibe a mensagem de sucesso
        $this->info("Usuário $user->username cadastrado com sucesso!\n");
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
