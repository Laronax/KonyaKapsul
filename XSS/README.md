# XSS Demo Uygulaması

Bu proje, Cross-Site Scripting (XSS) güvenlik açığını göstermek için tasarlanmış bir PHP uygulamasıdır.

## 🚨 Önemli Uyarı

**Bu uygulama sadece eğitim ve test amaçlıdır. Gerçek uygulamalarda kullanmayın!**

## 🎯 Özellikler

- Kullanıcı request'lerini görüntüleme
- GET ve POST parametrelerini gösterme
- HTTP header'larını listeleme
- Tam URL bilgisini gösterme
- URL fragment'larını yakalama
- XSS açığı demo'su
- Modern ve responsive UI

## 🛠️ Kurulum

### Gereksinimler
- Docker
- Docker Compose

### Adımlar

1. Projeyi klonlayın:
```bash
git clone <repository-url>
cd XSS
```

2. Docker container'ını başlatın:
```bash
docker-compose up --build
```

3. Tarayıcınızda şu adresi açın:
```
http://localhost:8080
```

## 🧪 XSS Test Örnekleri

### GET Parametresi ile Test
```
http://localhost:8080/?input=<script>alert('XSS!')</script>
```

### Farklı XSS Payload'ları
```
?input=<img src=x onerror=alert('XSS')>
?input=<svg onload=alert('XSS')></svg>
?input=<iframe src="javascript:alert('XSS')"></iframe>
```

### URL Fragment ile Test
```
http://localhost:8080/?input=test#<script>alert('Fragment XSS')</script>
```

## 🔍 Nasıl Çalışır

1. **Request Bilgileri**: Kullanıcıdan gelen tüm request bilgileri sayfada gösterilir
2. **XSS Açığı**: `input` GET parametresi doğrudan JavaScript koduna yazılır
3. **URL Fragment**: JavaScript ile URL fragment'ı yakalanır
4. **Gizli Script**: Tüm bilgiler gizli bir div'e yazılır

## 📁 Proje Yapısı

```
XSS/
├── docker-compose.yml    # Docker servis konfigürasyonu
├── Dockerfile           # PHP Apache image tanımı
├── src/
│   └── index.php       # Ana uygulama dosyası
└── README.md           # Bu dosya
```

## 🚀 Docker Komutları

```bash
# Container'ı başlat
docker-compose up

# Arka planda çalıştır
docker-compose up -d

# Container'ı durdur
docker-compose down

# Log'ları görüntüle
docker-compose logs

# Container'ı yeniden oluştur
docker-compose up --build
```

## 🔒 Güvenlik Notları

Bu uygulama kasıtlı olarak güvenlik açıkları içerir:

- **XSS Açığı**: Kullanıcı input'u doğrudan script'e yazılır
- **Input Validation**: Hiçbir input doğrulaması yapılmaz
- **Output Encoding**: Çıktı encoding'i yapılmaz

## 📚 Öğrenme Kaynakları

- [OWASP XSS](https://owasp.org/www-community/attacks/xss/)
- [XSS Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
- [PortSwigger XSS](https://portswigger.net/web-security/cross-site-scripting)

## 🤝 Katkıda Bulunma

Bu proje eğitim amaçlıdır. Güvenlik açıklarını daha iyi anlamak için önerilerinizi bekliyoruz.

## 📄 Lisans

Bu proje eğitim amaçlıdır ve herhangi bir lisans altında değildir.
