# 💫 About Us  

Welcome to the official repository of **Nick Dwtyay**, an initiative by **Nick Dwtyay Ltd.**, a pioneering company in **telecommunications, cybersecurity, and technology**, operating across **the Americas and the Middle East**.  

Founded in **2006** by **Nicássio Guimarães**, the brand began as a creative pseudonym on Orkut and evolved into a **global ecosystem of innovation, media, and technology**, empowering communities with digital solutions.  

---

## 🌐 General Information  

- 📍 **Headquarters**: Unknown
- 🗓️ **Founded**: 2006  
- 📧 **Contact**: [contato@nickdwtyay.com.br](mailto:contato@nickdwtyay.com.br)  
- 🌐 **Website**: [nickdwtyay.com.br](https://nickdwtyay.com.br)  

![Version](https://img.shields.io/badge/version-2.2-blue) ![Build Status](https://img.shields.io/badge/build-passing-green) ![Contributors](https://img.shields.io/badge/contributors-1-orange)  

---

## 🛤️ Our Journey  

Nick Dwtyay’s trajectory is defined by **resilience, creativity, and digital transformation**:  

- **2006** – Emerged on Orkut as a pseudonym to protect Nicássio’s identity.  
- **2010–2012** – Transitioned to Facebook, maintaining anonymity while expanding reach.  
- **2014–2017** – Launched the [YouTube channel](https://www.youtube.com/nickdwtyay), with a viral video hitting **100K views**.  
- **2017** – Created the community-focused blog **Candeal Notícia** (hosted on Blogger), mastering **HTML/CSS**.  
- **2018** – Retired the blog, leaving a positive legacy. you can check it here https://web.archive.org/web/20181122114420/http://candealbanoticias.blogspot.com/
- **2018–2021** – Expanded to series and content on **Kwai/TikTok**, with videos surpassing **1M views**.  
- **2021–2025** – Grew Kwai to **10K+ followers** and **300+ videos**; launched [nickdwtyay.com.br](https://nickdwtyay.com.br) (GitHub Pages) using **Canvas, SVG, PHP**, and **Supabase**.  
- **2025** – Released cybersecurity tools like the **DNS Cleanup Tool** (v2.2 in testing).  

---

## 💼 Key Projects  

- 🔧 **[Community Server](https://github.com/NickDwtyayOficial/community-server)**: Python scripts for network monitoring.  
- 🧹 **[Cache & DNS Cleanup Tool](https://github.com/NickDwtyayOficial/nickdwtyay.co.il/blob/main/Command-ipconfig-Nick-Dwtyay-Ltd.bat)**: Optimizes system performance via cache/DNS flushing.  

---

## 🚀 Getting Started  

**Prerequisites:**  
- OS: Windows, Linux, macOS  
- Languages: Python 3.8+, PHP, HTML, CSS, JavaScript  
- Tools: Scapy, GCC, pip, Vercel, Supabase, Cloudflare, WordPress  

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/NickDwtyayOficial/Full-Network-Reset-Tool.git
   cd Full-Network-Reset-Tool
pip install -r requirements.txt  
cp .env.example .env  
python main.py  
```  

---

## 🛠️ How to Use
  

Windows Script – Cache/DNS Cleanup:  
```bat  
@echo off
:: Full Network Reset Tool v2.2
:: Copyright (c) 2025 Nick Dwtyay Ltd.

echo [1/5] Flushing DNS cache...
ipconfig /flushdns

echo [2/5] Resetting TCP/IP stack...
netsh int ip reset reset.log

echo [3/5] Clearing temp files...
del /q /s %temp%\*

echo [4/5] Renewing IP address...
ipconfig /release && ipconfig /renew

echo [5/5] Rebooting interfaces...
netsh interface set interface "Ethernet" admin=disable
netsh interface set interface "Ethernet" admin=enable
```  
More examples in [`docs/usage.md`](docs/usage.md).  

---

## 🤝 Contributing  

1. Read the [Contribution Guidelines](CONTRIBUTING.md).  
2. Create your branch:  
   ```bash  
   git checkout -b my-feature  
   ```  
3. Submit a **Pull Request** with a clear description.  
4. Report issues via [GitHub Issues](https://github.com/NickDwtyayOficial/nickdwtyay/issues).  

---

## 📄 License  

This software is licensed under:  

- **Permissions**: Personal/commercial use (non-exclusive, non-transferable).  
- **Restrictions**: No copying, modification, distribution, or sublicensing without formal authorization.  
- **Copyright**: All rights reserved by **Nick Dwtyay Ltd.**  

Full details in [`LICENSE`](LICENSE).  

---

## 👤 Author  

**Nicássio Guimarães** (Pseudonym: Nick Dwtyay)  
[LinkedIn](https://il.linkedin.com/in/nic%C3%A1ssio-guimar%C3%A3es-b0660223b) | [Instagram](https://www.instagram.com/nic2ss7o) | [TikTok](https://www.tiktok.com/@nick.dwtyay)  

---

## 🌎 Connect With Us  

- 🌐 [Official Website](https://nickdwtyay.com.br) — **6K+ monthly visits (2024)**  
- 📍 [Google Business](https://nickdwtyayltd.business.site)  
- 🎥 [Kwai](https://www.kwai.com/@NICK_DWTYAY) — **10K+ followers, 17K views/month**  
- 🎧 [SoundCloud](https://soundcloud.com/nick-dwtyay)  
- 🎶 [Spotify](https://open.spotify.com/user/22seuxxasmpnyt5gsobxyzfty)  
- 🐦 [Twitter](https://x.com/dwtyayp)  
- 📸 [Official Instagram](https://www.instagram.com/nickdwtyay)  
- 🎬 [YouTube](https://www.youtube.com/nickdwtyay) — **100K+ views milestone**  
- 📝 [Pensador](https://www.pensador.com/colecao/nicassiocguimaraes/)  

---

## 🤝 Partnerships  

Currently collaborating with:  
- [Contabil-D](https://contabil-d.com.br)  
*(More partners coming soon.)*  
