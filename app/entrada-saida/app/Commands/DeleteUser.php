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
        // laco de verificação de id valido.
        // sera repetido ate ser fornecido um id valido
        do {

            // exibe o titulo
            $this->info('Remoção de usuário');

            // exibindo os usuarios cadastrados
            $this->call('user:list');

            // pergunta o ID
            $id = $this->ask('Informe o ID do usuário a ser removido:');

            // obtendo os dados do produto selecionado no banco de dados
            $user = User::find($id);

            // se o usuario não existir:
            if (is_null($user)) {

                // envia mensagem
                $this->info("Favor informar um ID válido!\n");
            }
        } while (is_null($user));

        if ($this->confirm("Deseja realmente remover o usuário: $user->name?", false)) {

            // removendo os dados no banco de dados
            $user->delete();

            // exibe a mensagem de sucesso
            $this->info("Usuário $user->name removido com sucesso!\n");
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
