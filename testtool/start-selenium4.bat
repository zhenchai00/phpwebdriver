@echo off
setlocal
set host=127.0.0.1
title Selenium Server 4
java -jar selenium-server-4.1.1.jar standalone --host %host%