<?php

namespace App\Commands;

use App\Models\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class DeleteClient extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'client:delete';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Remove um cliente';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // laco de verificação de id valido.
        // sera repetido ate ser fornecido um id valido
        do {

            // exibe o titulo
            $this->info('Remoção de cliente');

            // exibindo os clientes cadastrados
            $this->call('client:list');

            // pergunta o ID
            $id = $this->ask('Informe o ID do cliente a ser removido:');

            // obtendo os dados do cliente selecionado no banco de dados
            $client = Client::find($id);

            // se o cliente não existir:
            if (is_null($client)) {

                // envia mensagem
                $this->info("Favor informar um ID válido!\n");
            }
        } while (is_null($client));

        if ($this->confirm("Deseja realmente remover o cliente: $client->name?", false)) {

            // removendo os dados no banco de dados
            $client->delete();

            // exibe a mensagem de sucesso
            $this->info("Cliente $client->name removido com sucesso!\n");
        } else {

            // exibe a mensagem de cancelamento
            $this->info("Operação cancelada!\n");
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
