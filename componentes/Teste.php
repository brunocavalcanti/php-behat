<?php
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Principal;
use Home;



class Teste extends TestCase{

     private $navegador;

    public function setUp():void{
        $this->navegador = RemoteWebDriver::create('http://localhost:4444',DesiredCapabilities::chrome());
        $this->navegador->get('http://www.juliodelima.com.br/taskit');
        $this->navegador->manage()->window()->maximize();
		$this->navegador->manage()->timeouts()->implicitlyWait(5);

    }

    protected function tearDown() : void {
		$this->navegador->quit();
    }

    public function testNovoTelefone(){
        $pagina = new Principal($this->navegador);
        $home = $pagina->stepBuilderLogin();
        $home->stepBuilderAddPhone();

        $this->assertEquals('Your contact has been added!', $home->mensagem);
    }

    


}
?>