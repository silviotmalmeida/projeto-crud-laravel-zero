<?php

namespace App\Commands;

use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class EditProduct extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'product:edit';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Edita um produto';

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
            $this->info('Edição de produto');

            // exibindo os produtos cadastrados
            $this->call('product:list');

            // pergunta o ID
            $id = $this->ask('Informe o ID do produto a ser editado:');

            // obtendo os dados do produto selecionado no banco de dados
            $product = Product::find($id);

            // se o produto não existir:
            if (is_null($product)) {

                // envia mensagem
                $this->info("Favor informar um ID válido!\n");
            }
        } while (is_null($product));

        // pergunta o nome
        $name = $this->ask('Nome', $product->name);

        // pergunta a descricao
        $description = $this->ask('Descricao', $product->description);

        // pergunta o valor
        $value = $this->ask('Valor(R$)', $product->value);

        // pergunta a quantidade
        $qtd = $this->ask('Quantidade', $product->qtd);

        // parando a execucao e imprimindo os valores na tela
        // dd(compact('name', 'description', 'value', 'qtd'));

        // inserindo os dados no banco de dados
        $product->update(compact('name', 'description', 'value', 'qtd'));

        // exibe a mensagem de sucesso
        $this->info("Produto $product->name editado com sucesso!\n");
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
