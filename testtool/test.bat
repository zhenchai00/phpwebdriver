@echo off
taskkill /fi "windowtitle eq Test*" /t /f
title Test
start "Test 1" php test.php %*
start "Test 2" php test.php %*
start "Test 3" php test.php %*
start "Test 4" php test.php %*
start "Test 5" php test.php %*
start "Test 6" php test.php %*
start "Test 7" php test.php %*
start "Test 8" php test.php %*
start "Test 9" php test.php %*
start "Test 10" php test.php %*