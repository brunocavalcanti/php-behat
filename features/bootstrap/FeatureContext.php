<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    private $navegador;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->navegador = RemoteWebDriver::create('http://localhost:4444', DesiredCapabilities::chrome());
		$this->navegador->get('http://www.juliodelima.com.br/taskit');
		$this->navegador->manage()->window()->maximize();
		$this->navegador->manage()->timeouts()->implicitlyWait(5);
    }
    public function __destruct (){
        $this->navegador->quit();
    }

     /**
     * @Given o usuario esta logado
     */
    public function oUsuarioEstaLogado()
    {
        // Clicar em .hide-on-med-and-down a[data-target="signinbox"]
            $this->navegador
            ->findElement(WebDriverBy::cssSelector('.hide-on-med-and-down a[data-target="signinbox"]'))
            ->click();
        // Digitar julio0001 em #signinbox input[name="login"]
        $this->navegador
            ->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
            ->sendKeys('julio0001');
        // Digitar 123456 em #signinbox input[name="password"]
        $this->navegador
            ->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
            ->sendKeys('123456');

        $this->navegador
            ->findElement(WebDriverBy::id('signinbox'))
            ->findElement(WebDriverBy::linkText('SIGN IN'))
        ->click();
    }

    
    /**
     * @When ele cadastrar seu telefone principal
     */
    public function eleCadastrarSeuTelefonePrincipal()
    {
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
       
    }

    /**
     * @Then ele vera a mensagem :arg1
     */
    public function eleVeraAMensagem($arg1)
    {
        $wait = new WebDriverWait($this->navegador, 9, 500);
        $wait->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::className('toast'))
            );
        $mensagem = $this->navegador->findElement(WebDriverBy::className('toast'))->getText();
        
        $this->navegador->takeScreenshot("evidencies/screenshot".rand(1,100).".jpg");

        Assert::assertContains($arg1, $mensagem);
    }
   


}
