# projeto-crud-laravel-zero

Projeto CRUD Laravel Zero

Baseado no minicurso do Leonardo Hipólito, disponível no YouTube.

Trata-se da implementação de um Sistema de Vendas.

O projeto encontra-se dockerizado para facilitar a implantação. As orientações para execução estão listadas abaixo:

0 - Criar e carregar a imagem docker crud-laravel-zero conforme passos da pasta image;

1 - Para iniciar crie um arquivo chamado database.sqlite na pasta app/entrada-saida/database;

2 - Execute o comando sudo ./startContainers.sh;

3 - Execute o comando sudo ./openTerminal.sh;

4 - No terminal aberto execute: cd root/entrada-saida/; composer install; exit;

5 - Execute o comando sudo ./runMigration.sh;

6 - Execute o comando sudo ./addUser.sh para cadastrar o primeiro usuário;

7- Execute o comando sudo ./menu.sh para iniciar o programa;

O projeto foi iniciado com o comando: composer create-project --prefer-dist laravel-zero/laravel-zero entrada-saida
