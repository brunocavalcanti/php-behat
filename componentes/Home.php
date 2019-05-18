<?php

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverWait;

class Principal {

    protected $navegador;
    protected $mensagemRetorno;
    

    public function __construct($navegador){
        $this->navegador = $navegador;
       
    }

    public function acessarHome(){
        $this->navegador->findElement(WebDriverBy::className('me'))->click();
        return $this;
    }


    public function acessarListaTelefonica(){
        $this->navegador->findElement(WebDriverBy::linkText('MORE DATA ABOUT YOU'))->click();
        return $this;
    }

    public function clickAddListaTelefonica(){
        $this->navegador->findElement(WebDriverBy::xpath('//button[@data-target="addmoredata"]'))->click();
        return $this;
    }


    public function preencherListaTelefonica($numero){
        $fieldType =  $this->navegador->findElement(WebDriverBy::name('type'));
        $comboType = new WebDriverSelect($fieldType);
        $comboType->selectByValue('phone');//

        $this->navegador
			->findElement(WebDriverBy::cssSelector('input[name="contact"]'))
            ->sendKeys($numero);
        return $this;

    }

    public function salvarListaTelefonica()
    {
        $this->navegador
			->findElement(WebDriverBy::linkText('SAVE'))
            ->click();
        return $this;
    }

    public function salvarMensagemRetorno(){
        $wait = new WebDriverWait($this->navegador, 9, 500);
        $wait->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::className('toast'))
            );


        $this->mensagem = $this->navegador->findElement(WebDriverBy::className('toast'))->getText();

        return $this;
    }

    public function stepBuilderAddPhone(){
        return $this->acessarHome()
                    ->acessarListaTelefonica()
                    ->clickAddListaTelefonica()
                    ->preencherListaTelefonica()
                    ->salvarListaTelefonica()
                    ->salvarMensagemRetorno();             

    }

}

/*
acao me
 */