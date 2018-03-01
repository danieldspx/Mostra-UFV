# Mostra-UFV
Mostra de Profissões UFV - Sistema de Cadastro de Visitantes

## Getting Started
* Crie um Banco de Dados com o nome de "mostra"
* Acesse o DB "mostra" (criado no passo anterior) e importe o arquivo "mostra.sql" da pasta "Tabelas DB - SQL"
* Adicione seu usuário e senha para acessar o sistema na tabela "admin". A senha deve ser uma string de 32 caracteres resultado de uma criptografia md5.
  * Para criar a senha em md5 dê um "echo md5('12345678');" onde 12345678 é a sua senha, para isso você pode usar o site [PHPTester](http://phptester.net/) que simula um arquivo PHP sendo executado e mostra o resultado.
  * Ex. de Usuário: user_teste, Senha: 12345678 :
    ```
    INSERT INTO admin(nome, email, senha) VALUES ("Nome Teste","user_teste","25d55ad283aa400af464c76d713c07ad");
    ```
* Acesse o arquivo "config.php" em "./private_html_protected/config.php".
  * Altere as constantes 'DB_PASSWORD' e 'DB_USERNAME' para a senha e username do seu phpMyAdmin, respectivamente. 
* Acesse:
  ```
  http://localhost/Mostra
  ```
* Faça o Login utilizando o usuário e senha que você criou.
## Relacionamento entre as Tabelas ([MySQL Workbench](https://www.mysql.com/products/workbench/))
![alt Schema MySQL Workbench](https://imgur.com/kGYn4WM.png)
