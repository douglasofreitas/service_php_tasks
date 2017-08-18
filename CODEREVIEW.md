CODE REVIEW

## especificações

Ter apenas um GET e POST de tarefas, o usuário não pode atualizar as tasks ou removê-las (por alguma necessidade de manutenção nas task), geralmente é requisitado o CRUD completo da entidade.
Os métodos DELETE são importante para efeito de testes e desenvolvimento, para limpeza de banco de dados, que podem ser bloqueados com hashes no header (por exemplo)

Para melhor desempenho aconselha-se o uso do Postgres

## desing patter 

O controller TaskController deve usar construtor para centralizar a criação do connector com banco.

É indicado o uso de um Manager para o Model, para que comandos SQL ou consultas espefícicas sejam centralizadas no contexto do modelo da aplicação.

O uso de um ORM é indicado para não necessitar de uso explicito de SQL, que deve ser abstrato pela aplicação, podendo assim mudar facilmente entre banco de dados.

Não há tratativa de erros que podem ocorrer na interação com o banco (try / catch), como a ação de "Insert"

## Docker

O docker presente no projeto é apenas para desenvolvimento.
Não há um docker para produção, em que há as cópias dos arquivos no container (em dev faz-se montagem de diretórios para facilitar o desenvolvimento)

## API RESTFull

A forma de implementação do POST da Task não esta adequada. 
No padrão de RESTFull não devem ser usados verbos nas URLs (O método HTTP define a ação)

Erro: POST /add
Correto:  POST /

No " GET / ", uma recomendação é usar limit e um metadata sobre o resultado:

Ref: https://github.com/WhiteHouse/api-standards

## Tests

Os testes não rodaram no Docker (PHPUnit não instalado e comando mensionado não funciona  ).
Comando correto para os testes: vendor/bin/phpunit --debug -c tests 




