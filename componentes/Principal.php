<?php
use Facebook\WebDriver\WebDriverBy;
use Home;

class Principal {

    protected $navegador;
    

    public function __construct($navegador){
        $this->navegador = $navegador;
       
    }

    public function abrirLogin(){
        $this->navegador->findElement(WebDriverBy::id('signin'))->click();
        return $this;
    }
    public function preencherLogin($nome, $password){
        $this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
			->sendKeys($nome);
		
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
            ->sendKeys($password);
            
        return $this;
    }
    public function efetuarLogin(){
        
        $this->navegador
			->findElement(WebDriverBy::id('signinbox'))
			->findElement(WebDriverBy::linkText('SIGN IN'))
            ->click();

            return new Home($this->navegador);
    }

    public function stepBuilderLogin(){
        return $this->abrirLogin()->preencherLogin('higor', 'teste1')->efetuarLogin();
    }

}
?>
/*
 acao abrir login
 acao preencher campos
 acao efetuarLogin
 */