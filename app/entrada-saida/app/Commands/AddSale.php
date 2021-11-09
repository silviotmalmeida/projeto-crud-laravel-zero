<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;

class AddSale extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    // texto do comando
    protected $signature = 'sale:add';

    /**
     * The description of the command.
     *
     * @var string
     */
    // descricao do comando
    protected $description = 'Adiciona uma venda';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    // acoes do comando
    public function handle()
    {

        // exibe o titulo
        $this->info("Cadastro de venda\n");

        // criando o carrinho
        $cart = [];

        // laço para seleção do usuário
        // sera repetido ate ser fornecido um id valido
        do {

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

            // pergunta o ID
            $user_id = $this->ask('Informe o ID do usuário vendedor:');

            // obtendo os dados do produto selecionado no banco de dados
            $user = User::find($user_id);

            // se o usuario não existir:
            if (is_null($user)) {

                // envia mensagem
                $this->info('Favor informar um ID válido!');
            }
            // senão:
            else {

                // coleta o nome do usuário vendedor
                $user_name = $user->name;
            }
        } while (is_null($user));

        // laço para seleção do cliente
        // sera repetido ate ser fornecido um id valido
        do {

            // obtendo os clientes cadastrados no banco de dados, conforme atributos abaixo:
            $clients = Client::all(['id', 'name', 'email', 'whatsapp']);

            // caso não retornem resultados:
            if ($clients->isEmpty()) {

                // imprimindo mensagem
                $this->info('Não existem clientes cadastrados!');
                $this->info('');

                // encerra o programa
                return;
            }
            // senao prossegue:
            else {

                // imprimindo tabela de registros na tela
                $this->info('Lista de Clientes');
                $this->table(['ID', 'Nome', 'Email', 'Whatsapp'], $clients);
                $this->info('');
            }

            // pergunta o ID
            $client_id = $this->ask('Informe o ID do cliente comprador:');

            // obtendo os dados do cliente selecionado no banco de dados
            $client = Client::find($client_id);

            // se o cliente não existir:
            if (is_null($client)) {

                // envia mensagem
                $this->info('Favor informar um ID válido!');
            }
            // senão:
            else {

                // coleta o nome do cliente comprador
                $client_name = $client->name;
            }
        } while (is_null($client));

        // laço para seleção do produto
        // sera repetido ate o dígito zero ser digitado
        do {

            // obtendo os produtos cadastrados no banco de dados, conforme atributos abaixo:
            $products = Product::all(['id', 'name', 'description', 'value', 'qtd']);

            // caso não retornem resultados:
            if ($products->isEmpty()) {

                // imprimindo mensagem
                $this->info('Não existem produtos cadastrados!');
                $this->info('');
                $id = 0;
            }
            // senao prossegue:
            else {

                // imprimindo tabela de registros na tela
                $this->info('Lista de Produtos');
                $this->table(['ID', 'Nome', 'Descrição', 'Valor(R$)', 'Quantidade'], $products);
                $this->info('');

                // pergunta o id do produto para incluir no carrinho, se deixar vazio assume valor zero
                $id = $this->ask('Informe o código do produto. (Para sair digite 0)', 0);

                // se o valor informado for diferente de zero
                if ($id != 0) {

                    // obtendo os dados do produto selecionado no banco de dados
                    $product = Product::find($id);

                    // se o produto não existir:
                    if (is_null($product)) {

                        // envia mensagem
                        $this->info('Favor informar um ID válido!');
                    }
                    // senão
                    else {

                        // obtendo a quantidade de produtos em estoque
                        $avaiableQtd = $product->qtd;

                        // pergunta qual a quantidades do produto na venda
                        $product->qtd = $this->ask("Produto: $product->name. Informe a quantidade");

                        // se o estoque disponível for maior ou igual a quantidade solicitada:
                        if ($avaiableQtd >= $product->qtd) {

                            // removendo os atributos desnecessários
                            unset($product->created_at);
                            unset($product->updated_at);

                            // adicionando o produto ao carrinho
                            $cart[] = $product;
                            $this->info("Produto: $product->name. Quantidade: $product->qtd. Adicionado ao carrinho.\n");
                        }
                        // senão
                        else {
                            // envia mensagem
                            $this->info("Produto: $product->name. Com estoque insuficiente para esta venda. Disponível: $avaiableQtd.\n");
                            $this->info('');
                        }
                    }
                }
            }
        } while ($id != 0);

        // se o carrinho estiver vazio:
        if (count($cart) === 0) {

            // envia mensagem
            $this->info('Carrinho vazio.');
            $this->info('');
        }
        // senão
        else {

            // converte o carrinho em uma coleção
            $cart = collect($cart);

            // laço para verificação do estoque de produtos
            do {

                $validCart = true;

                // iterando sobre os itens do carrinho para verificar se tem estoque sufuciente
                foreach ($cart as $item) {

                    // obtendo os dados do produto selecionado no banco de dados
                    $product = Product::find($item->id);

                    if ($product->qtd < $item->qtd) {

                        $item->qtd = $product->qtd;

                        if ($product->qtd === 0) {

                            $this->info("Produto: $item->name. Sem estoque. Item será removido do carrinho.\n");
                        } else {

                            $this->info("Produto: $item->name. Sem estoque suficiente. Quantidade foi alterada para: $item->qtd. Adicionado ao carrinho.\n");
                        }

                        $validCart = false;
                    }
                };
            } while ($validCart === false);

            // criando o carrinho validado
            $validatedCart =  [];

            // iterando sobre os itens do carrinho para remover itens com quantidade zerada
            // e calcular o valor da venda por item
            foreach ($cart as $item) {

                // se a quantidade for maior que zero:
                if ($item->qtd > 0) {

                    // calculando o valor total do item
                    $item->total = $item->value * $item->qtd;

                    // insere no carrinho validado
                    $validatedCart[] = $item;
                }
            };

            // inicializando o total da venda
            $total = 0;

            // computando o total da venda
            foreach ($validatedCart as $item) {
                $total += $item->total;
            }

            // converte o carrinho validado em uma coleção
            $validatedCart = collect($validatedCart);

            // imprimindo tabela do carrinho na tela
            $this->info("CARRINHO:");
            $this->table(['ID', 'Nome', 'Descrição', 'Valor(R$)', 'Quantidade', 'Valor Total(R$)'], $validatedCart);
            $this->info('');

            $this->info("VALOR TOTAL (R$): $total");
            $this->info("VENDEDOR: $user_name");
            $this->info("COMPRADOR: $client_name");
            $this->info('');

            if ($this->confirm('Finalizar venda?')) {

                // laço para atualizacao dos estoques dos produtos
                foreach ($validatedCart as $item) {

                    // atualizando os estoques dos produtos
                    $product = Product::find($item->id);
                    $product->qtd -= $item->qtd;
                    $product->save();
                }

                // preparando os dados para a tabela de relacionamento
                foreach ($validatedCart as $item) {
                    $sale_products[$item->id] = ['value' => $item->value, 'qtd' => $item->qtd];
                }

                // inserindo a venda no banco de dados
                $sale = Sale::create(compact('user_id', 'client_id', 'total'));

                // inserindo dados na tabela de relacionamento
                $sale->products()->sync($sale_products);
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
