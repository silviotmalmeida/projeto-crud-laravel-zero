<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Menu extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    // texto do comando
    protected $signature = 'menu';

    /**
     * The description of the command.
     *
     * @var string
     */
    // descricao do comando
    protected $description = 'Tela inicial do programa';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    // acoes do comando
    public function handle()
    {
        // envia mensagem de login
        $this->info("Realize o login para acessar o Programa de Vendas:\n");

        // obtem o login
        $username = $this->ask('Digite o login do usuário');

        // obtem a senha
        $password = $this->ask('Digite a senha do usuário');

        // verifica se os dados de login e senha pertencem a algum usuário cadastrado
        $user = User::where('username', $username)->where('password', $password)->first();

        // se o usuario não for encontrado:
        if (is_null($user)) {

            // envia mensagem
            $this->error("Login ou senha inválidos!");
            $this->info('');

            // encerra a execução
            die;
        }
        // senao prossegue:
        else {

            // laço para criar o loop do menu
            // somente sairá do laço se escolher a opção exit
            do {

                // renderiza o menu
                $option = $this->menu('Programa de Vendas', [
                    'Listar Usuários',
                    'Listar Clientes',
                    'Listar Produtos',
                    'Listar Vendas',
                    'Cadastrar Usuário',
                    'Cadastrar Cliente',
                    'Cadastrar Produto',
                    'Cadastrar Venda',
                    'Editar Usuário',
                    'Editar Cliente',
                    'Editar Produto',
                    'Remover Usuário',
                    'Remover Cliente',
                    'Remover Produto'
                ])->open();

                // se a opção não for exit:
                if (!is_null($option)) {

                    // chamando os comandos a partir da opção selecionada
                    switch ($option) {

                        case 0:
                            $this->call('user:list');
                            break;
                        case 1:
                            $this->call('client:list');
                            break;
                        case 2:
                            $this->call('product:list');
                            break;
                        case 3:
                            $this->call('sale:list');
                            break;
                        case 4:
                            $this->call('user:add');
                            break;
                        case 5:
                            $this->call('client:add');
                            break;
                        case 6:
                            $this->call('product:add');
                            break;
                        case 7:
                            $this->call('sale:add', ['user_id' => $user->id, 'user_name' => $user->name]);
                            break;
                        case 8:
                            $this->call('user:edit');
                            break;
                        case 9:
                            $this->call('client:edit');
                            break;
                        case 10:
                            $this->call('product:edit');
                            break;
                        case 11:
                            $this->call('user:delete');
                            break;
                        case 12:
                            $this->call('client:delete');
                            break;
                        case 13:
                            $this->call('product:delete');
                            break;
                    }

                    // enviando mensagem para retornar ao menu
                    $this->ask('Pressione ENTER para retornar ao menu.');
                }
                // caso tenha selecionado a opção exit:
                else {

                    // envia mensagem de encerramento
                    $this->info("Encerrando o Programa de Vendas.\n");
                }
            } while (!is_null($option));
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
