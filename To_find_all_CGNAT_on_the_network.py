import socket

def is_cgnat(ip, port):
    # Conecta-se ao servidor na porta especificada e obtém o endereço IP e a porta atribuídos pelo CGNAT
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.settimeout(1)
    try:
        s.connect((ip, port))
        addr = s.getsockname()
        s.close()
    except:
        return False

    # Verifica se o endereço IP atribuído pelo CGNAT está em uma faixa privada de endereços
    octets = addr[0].split('.')
    if octets[0] == '10' or (octets[0] == '172' and int(octets[1]) >= 16 and int(octets[1]) <= 31) or (octets[0] == '192' and octets[1] == '168'):
        return True
    else:
        return False

def find_cgnats(start_ip, end_ip, port):
    # Itera sobre todos os endereços IP no intervalo especificado e verifica se cada um é um CGNAT
    for i in range(int(start_ip.split('.')[3]), int(end_ip.split('.')[3])+1):
        ip = start_ip.rsplit('.', 1)[0] + '.' + str(i)
        if is_cgnat(ip, port):
            print(ip, "é um CGNAT")

# Exemplo de uso
find_cgnats('192.168.1.1', '192.168.1.254', 80)
