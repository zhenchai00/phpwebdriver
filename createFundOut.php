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

    // access to fund out listing page
    $driver->get("http://192.168.28.108/operator.php?hdl=main&aot=fundout&type=request");
    $accessFundOut = $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//span[@id="panel-1241_header_hd-textEl"]'),
            'Fund Out'
        )
    );
    if (!$accessFundOut) {
        throw new Exception("Failed to access Fund Out Page\n");
    } else {
        echo "Successfully access to Fund Out Request Module\n";
    }

    // Open the add fundout form
    $driver->findElement(WebDriverBy::xpath('//a[@id="addButton"]'))->click();
    $fundOutForm = $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//span[@id="mywindow_header_hd-textEl"]'),
            'Add New Record'
        )
    );

    if (!$fundOutForm) {
        throw new Exception("Failed to open CREATE/ADD fund out form\n");
    } else {
        echo "Open create fund out form\n";
    }

    // Select Merchant Code
    $driver->findElement(WebDriverBy::xpath('//input[@id="partnerid-inputEl"]'))->sendKeys('TA');
    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//li[text()="TA000001"]'),
            'TA000001'
        )
    );
    $driver->findElement(WebDriverBy::xpath('//li[text()="TA000001"]'))->click();
    echo "Selected Merchant Code\n";
    sleep(1);

    // Select Account
    $driver->findElement(WebDriverBy::xpath('//input[@id="accountid-inputEl"]'))->sendKeys('VND');
    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//li[contains(text(),"VND | Fund Out |")]'),
            'VND | Fund Out |'
        )
    );
    sleep(0.7);
    $driver->findElement(WebDriverBy::xpath('//li[contains(text(),"VND | Fund Out |")]'))->click();
    echo "Selected Account\n";
    sleep(1);
    
    // Insert Merchant Ref ID
    $driver->findElement(WebDriverBy::xpath('//input[@id="merchantrefno-inputEl"]'))->sendKeys(mt_rand());
    sleep(1);
    
    // Insert Amount
    $driver->findElement(WebDriverBy::xpath('//input[@id="amount-inputEl"]'))->sendKeys('10000');
    sleep(1);
    
    // Insert Remark
    // $driver->findElement(WebDriverBy::xpath('//input[@name="remark"]'))->sendKeys('test');
    $driver->findElement(WebDriverBy::xpath('/html/body/div[4]/div[2]/div/div/span/div/table[12]/tbody/tr/td[2]/textarea'))->sendKeys('test');
    sleep(1);
    
    // Insert Member Fund Out Information
    $driver->findElement(WebDriverBy::xpath('//input[@name="memberusername"]'))->sendKeys('abc');
    sleep(1);
    $driver->findElement(WebDriverBy::xpath('//input[@id="bankid-inputEl"]'))->sendKeys('Vietcom');
    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(
            WebDriverBy::xpath('//li[contains(text(),"Vietcom Bank")]'),
            'Vietcom Bank'
        )
    );
    $driver->findElement(WebDriverBy::xpath('//li[contains(text(),"Vietcom Bank")]'))->click();
    $driver->findElement(WebDriverBy::xpath('//input[@name="bankaccountno"]'))->sendKeys('123');
    $driver->findElement(WebDriverBy::xpath('//input[@name="bankaccountname"]'))->sendKeys('abc');
    $driver->findElement(WebDriverBy::xpath('//input[@name="bankbranch"]'))->sendKeys('test');

    // Submit form
    $driver->findElement(WebDriverBy::xpath('/html/body/div[4]/div[3]/div/div/a[1]/span/span/span[2]'))->click();
    
    sleep(3)        ;
    $driver->quit();

} catch (\Exception $ex) {
    echo 'Error  -  ' . $ex->getMessage() . "\n";
}

?>