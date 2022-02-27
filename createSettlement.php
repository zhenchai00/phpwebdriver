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
    $timeDiff = time() - $loginTime;
    while (6 > $timeDiff) {
    	echo "Stop 4 seconds for manual captcha input\n"; 
    	sleep(4);

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
        echo "Successfully access to Settlement Request Module\n";
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
    } else {
        echo "Open create Settlement form\n";
    }
    
    // Select Partner Type
    $driver->findElement(WebDriverBy::xpath('//input[@id="formpartnertype-inputEl"]'))->click();
    $driver->findElement(WebDriverBy::id('formpartnertype-inputEl'))->sendKeys('Merchant');
    $driver->wait(3,250)->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//li[text()="Merchant"]'),
            'Merchant'
        )
    );
    $driver->findElement(WebDriverBy::xpath('//li[text()="Merchant"]'))->click();
    echo "Selected Partner Type\n";
    sleep(1);

    // Select Partner Code
    $driver->findElement(WebDriverBy::xpath('//input[@id="formpartnerid-inputEl"]'))->click();
    $driver->findElement(WebDriverBy::id('formpartnerid-inputEl'))->sendKeys('TA000001');
    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//li[text()="TA000001 | TA000001"]'),
            'TA000001 | TA000001'
        )
    );
    $driver->findElement(WebDriverBy::xpath('//li[text()="TA000001 | TA000001"]'))->click();
    echo "Selected Partner Code\n";
    sleep(3);

    $driver->findElement(WebDriverBy::xpath('//*[@id="formfromaccountid-inputCell"]'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="formfromaccountid-inputCell"]'))->sendKeys('VND | Fund Transfer |  (TA000001)');
    // $driver->wait()->until(
    //     WebDriverExpectedCondition::elementTextContains(
    //         WebDriverBy::xpath('//li[contains(text(),"VND | Fund Transfer")]'),
    //         'VND'
    //     )
    // );
    // $driver->findElement(WebDriverBy::xpath('//li[contains(text(),"VND | Fund Transfer")]'))->click();
    echo "Selected Settle From\n";
    sleep(1);




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