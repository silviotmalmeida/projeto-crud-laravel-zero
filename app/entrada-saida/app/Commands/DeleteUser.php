<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class DeleteUser extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'user:delete';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Remove um usuário';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // obtendo os usuarios cadastrados no banco de dados, conforme atributos abaixo:
        $users = User::all(['id', 'name', 'username', 'password',]);

        // caso não retornem resultados:
        if ($users->isEmpty()) {

            // imprimindo mensagem
            $this->info('Não existem usuários cadastrados!');
            $this->info('');
        }
        // senao prossegue:
        else {

            // imprimindo tabela de registros na tela
            $this->table(['ID', 'Nome', 'Usuário', 'Senha'], $users);

            // exibe o titulo
            $this->info('Remoção de usuário');

            // laco de verificação de id valido.
            // sera repetido ate ser fornecido um id valido
            do {
                // pergunta o ID
                $id = $this->ask('Informe o ID do usuário a ser removido:');

                // obtendo os dados do produto selecionado no banco de dados
                $user = User::find($id);

                // se o usuario não existir:
                if (is_null($user)) {

                    // envia mensagem
                    $this->info('Favor informar um ID válido!');
                }
            } while (is_null($user));

            if ($this->confirm("Deseja realmente remover o usuário: $user->name?", false)) {

                // removendo os dados no banco de dados
                $user->delete();

                // exibe a mensagem de sucesso
                $this->info("Usuário $user->name removido com sucesso!");
            } else {

                // exibe a mensagem de cancelamento
                $this->info("Operação cancelada!");
            }
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
