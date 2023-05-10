import whois

def get_domain_info():
    domain_name = input("nickdwtyay.com.br: ")
    if not domain_name.startswith("www."):
        domain_name = "www." + domain_name
    domain = whois.whois(domain_name)
    print(domain)

get_domain_info() 
