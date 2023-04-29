import ipaddress
import subprocess

# substitua pelas informações de sua rede
network = '10.2.2.0/24'
subnet_mask = '255.255.255.255'
default_gateway = '10.13.28.0'

# converte a máscara de sub-rede para o formato correto
subnet = ipaddress.IPv4Network('10.82.23.0/24', subnet_mask)

# percorre todos os endereços IP possíveis na rede
for ip in subnet.hosts():
    # envia um comando de ping para o endereço IP
    response = subprocess.Popen(['ping', '-n', '1', '-w', '500', str(ip)], stdout=subprocess.PIPE).communicate()[0]
    # verifica se o dispositivo respondeu ao ping
    if 'Resposta' in str(response):
        print(f'{ip} está ativo')

