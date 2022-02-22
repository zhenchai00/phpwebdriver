@echo off
title Test run file

echo Start the ChromeDriver
echo #################################
: cmd /k "C:\Program Files\chrome-win\chromedriver.exe & php C:\laragon\www\phpwebdriver\example.php "
start "C:\Program Files\chrome-win\chromedriver.exe"
start php C:\laragon\www\phpwebdriver\example.php %*
pause
: echo #################################
: echo Done execute
: cmd /k "cd C:\laragon\www\phpwebdriver & php example.php"
: execute
: echo Please Type A Command Here:
: set /p cmd=Command:
: %cmd%
: goto execute

