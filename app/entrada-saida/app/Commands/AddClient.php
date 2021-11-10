<?php

namespace App\Commands;

use App\Models\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AddClient extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'client:add';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Adiciona um cliente';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // exibe o titulo
        $this->info('Cadastro de cliente');

        // pergunta o nome
        $name = $this->ask('Nome');

        // pergunta o email
        $email = $this->ask('Email');

        // pergunta o whatsapp
        $whatsapp = $this->ask('Whatsapp');

        // parando a execucao e imprimindo os valores na tela
        // dd(compact('name', 'email', 'whatsapp'));

        // inserindo os dados no banco de dados
        $client = Client::create(compact('name', 'email', 'whatsapp'));

        // exibe a mensagem de sucesso
        $this->info("Cliente $client->name cadastrado com sucesso!\n");
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
