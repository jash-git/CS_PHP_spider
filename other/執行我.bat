del %cd%\root\Data_buy.txt
del %cd%\root\Data_sell.txt
del %cd%\Data_buy.csv
del %cd%\Data_sell.csv

start usbwebserver.exe
wget.exe "http://localhost:8080/php_curl_https.php" -O wait.txt
taskkill /f /im usbwebserver.exe

copy %cd%\root\Data_buy.txt %cd%\Data_buy.csv
copy %cd%\root\Data_sell.txt %cd%\Data_sell.csv
del %cd%\wait.txt

