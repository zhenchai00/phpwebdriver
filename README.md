# PHP WebDriver
- This project is to understand the [PHP Webdriver](https://github.com/php-webdriver/php-webdriver) and help to reduce time on testing managing system

## Installation
- Install [Chromium](https://chromium.woolyss.com/) and [ChromeDriver](https://chromedriver.chromium.org/downloads) with the version compatible with Chromium you have installed
- Copy the ChromeDriver that downloaded paste it to the same file path with the Chromium.exe
- On your PC device, add new environment variable by `WEBDRIVER_CHROME_DRIVER=/file/path/of/your/chromedriver.exe`
- After that install dependencies from [composer.json](composer.json)
- Add `$port = mt_rand(49152, 65535);` on file `/vendor/php-webdriver/webdriver/lib/Chrome/ChromeDriverService.php`, line 33 and comment out the line 32
- You should able to run the `example.php` by using php command

## Determine Xpath or CssSelector
### StackOverFlow
- [Ways to get xpath in Google Chrome](https://stackoverflow.com/questions/3030487/is-there-a-way-to-get-the-xpath-in-google-chrome#answer-46599584)
- [How to Find XPath in Chrome Browser](https://www.scientecheasy.com/2020/07/find-xpath-chrome.html/)

### CheatSheet
- [Dev Hints - XPath](https://devhints.io/xpath)