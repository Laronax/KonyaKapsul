# SQL Injection Demo Application

Bu proje, SQL injection açıklarını göstermek için tasarlanmış bir PHP web uygulamasıdır. **Sadece eğitim amaçlı kullanılmalıdır.**

## 🚨 UYARI

Bu uygulama kasıtlı olarak SQL injection açıkları içermektedir. Gerçek bir üretim ortamında kullanmayın!

## 🏗️ Proje Yapısı

```
SQLi/
├── Dockerfile              # PHP Apache container
├── docker-compose.yml      # Docker compose konfigürasyonu
├── init.sql               # Veritabanı başlangıç scripti
├── config.php             # Veritabanı bağlantısı
├── index.php              # Login sayfası (SQLi açıklı)
├── search.php             # Arama sayfası (SQLi açıklı)
└── README.md              # Bu dosya
```

## 🚀 Kurulum ve Çalıştırma

### Gereksinimler
- Docker
- Docker Compose

### Adımlar

1. Projeyi klonlayın:
```bash
git clone <repository-url>
cd SQLi
```

2. Docker container'larını başlatın:
```bash
docker-compose up -d
```

3. Tarayıcınızda şu adresi açın:
```
http://localhost:8080
```

4. Uygulama hazır! 

## 🔓 SQL Injection Açıkları

### Login Sayfası (index.php)

**Vulnerable Query:**
```php
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

**SQL Injection Örnekleri:**
- Username: `admin' --` (Password: herhangi bir şey)
- Username: `' OR '1'='1` (Password: herhangi bir şey)
- Username: `' UNION SELECT 1,2,3,4,5 --` (Password: herhangi bir şey)

### Search Sayfası (search.php)

**Vulnerable Query:**
```php
$sql = "SELECT * FROM products WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%' OR category LIKE '%$search_query%'";
```

**SQL Injection Örnekleri:**
- Union-based: `' UNION SELECT username,password,email,4,5 FROM users --`
- Boolean-based: `' OR '1'='1`
- Error-based: `' AND (SELECT 1 FROM (SELECT COUNT(*),CONCAT(0x7e,(SELECT version()),0x7e,FLOOR(RAND(0)*2))x FROM information_schema.tables GROUP BY x)a) --`

## 🗄️ Veritabanı

**Users Tablosu:**
- admin/admin123
- user1/password123
- test/test123
- demo/demo123

**Products Tablosu:**
- Laptop, Smartphone, Book, Headphones, Tablet

## 🛠️ Teknik Detaylar

- **PHP Version:** 8.1
- **Web Server:** Apache
- **Database:** MySQL 8.0
- **Frontend:** Bootstrap 5.1.3
- **Port:** 8080 (Web), 3306 (MySQL)

## 📚 Öğrenme Hedefleri

1. SQL injection açıklarının nasıl oluştuğunu anlamak
2. Farklı SQL injection tekniklerini test etmek
3. Güvenlik açıklarının etkilerini görmek
4. Prepared statements kullanmanın önemini kavramak

## 🔒 Güvenlik Önlemleri

Gerçek uygulamalarda şu önlemleri alın:

1. **Prepared Statements** kullanın
2. **Input Validation** yapın
3. **Parameterized Queries** kullanın
4. **Least Privilege Principle** uygulayın
5. **WAF (Web Application Firewall)** kullanın

## 🧪 Test Etme

1. Login sayfasında SQL injection payload'larını deneyin
2. Search sayfasında farklı SQL injection tekniklerini test edin
3. Veritabanından veri çekmeye çalışın
4. Hata mesajlarını analiz edin

## 📝 Lisans

Bu proje eğitim amaçlıdır. Sorumlu kullanın!

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun
3. Commit yapın
4. Push yapın
5. Pull Request oluşturun
