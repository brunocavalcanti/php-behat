<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ContactTests extends TestCase {

    // Arrange
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
    
    public function testContactCadastro() {
        $this->navegador
			->findElement(WebDriverBy::cssSelector('.hide-on-med-and-down a[data-target="signinbox"]'))
			->click();
		
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
			->sendKeys('aercio');
		
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
			->sendKeys('12345');

		$this->navegador
			->findElement(WebDriverBy::id('signinbox'))
			->findElement(WebDriverBy::linkText('SIGN IN'))
            ->click();
            
        $meuNome = $this->navegador->findElement(WebDriverBy::className('me'))->getText();
        $this->assertEquals("Hi, aercio", $meuNome);

        $this->navegador->findElement(WebDriverBy::className('me'))->click();

        $this->navegador->findElement(WebDriverBy::linkText('MORE DATA ABOUT YOU'))->click();

        $this->navegador->findElement(WebDriverBy::xpath('//button[@data-target="addmoredata"]'))->click();

        $fieldType =  $this->navegador->findElement(WebDriverBy::name('type'));
        $comboType = new WebDriverSelect($fieldType);
        $comboType->selectByValue('phone');//

        $this->navegador
			->findElement(WebDriverBy::cssSelector('input[name="contact"]'))
            ->sendKeys('44999999999');
            
        $this->navegador
			->findElement(WebDriverBy::linkText('SAVE'))
            ->click();
        $wait = new WebDriverWait($this->navegador, 9, 500);
        $wait->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::className('toast'))
            );
        $mensagem = $this->navegador->findElement(WebDriverBy::className('toast'))->getText();
        
        $this->navegador->takeScreenshot("evidencies/screenshot".rand(1,100).".jpg");

        $this->assertEquals('Your contact has been added!', $mensagem);
        
    }

    
    public function testContactDelete() {
        $this->navegador
			->findElement(WebDriverBy::cssSelector('.hide-on-med-and-down a[data-target="signinbox"]'))
			->click();
		
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
			->sendKeys('aercio');
		
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
			->sendKeys('12345');

		$this->navegador
			->findElement(WebDriverBy::id('signinbox'))
			->findElement(WebDriverBy::linkText('SIGN IN'))
            ->click();
            
        $meuNome = $this->navegador->findElement(WebDriverBy::className('me'))->getText();
        $this->assertEquals("Hi, aercio", $meuNome);

        $this->navegador->findElement(WebDriverBy::className('me'))->click();

        $this->navegador->findElement(WebDriverBy::linkText('MORE DATA ABOUT YOU'))->click();
        
        $this->navegador->findElement(WebDriverBy::xpath('//span[text()="44999999999"]/parent::li/a'))->click();

        $alerta = $this->navegador->switchTo()->alert();
        $alerta->getText();
        $alerta->accept();

        $wait = new WebDriverWait($this->navegador, 9, 500);
        $wait->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::className('toast'))
            );
        $mensagem = $this->navegador->findElement(WebDriverBy::className('toast'))->getText();
        
        $this->navegador->takeScreenshot("evidencies/screenshot".rand(1,100).".jpg");
        
        $this->assertEquals('Rest in peace, dear phone!', $mensagem);   
    }

}