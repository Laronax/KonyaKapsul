<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Demo Uygulaması</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .request-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .hidden-script {
            display: none;
        }
        .url-display {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: monospace;
            word-break: break-all;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔒 XSS Demo Uygulaması</h1>
        
        <div class="warning">
            <strong>⚠️ Uyarı:</strong> Bu uygulama güvenlik açıklarını göstermek için tasarlanmıştır. 
            Gerçek uygulamalarda kullanmayın!
        </div>

        <h2>📝 Kullanıcı Request Bilgileri</h2>
        
        <div class="request-info">
            <h3>GET Parametreleri:</h3>
            <?php if (!empty($_GET)): ?>
                <ul>
                <?php foreach ($_GET as $key => $value): ?>
                    <li><strong><?php echo htmlspecialchars($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>GET parametresi bulunamadı.</p>
            <?php endif; ?>
        </div>

        <div class="request-info">
            <h3>POST Verileri:</h3>
            <?php if (!empty($_POST)): ?>
                <ul>
                <?php foreach ($_POST as $key => $value): ?>
                    <li><strong><?php echo htmlspecialchars($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>POST verisi bulunamadı.</p>
            <?php endif; ?>
        </div>

        <div class="request-info">
            <h3>HTTP Headers:</h3>
            <ul>
            <?php foreach (getallheaders() as $name => $value): ?>
                <li><strong><?php echo htmlspecialchars($name); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
            <?php endforeach; ?>
            </ul>
        </div>

        <div class="request-info">
            <h3>Tam URL:</h3>
            <div class="url-display">
                <?php 
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                $host = $_SERVER['HTTP_HOST'];
                $uri = $_SERVER['REQUEST_URI'];
                $fullUrl = $protocol . '://' . $host . $uri;
                echo htmlspecialchars($fullUrl);
                ?>
            </div>
        </div>

        <!-- XSS Açığı: Kullanıcı input'u doğrudan script içine yazılıyor -->
        <div class="hidden-script">
            <script>
                // ⚠️ XSS AÇIĞI: Kullanıcı input'u doğrudan script'e yazılıyor
                var userInput = "<?php 
                    $input = isset($_GET['input']) ? $_GET['input'] : '';
                    echo $input; // Bu satır XSS açığı oluşturuyor!
                ?>";
                
                // URL fragment'ı da dahil et
                var currentUrl = window.location.href;
                var urlFragment = window.location.hash;
                
                // Gizli div oluştur ve URL bilgilerini yaz
                var hiddenDiv = document.createElement('div');
                hiddenDiv.style.display = 'none';
                hiddenDiv.innerHTML = 'URL: ' + currentUrl + '<br>Fragment: ' + urlFragment + '<br>User Input: ' + userInput;
                document.body.appendChild(hiddenDiv);
                
                console.log('XSS Demo - URL:', currentUrl);
                console.log('XSS Demo - Fragment:', urlFragment);
                console.log('XSS Demo - User Input:', userInput);
            </script>
        </div>

        <h2>🧪 Test Etmek İçin</h2>
        <p>Aşağıdaki URL'leri deneyin:</p>
        <ul>
            <li><code>?input=&lt;script&gt;alert('XSS!')&lt;/script&gt;</code></li>
            <li><code>?input=&lt;img src=x onerror=alert('XSS')&gt;</code></li>
            <li><code>?input=&lt;svg onload=alert('XSS')&gt;&lt;/svg&gt;</code></li>
        </ul>

        <h2>📋 Form Test</h2>
        <form method="POST" action="">
            <label for="testInput">Test Input:</label><br>
            <input type="text" id="testInput" name="testInput" placeholder="XSS payload'ı buraya yazın" style="width: 100%; padding: 10px; margin: 10px 0;">
            <br>
            <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Gönder</button>
        </form>

        <?php if (isset($_POST['testInput'])): ?>
        <div class="request-info">
            <h3>Form Sonucu:</h3>
            <p><strong>Gönderilen veri:</strong> <?php echo $_POST['testInput']; ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
