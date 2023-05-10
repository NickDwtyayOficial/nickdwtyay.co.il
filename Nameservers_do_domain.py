import socket
import whois

def get_nameservers(domain_name):
    ip_address = socket.gethostbyname(domain_name)
    w = whois.whois(domain_name)
    if isinstance(w.name_servers, list):
        return w.name_servers
    else:
        return [w.name_servers]

# exemplo de uso
domain = "nickdwtyay.com.br"
nameservers = get_nameservers(domain)
print(f"Nameservers do domínio {domain}:")
for ns in nameservers:
    print(ns)
