---
name: volkanyenilmez-site
description: "SMMM Volkan Yenilmez sitesi (tema volkanyenilmez + üretici) ve nettesoft sunucusuna yayın bilgileri: DNS Turhost'ta, joker DNS yok, ServerAlias ile alt alan adı"
metadata:
  node_type: memory
  type: project
  originSessionId: 751752b8-7df8-4277-a3da-3ad09b996dfe
  modified: 2026-09-24T22:36:27.014Z
---

2026-09-25: Kullanıcının mali müşavir arkadaşı için `themes/volkanyenilmez` (KDV hesaplayıcılı `calculator.php` şablonu) ve `tools/import/sites/volkanyenilmez.php` (elle derlenmiş içerik + 25.09.2026'da doğrulanmış ~136 resmî bağlantı) yazıldı. Hedef: `volkanyenilmez.nettesoft.com` (slug `volkanyenilmez`).

Sunucu gerçekleri (server.nettesoft.com, SSH port 23422, kullanıcı rifate + sudo): CMS `/var/www/nettesoft.com/htdocs`, PHP 7.4, DB `nettesoft_com`; `*.nettesoft.com` SSL'i `nettesoft-wildcard` sertifikasıyla, ama alt alan adları `sites-enabled/nettesoft.com-443.conf` içinde **ServerAlias ile tek tek** tanımlı ve DNS **Turhost'ta, joker kayıt yok**; her yeni site için A kaydı (178.157.11.219) + ServerAlias gerekir. Eski volkanyenilmez.com aynı sunucuda kendi vhost'uyla canlı; dokunulmamalı.

Tasarım tercihleri (iki revizyondan sonra): eski volkanyenilmez.com'dan YALNIZCA logo (grafit sekmede "Mᵐ | VOLKAN YENİLMEZ") ve renkler (mavi #5D93D3, grafit #414550) alınacak; eski düzeni (çapraz paneller, büyük harf menü, yuvarlak ikon bandı) kopyalamak istenmedi. Modern-şık: açık zemin, yuvarlatılmış kartlar, Manrope+Inter, fotoğrafsız sayfa başlıkları. İkonlu kart yığını sevilmedi (kartlarda fotoğraf ya da vektör çizim), kartlarda sıra numarası YOK. Sunucuya kurulum `deploy/volkanyenilmez-kur.sh` ile kullanıcı tarafından çalıştırılıyor.

**Why:** Canlı sunucuya yazma adımı (site açma, Apache değişikliği) otomatik izin denetiminde durduruldu; kullanıcı onayı bekleniyor. Paket `/tmp/vy-deploy` altına yüklendi (şifre içermez).

**How to apply:** Sunucu komutlarını PowerShell 5.1'den tırnaklı vermek bozuluyor; betik dosyasını `ssh ... bash -s` ile stdin'den ver, Git Bash'te `MSYS_NO_PATHCONV=1` kullan (yoksa /tmp yolu Windows yoluna çevrilir). İçe aktarma sunucuda `sudo -u www-data` ile, favicon için `php -S 127.0.0.1:8767 -t tools/import/assets` açıkken çalıştırılır. Bkz. [[cms-headless-test-harness]], [[headless-screenshot-cdp]].

Güncelleme 2026-09-25: header/footer grafit (#414550), hero tam genişlik Ken Burns slider, CTA parallax bandı, iletişimde harita sayfa başlığının arkasında. Kullanıcı istekleri: "Serbest Muhasebeci Mali Müşavir · Antalya" gibi rozetler yerine ASMO (asmo.org.tr) bağlantılı rozet; Facebook yok; logo yazısı condensed olmasın (Manrope). Kur betiği `--tema` = yalnızca tema (içeriğe dokunmaz); içerik/üretici değişince tam çalıştırma gerekir (içeriği --replace ile ezer).

Alan adı taşıma (2026-09-25): volkanyenilmez.com NS → Cloudflare (proxy'li kök; MX/SPF/DKIM/DMARC taşındı, mail.volkanyenilmez.com → server.nettesoft.com DNS-only; sunucuda postfix/dovecot bu alan adına mail veriyor, dokunma). deploy/volkanyenilmez-domain.sh: ayrı 80/443 vhost (LE webroot /var/www/letsencrypt, cert-name volkanyenilmez.com), nettesoft.com-443 ServerAlias'tan kök alan adını çıkarır, sites.domain ayarlar, mod_remoteip CF-Connecting-IP. nettesoft.com'un 80 vhost'u yok (varsayılan any-q.me). Eski vhost dosyaları silinmiş ama sites-enabled symlink'leri kalmıştı.
