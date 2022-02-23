<?php

namespace Facebook\WebDriver;

use Exception;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

require_once('vendor/autoload.php');

try {
    // start chrome driver
    $capabilities = DesiredCapabilities::chrome();
    $driver = ChromeDriver::start($capabilities);

    $driver->get('http://192.168.28.108/operator.php');
    $driver->findElement(WebDriverBy::id('username'))->sendKeys('operator');
    echo "Entered username \n";
    sleep(1);

    $driver->findElement(WebDriverBy::id('clrpasswd'))->sendKeys('asdf1234');
    echo "Entered password \n";

    $driver->findElement(WebDriverBy::xpath('//*[@id="login-form"]/center/div[4]/a/img'))->click();
    sleep(1);
    $driver->findElement(WebDriverBy::id('captcha'))->click();

    $loginTime = time();
    while (time() - $loginTime < 6) {
    	echo "Stop 3 seconds for manual captcha input\n"; 
    	sleep(3);

	    $getCaptcha = $driver->findElement(WebDriverBy::id('captcha'))->getAttribute('value');

        if(4 == strlen(trim($getCaptcha))) {
            echo "Captcha entered: " . $getCaptcha . "\n";
            echo "Received Captcha\n";
    	    $driver->findElement(WebDriverBy::id('login'))->click();
            sleep(1);
    	    echo "Login in progress... \n";
            break;
	    }
    }

    if (4 > strlen(trim($getCaptcha)) && 0 != strlen(trim($getCaptcha))) {
        echo "Captcha entered: " . $getCaptcha . "\n";
        throw new Exception("Captcha is invalid!\n");
        // terminate the session and close the browser
        $driver->quit();
    } elseif (0 == strlen(trim($getCaptcha))) {
        throw new Exception("Captcha is empty!\n");
        // terminate the session and close the browser
        $driver->quit();
    }

    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::cssSelector('#navbar-right-top > ul.topnav.pull-right.logininfo > li > a'),
            'My Account'
        )
    );
    echo "Login successfully! \n";

    // access to settlement listing page
    $driver->get("http://192.168.28.108/operator.php?hdl=main&aot=settlement&type=request");
    $accessSettlement = $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//span[@id="panel-1178_header_hd-textEl"]'),
            'Settlement'
        )
    );
    if (!$accessSettlement) {
        throw new Exception("Failed to access Settlement Page\n");
    } else {
        echo "Successfully access to Settlement Request Module";
    }

    // Open the add settlement form 
    $driver->findElement(WebDriverBy::xpath('//a[@id="addButton"]'))->click();

    $settlementForm = $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//span[@id="mywindow_header_hd-textEl"]'),
            'Add New Record'
        )
    );

    if (!$settlementForm) {
        throw new Exception("Failed to open CREATE/ADD Settlement form\n");
    }
    // TODO: 
    // Create a simple Settlement transaction to success 
    // request one settlement 
    // until select partner on add new record form

    sleep(3);

    $driver->quit();

} catch (\Exception $ex) {
    echo 'Error  -  ' . $ex->getMessage() . "\n";
}

?>