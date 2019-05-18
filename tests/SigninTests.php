<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class SignInTests extends TestCase {
	private $navegador;

	protected function setUp() : void {
		$this->navegador = RemoteWebDriver::create('http://localhost:4444', DesiredCapabilities::chrome());
		$this->navegador->get('http://www.juliodelima.com.br/taskit');
		$this->navegador->manage()->window()->maximize();
		$this->navegador->manage()->timeouts()->implicitlyWait(5);
	}

	protected function tearDown() : void {
		$this->navegador->quit();
	}

	public function testSignInOnTaskit() {
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

		// Validar que o elemento da class me tem o texto Hi, Julio
		$meuNome = $this->navegador->findElement(WebDriverBy::className('me'))->getText();
		$this->assertEquals("Hi, Julio", $meuNome);
	}

	public function testSignChangePassword() {
		// Clicar em .hide-on-med-and-down a[data-target="signinbox"]
		$this->navegador
			->findElement(WebDriverBy::cssSelector('.hide-on-med-and-down a[data-target="signinbox"]'))
			->click();
		// Digitar julio0001 em #signinbox input[name="login"]
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
			->sendKeys('trocar-senha-julio');
		// Digitar 123456 em #signinbox input[name="password"]
		$this->navegador
			->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
			->sendKeys('trocar-senha-julio');

		$this->navegador
			->findElement(WebDriverBy::id('signinbox'))
			->findElement(WebDriverBy::linkText('SIGN IN'))
			->click();

		$this->navegador->findElement(WebDriverBy::className('me'))->click();

		$this->navegador->findElement(WebDriverBy::linkText('SECRET, SHHHH!'))->click();		

		$this->navegador->findElement(WebDriverBy::name('password'))->sendKeys('654321');

		$this->navegador->findElement(WebDriverBy::id('changeMyPassword'))->click();

		$mensagem = $this->navegador->findElement(WebDriverBy::id('toast-container'))->getText();

		$this->assertEquals('You have a new secret, please do not share it!', $mensagem);
	}
}

/*
	./vendor/bin/phpunit tests/SigninTest.php
*/