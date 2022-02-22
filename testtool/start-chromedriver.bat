@echo off
rem Chromedriver
title Chrome Driver
%~dp0\driver\chromium\chromedriver.exe --port=4444 --append-log --log-path=chromedriver.log --log-level=ALL
