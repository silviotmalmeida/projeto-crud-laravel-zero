<?php

namespace App\Commands;

use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AddProduct extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'product:add';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Adiciona um produto';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    // acoes do comando
    public function handle()
    {
        // exibe o titulo
        $this->info('Cadastro de produto');

        // pergunta o nome
        $name = $this->ask('Nome:');

        // pergunta a descricao
        $description = $this->ask('Descricao:');

        // pergunta o valor
        $value = $this->ask('Valor(R$):');

        // pergunta a quantidade
        $qtd = $this->ask('Quantidade:', 1);

        // parando a execucao e imprimindo os valores na tela
        // dd(compact('name', 'description', 'value', 'qtd'));

        // inserindo os dados no banco de dados
        $product = Product::create(compact('name', 'description', 'value', 'qtd'));

        // exibe a mensagem de sucesso
        $this->info("Produto $product->name cadastrado com sucesso!");
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
