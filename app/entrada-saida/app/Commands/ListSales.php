<?php

namespace App\Commands;

use App\Models\Client;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ListSales extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    // texto do comando
    protected $signature = 'sale:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    // descricao do comando
    protected $description = 'Lista todas as vendas';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    // acoes do comando
    public function handle()
    {
        // obtendo as vendas cadastradas no banco de dados, conforme atributos abaixo:
        $sales = Sale::all(['id', 'created_at', 'total']);

        // ajustando os dados de data e hora para exibição
        $sales = $sales->map(function($sale){

            return[
                'id'=>$sale->id,
                'created_at'=>$sale->created_at->format('d/m/y H:i:s'),
                'total'=>$sale->total
            ];
        });

        // caso não retornem resultados:
        if ($sales->isEmpty()) {

            // imprimindo mensagem
            $this->info("Não existem vendas cadastradas!\n");

            // encerra o programa
            return;
        }
        // senao prossegue:
        else {

            // imprimindo tabela de registros na tela
            $this->info('Lista de Vendas');
            $this->table(['ID', 'Data e Hora', 'Total(R$)'], $sales);
            $this->info('');;
        }

        // pergunta o ID
        $id = $this->ask('Informe o ID da venda a ser detalhada');

        // obtendo os dados do cliente selecionado no banco de dados
        $sale = Sale::find($id);

        // se a venda não existir:
        if (is_null($sale)) {

            // envia mensagem
            $this->info("Favor informar um ID válido!\n");

            // encerra a execução
            return;
        }
        // se a venda existir:
        else{

            // obtendo os dados do usuário
            $user = User::find($sale->user_id);

            // obtendo os dados do cliente
            $client = Client::find($sale->client_id);

            // obtendo e formatando os dados dos produtos
            $products = $sale->products->map(function($product){

                return [
                    // valores da tabela product
                    'name'=>$product->name,

                    // valores da tabela pivot product_sale
                    'qtd'=>$product->pivot->qtd,
                    'value'=>$product->pivot->value,
                    'total'=>$product->pivot->qtd*$product->pivot->value
                ];
            });

            // imprimindo tabela de registros na tela
            $this->info("Detalhamento da Venda $sale->id\n");

            $this->info("Nome do usuário: $user->name");
            $this->info("Nome do cliente: $client->name");
            $this->info("Valor Total (R$): $sale->total");
            $this->info("Data e Hora: " . $sale->created_at->format('d/m/y H:i:s') . "\n");

            $this->info('Lista de Produtos');
            $this->table(['Nome', 'Qtd', 'Valor Unitário(R$)', 'Valor Total(R$)'], $products);
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
