---
name: windows-bash-quirks
description: Bu ortamda (Windows Git Bash) uzun heredoc komutları kesiliyor ve curl Türkçe karakterleri UTF-8 dışı gönderiyor; çözüm yolları
metadata: 
  node_type: memory
  type: feedback
  originSessionId: 1cb281df-e3c7-424d-b78b-9084b7490b37
  modified: 2026-09-15T13:37:26.312Z
---

Bu makinede Bash tool ile çalışırken: (1) çok uzun heredoc'lu tek komutlar sessizce kesilip "unexpected EOF while looking for matching `'`" hatası veriyor; (2) curl ile `-d`/`--data-urlencode` içinde Türkçe karakter gönderince sunucuya UTF-8 dışı byte gidiyor ve `mb_check_encoding` değeri boşa düşürüyor.

**Why:** Büyük CSS/Python bloklarını heredoc ile göndermek iki kez başarısız oldu; curl testinde "Başlık TR" gibi değerler kayıp göründü ama yüzde kodlamalı (`Ba%C5%9Fl%C4%B1k`) gönderince düzgün kaydedildi, yani uygulama hatası değildi.

**How to apply:** Uzun içerikleri Write tool ile scratchpad'e yaz, sonra `cat`/`python` ile uygula. HTTP testlerinde Türkçe değerleri yüzde kodlamasıyla ver ya da Python `urllib` kullan. Bkz. [[cms-lint-command]].
