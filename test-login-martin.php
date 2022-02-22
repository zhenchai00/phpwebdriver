<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Exception;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeDriver;

require_once('vendor/autoload.php');

try {
    $capabilities = DesiredCapabilities::chrome();

    $driver = ChromeDriver::start($capabilities);
    $driver->get('http://192.168.28.103/operator.php');

    // write 'username' in the search box
    $driver->findElement(WebDriverBy::id('username')) // find search input element
        ->sendKeys('operatora'); // fill the search box

    echo " Entered username\n";
    sleep(1);

    // write 'password' in the search box
    $driver->findElement(WebDriverBy::id('clrpasswd')) // find search input element
        ->sendKeys('asdf1234'); // fill the search box

    echo " Entered password\n";  

    // click to reload captcha
    $driver->findElement(WebDriverBy::xpath('//*[@id="login-form"]/center/div[5]/a/img'))->click();
    sleep(2);

    // focus on captcha input box
    $driver->findElement(WebDriverBy::id('captcha'))->click();
    sleep(1);

    $loginTime = time();
    while(time() - $loginTime < 6 ){
        echo "Sleep for 3 seconds to wait for manual captcha input\n"; 
        sleep(3);

        $getCaptcha = $driver->findElement(WebDriverBy::id('captcha'))->getAttribute('value');

        if (strlen(trim($getCaptcha)) == 4) {
            echo "Captcha entered: " . $getCaptcha . "\n";
            echo "Received Captcha\n";
            $driver->findElement(WebDriverBy::id('login'))->click();
            sleep(1);
            echo "Login in progress...\n";
            break;
        }
    }

    if (strlen(trim($getCaptcha)) < 4 && strlen(trim($getCaptcha)) != 0) {
        echo "Captcha entered: " . $getCaptcha . "\n";
        throw new Exception("Captcha is invalid!\n");

        // terminate the session and close the browser
        $driver->quit();
    }
    elseif (strlen(trim($getCaptcha)) == 0) {
        throw new Exception("Captcha is empty!\n");
        // terminate the session and close the browser
        $driver->quit();
    }

    $element = $driver->findElement(WebDriverBy::xpath('/html/body/div[1]/div[1]/div[1]/div[2]/table/tbody/tr/td[5]/a'));
    if ($element->isDisplayed()) {
        // do something...
        echo $element->getAttribute('innerText');
        $driver->quit();
    }

    echo 'Login successfully!';
    // terminate the session and close the browser
    $driver->quit();

} catch (\Exception $e) {
    echo 'Error  -  ' . $e->getMessage() . "\n";
    $driver->quit();
}

?>