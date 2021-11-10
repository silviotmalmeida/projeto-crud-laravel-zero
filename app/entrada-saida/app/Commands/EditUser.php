<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class EditUser extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'user:edit';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Edita um usuário';

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
            $this->info('Edição de usuário');

            // exibindo os usuarios cadastrados
            $this->call('user:list');

            // pergunta o ID
            $id = $this->ask('Informe o ID do usuários a ser editado:');

            // obtendo os dados do usuario selecionado no banco de dados
            $user = User::find($id);

            // se o usuario não existir:
            if (is_null($user)) {

                // envia mensagem
                $this->info("Favor informar um ID válido!\n");
            }
        } while (is_null($user));

        // pergunta o nome
        $name = $this->ask('Nome', $user->name);

        // pergunta a descricao
        $username = $this->ask('Usuário', $user->username);

        // pergunta o valor
        $password = $this->ask('Senha', $user->password);

        // parando a execucao e imprimindo os valores na tela
        // dd(compact('name', 'username', 'password'));

        // inserindo os dados no banco de dados
        $user->update(compact('name', 'username', 'password'));

        // exibe a mensagem de sucesso
        $this->info("Usuário $user->username editado com sucesso!\n");
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
