<?php

namespace App\Commands;

use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class DeleteProduct extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'product:delete';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Remove um produto';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // obtendo os produtos cadastrados no banco de dados, conforme atributos abaixo:
        $products = Product::all(['id', 'name', 'description', 'value', 'qtd']);

        // caso não retornem resultados:
        if ($products->isEmpty()) {

            // imprimindo mensagem
            $this->info('Não existem produtos cadastrados!');
            $this->info('');
        }
        // senao prossegue:
        else {

            // imprimindo tabela de registros na tela
            $this->table(['ID', 'Nome', 'Descrição', 'Valor(R$)', 'Quantidade'], $products);

            // exibe o titulo
            $this->info('Remoção de produto');

            // laco de verificação de id valido.
            // sera repetido ate ser fornecido um id valido
            do {
                // pergunta o ID
                $id = $this->ask('Informe o ID do produto a ser removido:');

                // obtendo os dados do produto selecionado no banco de dados
                $product = Product::find($id);

                // se o produto não existir:
                if (is_null($product)) {

                    // envia mensagem
                    $this->info('Favor informar um ID válido!');
                }
            } while (is_null($product));

            if ($this->confirm("Deseja realmente remover o produto: $product->name?", false)) {

                // removendo os dados no banco de dados
                $product->delete();

                // exibe a mensagem de sucesso
                $this->info("Produto $product->name removido com sucesso!");
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
