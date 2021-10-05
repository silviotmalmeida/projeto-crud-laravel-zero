<?php

namespace App\Commands;

use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ListProducts extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */

    // texto do comando
    protected $signature = 'product:list';

    /**
     * The description of the command.
     *
     * @var string
     */

    // descricao do comando
    protected $description = 'Lista todos os produtos';

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
            $this->info('');
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
