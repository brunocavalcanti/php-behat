Feature: Gestao de Contatos
Como um usuario bem velinho
Desejo registrar os meus Contatos
Para nunca mais esquecer meu telefone e e-mail

Scenario: Inclusao de Contato
Given o usuario esta logado
When ele cadastrar seu telefone principal
Then ele vera a mensagem "Your contact has been added!"