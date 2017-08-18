## A aplicação

- PHP 
- Symfony (Silex)
- SQlite

A aplicação é um Produto Mínimo Viável (MVP) de um back-end RESTFull que gerencia tarefas. O mesmo futuramente será consumido por múltiplos front-ends (web, celular, terceiros, etc).

O código está escrito em PHP. Os dados são armazenados por ora no SQLite, mas no futuro (pós-MVP) poderão vir a ser armazenados em outro sistema, inclusive não-relacionais.
 
Reference: https://github.com/upxlabs/teste-dev-php-senior

**Atualmente a aplicação provê:**

### Listagem das tarefas cadastradas

Requisição:

```
GET / HTTP/1.1
Host: localhost:2016
Content-Type: application/json
```
 
Resposta:

```
{"tasks":[{"id":"1","title":"The title - 1483549419"},{"id":"2","title":"The title - 1483549534"}]}
```

### Cadastro de tarefas

Requisição:

```
POST /add HTTP/1.1
Host: localhost:2016
Content-Type: application/json

{
"title": "Título da tarefa"
}
```

Resposta para requisição inválida:

```
{"message":"The title field must have 3 or more characters"}
```

Resposta para requisição válida:

```
{"id":"6","title":"T\u00edtulo da tarefa"}
```

## Novas funcionalidades

Você desenvolverá as seguintes funcionalidades:

1. Como usuário da API, quero ser capaz de adicionar tags (etiquetas) nas minhas tarefas de modo que eu possa classificá-las segundo meus critérios.
1. Como usuário da API, quero ser capaz de editar tags de modo que eu possa definir uma cor para uma dada tag e isso reflita na forma como o front-end exibe as tasks.

Critérios técnicos

- Uma tag consiste em um título e na cor (que pode ser usado pelo front-end da mesma forma como o GMail faz com marcadores).
- As tags devem aparecer na listagem de tasks. 
- Uma tag pode ser usada por 0 ou mais tasks.
- É permitida a adição de novas dependências ao projeto.

## Configuração do ambiente de desenvolvimento

Você pode configurar a aplicação em seu ambiente local (PHP 7.1) ou usar o Docker para subir com tudo já configurado.

### Provisionando o ambiente de desenvolvimento com Docker

1. Subir o container:

    `docker-compose up -d`

1. Logar terminal do container (aguarde alguns segundos):

    `docker exec -it testebackend /bin/bash`

1. Instalar as dependências do composer

    `composer install`

1. Acesse: 

    [http://localhost:2016/](http://localhost:2016/)

#### Outros comandos úteis

- Para rodar os testes unitários:

    `phpunit --debug -c /tests` (no terminal do container)

- Para derrubar o container:

    `docker-compose stop`
