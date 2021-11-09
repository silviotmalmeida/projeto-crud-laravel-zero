<?php

namespace App\Commands;

use App\Models\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class EditClient extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'client:edit';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Edita um cliente';

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
            $this->info('Não existem clientes cadastrados!');
            $this->info('');
        }
        // senao prossegue:
        else {

            // imprimindo tabela de registros na tela
            $this->table(['ID', 'Nome', 'Email', 'Whatsapp'], $clients);

            // exibe o titulo
            $this->info('Edição de cliente');

            // laco de verificação de id valido.
            // sera repetido ate ser fornecido um id valido
            do {
                // pergunta o ID
                $id = $this->ask('Informe o ID do cliente a ser removido:');

                // obtendo os dados do cliente selecionado no banco de dados
                $client = Client::find($id);

                // se o cliente não existir:
                if (is_null($client)) {

                    // envia mensagem
                    $this->info('Favor informar um ID válido!');
                }
            } while (is_null($client));

            // pergunta o nome
            $name = $this->ask('Nome:', $client->name);

            // pergunta a email
            $email = $this->ask('Email:', $client->email);

            // pergunta o whatsapp
            $whatsapp = $this->ask('Whatsapp:', $client->whatsapp);

            // parando a execucao e imprimindo os valores na tela
            // dd(compact('name', 'email', 'whatsapp'));

            // inserindo os dados no banco de dados
            $client->update(compact('name', 'email', 'whatsapp'));

            // exibe a mensagem de sucesso
            $this->info("Cliente $client->name editado com sucesso!");
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
