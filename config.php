<?php
declare(strict_types=1);
return [
    'db' => ['host' => '127.0.0.1', 'port' => 3306, 'name' => 'cms', 'user' => 'root', 'pass' => '', 'charset' => 'utf8mb4'],
    'base_url' => 'http://cms.test',          // CLI ve host çözülemeyen durumlar için; web isteğinde adres Host başlığından üretilir
    // smtp: sistem e-postaları (şifre sıfırlama, 2FA) ve SMTP'si tanımsız sitelerin e-postaları için platform SMTP'si; host boşsa mail().
    // {slug}.cms.test → site; cms.test → platform tanıtım + yönetim
    'saas' => ['base_domain' => 'cms.test', 'brand_domain' => 'nettesoft.com', 'contact_email' => 'info@nettesoft.com',
        'smtp' => ['host' => '', 'port' => 587, 'secure' => 'tls', 'user' => '', 'pass' => '', 'from_email' => '', 'from_name' => '']],
    // 2FA anahtarlarını veritabanında şifreler; DEĞİŞTİRMEYİN (değişirse mevcut 2FA kayıtları okunamaz).
    'app_key' => '9aecbeff7862ea77c134f3c5f6fcc578478496adef242a3c953d4dc280245846',
    'debug' => true,
    'timezone' => 'Europe/Istanbul',
    'session_name' => 'CMSSESSID',
    'admin_idle_minutes' => 120,
    'admin_session_hours' => 12,              // girişten sonra en uzun oturum süresi (etkinlikten bağımsız)
    'trust_proxy' => false,                   // true ise X-Forwarded-For / X-Forwarded-Proto dikkate alınır
    'force_https' => false,                   // true ise Secure çerez her koşulda
    'rate_limit' => ['max_attempts' => 5, 'lock_minutes' => 15],
    // max_dimension: yüklenen görselin uzun kenarı bu pikselin üstündeyse küçültülür (0 = kapalı); image_quality: JPEG/WebP kalitesi
    'upload' => ['max_size' => 50 * 1024 * 1024, 'dir' => 'uploads', 'allow_office' => true, 'max_dimension' => 1920, 'image_quality' => 82],
    'curl_cainfo' => 'C:\\Program Files\\Git\\mingw64\\etc\\ssl\\certs\\ca-bundle.crt',  // WAMP'ta php.ini'de curl.cainfo yok
    'log_file' => __DIR__ . '/../storage.log',  // .htaccess FilesMatch .log ile korunur
];
