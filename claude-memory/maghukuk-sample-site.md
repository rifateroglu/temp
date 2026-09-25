---
name: maghukuk-sample-site
description: "Kurgusal \"MAG Hukuk Bürosu\" örnek sitesi (slug maghukuk, site id 4) ve iki hukuk teması (maghukuk klasik, maghukukv2 editoryal) — nasıl yeniden üretilir, giriş bilgileri, hosts gereksinimi"
metadata: 
  node_type: memory
  type: project
  originSessionId: 426651f2-39b2-45c2-80e5-c37002445242
  modified: 2026-09-22T22:48:16.983Z
---

2026-09-23: Avukatlar için iki tema yazıldı (`themes/maghukuk` lacivert+altın klasik, `themes/maghukukv2` kırık beyaz+bordo editoryal) ve kurgusal örnek site `maghukuk` (id 4, `maghukuk.cms.test`) yerel `cms` DB'sinde açıldı; her iki tema `theme_access` ile herkese açık. Site yöneticisi `maghukuk / Maghukuk123!` (yalnızca geliştirme). İçerik `tools/import/sites/maghukuk.php` üreticisinden gelir (gerçek kaynak yok; görseller Unsplash, `plus.unsplash.com` filigranlı olduğundan kullanılmaz); yeniden kurmak için: `php -S 127.0.0.1:8767 -t tools/import/assets` (favicon) → `php tools/import/sites/maghukuk.php [--theme=maghukukv2]` → `php tools/import/import.php tools/import/output/maghukuk.json --site=maghukuk --replace`. Site tek dilli (EN pasif), adresler `/slug` (dil öneki yok).

**Why:** Kullanıcının hukuk alanında henüz müşterisi yok; temalar vitrin/şablon amaçlı. Yerel hosts dosyasında `maghukuk.cms.test` kaydı YOK — tarayıcıda açmak için kullanıcı eklemeli (curl `Host:` başlığı ve Edge `--host-resolver-rules` ile test edildi).

**How to apply:** Hukuk temalarına dokunurken içeriğin iki temada da çalıştığını unutma (içerik sınıfları ortak: split, value-grid, check-list, cta-box, timeline, quote-band; `btn-primary`/`btn-gold` iki temada takma ad). Tema kartı ekran görüntüleri 1440×900 viewport → GD ile 1200×750. Bkz. [[headless-screenshot-cdp]], [[cms-headless-test-harness]].
