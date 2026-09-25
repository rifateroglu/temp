---
name: cms-headless-test-harness
description: "CMS'i WAMP'a dokunmadan uçtan uca test etme yolu (CMS_CONFIG + php -S router + Host başlığı); SaaS geçişinden sonra yerel `cms` DB'si hâlâ tek siteli şemadaydı"
metadata: 
  node_type: memory
  type: project
  originSessionId: d932e4e2-0ada-424f-9b5b-684df7eed6ef
  modified: 2026-09-25T12:56:55.389Z
---

Projeyi WAMP/config.php'ye dokunmadan test etmek için: scratchpad'e ayrı `config.php` (DB `cms_saas_test`, `saas.base_domain=cms.test`) yaz, `CMS_CONFIG=<yol>` ortam değişkeniyle `php -S 127.0.0.1:8099 router.php` başlat (router `.htaccess` taklidi: /admin → admin/index.php, statik uploads/themes/admin/assets doğrudan, kalan → index.php; SCRIPT_NAME'i elle ayarla). Siteler `curl -H "Host: demo.cms.test"` ile seçilir; admin için cookie jar + formdaki `_token` çekilir. Türkçe karakterli POST verisini yüzde kodlayarak gönder (curl bozuyor). Test DB'si `sed 's/`cms`/`cms_saas_test`/'` ile schema.sql'den kurulur; `mysqldump cms | mysql cms_upg_test` ile upgrade-saas.sql denenir. `tools/migrate-saas.php` gerçek `uploads/` dizinini taşır: testten sonra `uploads/{slug}/2026` → `uploads/2026` geri alınmalı.

WAMP MySQL çalışmıyorsa (2026-09-25'te kapalıydı) servise dokunma: scratchpad'de `mysqld.exe --no-defaults --initialize-insecure --basedir=C:/wamp64/bin/mysql/mysql8.2.0 --datadir=<sp>/mysqldata`, sonra arka planda `--port=3399 --mysqlx=OFF --console`; test config'inde port 3399; bitince `mysqladmin -P 3399 shutdown`. PHP'de curl'lü bir istemci (cookie jar, `_token` çekme, TOTP kodunu `Totp` sınıfından reflection ile üretme) bash curl'den daha rahat.

**Why:** 2026-09-19 SaaS dönüşümünde (PLAN.md bölüm 19) kullanıcının yerel `cms` veritabanı ve WAMP vhost'u eski tek siteli yapıda kaldı; kod artık `sites` tablosu ister. Kullanıcı yerelde `upgrade-saas.sql` + `migrate-saas.php` çalıştırmadıysa `cms.test` 500 verir.

**How to apply:** Değişiklikleri doğrularken bu harness'ı kur; kullanıcının DB'sine/uploads'ına yazma. Yerel sitenin çalışmadığı bildirilirse önce şemanın taşınıp taşınmadığına ve hosts/ServerAlias (`*.cms.test`) ayarına bak. İlgili: [[windows-bash-quirks]].
