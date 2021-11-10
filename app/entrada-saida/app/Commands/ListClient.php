<?php

namespace App\Commands;

use App\Models\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ListClient extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'client:list';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Lista todos os clientes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // obtendo os clientes cadastrados no banco de dados, conforme atributos abaixo:
        $clients = Client::all(['id', 'name', 'email', 'whatsapp']);

        // caso não retornem resultados:
        if ($clients->isEmpty()) {

            // imprimindo mensagem
            $this->info("Não existem clientes cadastrados!\n");

            // encerra o programa
            return;
        }
        // senao prossegue:
        else {

            // imprimindo tabela de registros na tela
            $this->info('Lista de Clientes');
            $this->table(['ID', 'Nome', 'Email', 'Whatsapp'], $clients);
            $this->info('');;
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
