@echo off
echo Executando ipconfig /all
ipconfig /all
echo Aguardando 20 segundos...
timeout /t 20 /nobreak >nul

echo Executando ipconfig /release
ipconfig /release
timeout /t 20 /nobreak >nul

echo Executando ipconfig /flushdns
ipconfig /flushdns
timeout /t 20 /nobreak >nul

echo Executando ipconfig /renew
ipconfig /renew
timeout /t 20 /nobreak >nul

echo Executando ipconfig /registerdns
ipconfig /registerdns
timeout /t 20 /nobreak >nul

echo Executando netsh int ipv4 reset
netsh int ipv4 reset
timeout /t 20 /nobreak >nul

echo Executando netsh int ipv6 reset
netsh int ipv6 reset
timeout /t 20 /nobreak >nul

echo Executando netsh int tcp reset
netsh int tcp reset
timeout /t 20 /nobreak >nul

echo Executando netsh winsock reset
netsh winsock reset
timeout /t 20 /nobreak >nul

echo Concluído!
