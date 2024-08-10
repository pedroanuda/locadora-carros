# Locadora de Carros
Feito como trabalho escolar, que acabou evoluindo um pouco mais que o necessário.
No entanto, foi somente feito em um nível bem experimental e sem expectativas para
uma versão de produção.

O que se destaca aqui é:
- Uso de cookie de autenticação;
- Uso de MySQL;
- Tipo de login etc.

## Configurando a database
Primeiramente, use o arquivo `db/creation.sql` e faça a criação da database e tabelas
em seu MySQL/MariaDB etc.

Após isso, para usar corretamente é necessário acessar `db/config.json` e dar
as informações de acesso do seu Banco de Dados assim:

```json
{
    "hostname": "localhost",
    "username": "root",
    "password": null,
    "porta": "3306",
    "database": "locadora_carros"
}
```