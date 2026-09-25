---
name: headless-screenshot-cdp
description: "Tema/admin görsel kontrolü için Edge headless + CDP (node) ile ekran görüntüsü; --window-size 500px altına inmiyor, hover/mobil/çerez/JS için CDP şart; lazy görsel beklemesi asılı kalır"
metadata: 
  node_type: memory
  type: reference
  originSessionId: 719e9ebe-14f3-48fd-9fb6-2a128fbc72ab
  modified: 2026-09-22T21:47:16.821Z
---

Tema değişikliklerini görsel doğrulamak için `msedge.exe --headless=new --screenshot` yeterli değil: pencere genişliği ~500px altına inmiyor (390px mobil görüntüsü yanıltıcı kırpılmış çıkıyor), hover yapılamıyor, çerez/giriş verilemiyor. Çalışan yol: Edge'i `--remote-debugging-port` + taze `--user-data-dir` ile başlatıp Node 22 (global `fetch`/`WebSocket`) üzerinden CDP: `Emulation.setDeviceMetricsOverride` (1440×900 ya da mobil), `Network.setCookie` (admin oturumu: curl cookie jar'daki `CMSSESSID`), `Runtime.evaluate` (`awaitPromise` ile tıklama/iframe testleri), `Input.dispatchMouseEvent` (hover), `Page.captureScreenshot`. Site `http://cms.test` / `http://{slug}.cms.test` (X-Frame-Options SAMEORIGIN; farklı origin iframe önizleme olmaz).

Tuzaklar: (1) `document.images` üzerinde "hepsi yüklensin" sözü **asla çözülmez** — `loading="lazy"` görseller ekran dışında yüklenmez; sabit 2–3 sn bekle. (2) `Runtime.evaluate` ifadesindeki söz `setTimeout` içinde hata fırlatırsa çağrı sonsuza dek asılı kalır: try/catch + kendi zaman aşımıyla `res('ERR …')` döndür, iframe için `readyState==='complete'` + hedef seçiciyi poll et. (3) Çerez şeridi/animasyonlu carousel caption'ı görüntüyü bozar: geçici DB kopyasında `cookie_text` sil, caption animasyonu (~1 sn) bitince çek. (4) Aynı `--user-data-dir` tekrar kullanılırsa varlıklar önbellekten gelebilir; `edge-cdp-*` dizinleri Edge kapanmadan silinemiyor (`taskkill //F //IM msedge.exe`).

Tema önizlemeleri (`themes/*/assets/screenshot.jpg`, 1200×750) bu yolla üretildi: `cms` DB'si `cms_shot_tmp`'ye kopyalanıp `CMS_CONFIG` ile `php -S 127.0.0.1:8099` üzerinde her sitenin `active_theme`'i değiştirilerek (`{slug}.cms.test:8099`, port `Site::resolveHost`'ta atılıyor) çekildi, GD ile kırpılıp JPEG'e çevrildi. PIL kurulu değil; kırpma/boyutlandırma için PHP GD kullan. Bkz. [[windows-bash-quirks]] (uzun python/heredoc betiklerini Write ile dosyaya yaz), [[cms-headless-test-harness]].

**Ek tuzaklar (2026-09-23):** (5) CDP `send()` yanıtında değer `msg.result.result.value` içindedir (`{result}` diye tek kat açmak NaN verir, `captureScreenshot` "double value expected" der). (6) `captureBeyondViewport: true` yalnızca tam sayfa çekimde verilmeli; viewport çekiminde `position: fixed` paneller ve reveal animasyonları bozulur. (7) Mobil emülasyonda yatay taşan bir eleman (ör. `:has()` ile 3 sütuna zorlanmış grid) layout viewport'u genişletir: `innerWidth` 758 olur, medya sorguları yanlış kırılımda çalışır — önce `getBoundingClientRect().right > vw` ile taşanı bul. (8) `backdrop-filter`'lı header, içindeki `position: fixed` menü panelini header'a hapseder (containing block); mobilde filtreyi kaldır. Hover/tıklama/kaydırma argümanlı çekim betiği her oturumda scratchpad'e `shot.js` olarak yeniden yazılıyor (Edge `--host-resolver-rules=MAP *.cms.test 127.0.0.1` ile hosts kaydı gerekmez).
