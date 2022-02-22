<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.



namespace Facebook\WebDriver;

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

require_once('vendor/autoload.php');


// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
// $host = 'http://localhost:4444';

$capabilities = DesiredCapabilities::chrome();

// $driver = RemoteWebDriver::create($host, $capabilities);
$driver = ChromeDriver::create($capabilities);

// navigate to Selenium page on Wikipedia
$driver->get('http://192.168.28.103/operator.php');

// write 'username' in the search box
$driver->findElement(WebDriverBy::id('username')) // find search input element
    ->sendKeys('mda_johnny'); // fill the search box

echo " Entered username";
sleep(2);

// write 'password' in the search box
$driver->findElement(WebDriverBy::id('clrpasswd')) // find search input element
    ->sendKeys('asdf1234'); // fill the search box

echo " Entered password"; 

// echo " Captcha:";
// $captcha = readline();
// $driver->findElement(WebDriverBy::id('captcha'))
// ->sendKeys($captcha);

// $driver->findElement(WebDriverBy::id('login'))->click();






// return true;

$time = time();
while (time() - $time < 60) {
	echo " 5"; 
	sleep(1);
	echo " 4"; 
	sleep(1);
	echo " 3"; 
	sleep(1);
	echo " 2"; 
	sleep(1);
	echo " 1"; 
	sleep(1);
	echo " 0"; 
	sleep(1);


	$Enteredcaptcha = $driver->findElement(WebDriverBy::id('captcha'))->getAttribute('value');


	if(strlen(trim($Enteredcaptcha)) == 4) {
	  $driver->findElement(WebDriverBy::id('login'))->click();
	  echo " Received Captcha";
	}
}



$driver->findElement(WebDriverBy::xpath("/html/body/div/div[2]/h3[10]"))->click();



