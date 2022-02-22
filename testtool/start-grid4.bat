@echo off
setlocal
set host=127.0.0.1
set binpath=%~dp0\selenium-server-4.1.1.jar
title Selenium Grid
start "Selenium Hub"    cmd /K java -jar %binpath% hub  --host %host%
start "Selenium Node 1" cmd /K java -jar %binpath% node --host %host% --port 5555
start "Selenium Node 2" cmd /K java -jar %binpath% node --host %host% --port 5556
start "Selenium Node 3" cmd /K java -jar %binpath% node --host %host% --port 5557
