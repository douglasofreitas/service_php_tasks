CODE REVIEW

## especificações

Ter apenas um GET e POST de tarefas, o usuário não pode atualizar as tasks ou removê-las (por alguma necessidade de manutenção nas task), geralmente é requisitado o CRUD completo da entidade.

## desing patter 

O controller TaskController deve usar construtor para centralizar a criação do connector com banco.

É indicado o uso de um Manager para o Model, para que comandos SQL ou consultas espefícicas sejam centralizadas no contexto do modelo da aplicação.

### API RESTFull

A forma de implementação do POST da Task não esta adequada. 
No padrão de RESTFull não devem ser usados verbos nas URLs (O método HTTP define a ação)

Erro: POST /add
Correto:  POST /

No " GET / ", uma recomendação é usar limit e um metadata sobre o resultado:


## Tests

Os testes não rodaram no Docker (PHPUnit não instalado e comando mensionado não funciona  ).
OUTPUT: No tests executed!




