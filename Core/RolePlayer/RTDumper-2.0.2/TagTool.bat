@echo off
cls
IF EXIST "c:\php\php.exe" (
  echo dumping .\Output\mechs.csv	
  c:\php\php.exe --no-php-ini -d memory_limit=4096M .\php\dump.php
  c:\php\php.exe --no-php-ini -d memory_limit=4096M .\php\dumpstats.php
  c:\php\php.exe --no-php-ini -d memory_limit=4096M .\php\aitag.php
  c:\php\php.exe --no-php-ini -d memory_limit=4096M .\php\writetag.php
) ELSE (
  echo You should have a php 7 install in c:\php. Get it from https://windows.php.net/download/ and extract to c:\php
)
pause
