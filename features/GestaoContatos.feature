Feature: Gestao de Contatos
Como um usuario bem velinho
Desejo registrar os meus Contatos
Para nunca mais esquecer meu telefone e e-mail

Scenario: Inclusao de Contato
Given o usuario esta logado
When ele cadastrar seu contato:
    |tipo|contato|
    |Phone|44999999|
Then ele vera a mensagem "Your contact has been added!"



Scenario Outline: Inclusao de Contatos
Given o usuario esta logado
When ele cadastrar seu contato:
    | tipo    | contato          |
    | <tipo>  | <contato>        |
Then ele vera a mensagem "<mensagem>"

Examples:
    | tipo   | contato       | mensagem                     |
    | Phone  | +551122225555 | Your contact has been added! |
    | Phone  | +551199998888 | Your contact has been added! |
    | E-mail | i@i.com.br    | Your contact has been added! |