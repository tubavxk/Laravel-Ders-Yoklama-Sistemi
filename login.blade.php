<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yoklama Sistemi Giris</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(rgba(255, 255, 255, 0.66), rgba(255, 255, 255, 0.66)),
                url("https://images.pexels.com/photos/5212336/pexels-photo-5212336.jpeg") center center / cover no-repeat fixed,
                radial-gradient(circle at top left, rgba(20, 184, 166, 0.18), transparent 26%),
                radial-gradient(circle at bottom right, rgba(37, 99, 235, 0.18), transparent 30%),
                linear-gradient(180deg, #f6fbff 0%, #edf5ff 100%);
            color: #1f2937;
            padding: 24px;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.22);
            pointer-events: none;
        }
        
        .layout {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 24px;
            align-items: stretch;
            position: relative;
            z-index: 1;
        }
        
        .hero,
        .card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(12px);
        }
        
        .hero {
            padding: 34px;
            background: linear-gradient(145deg, #0f766e 0%, #14b8a6 55%, #ccfbf1 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.13);
            right: -40px;
            top: -30px;
        }
        
        .hero-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.24);
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 18px;
        }
        
        .hero h1 {
            margin: 0 0 14px;
            font-size: 38px;
            line-height: 1.15;
        }
        
        .hero p {
            margin: 0 0 24px;
            line-height: 1.7;
            max-width: 520px;
        }
        
        .feature-list {
            display: grid;
            gap: 12px;
        }
        
        .feature-item {
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card {
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .card h2 {
            margin: 0 0 10px;
            color: #0f172a;
            font-size: 28px;
        }
        
        .card p {
            margin: 0 0 22px;
            color: #64748b;
            line-height: 1.6;
        }
        
        .field {
            margin-bottom: 14px;
        }
        
        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #334155;
        }
        
        .field input {
            width: 100%;
            padding: 13px 14px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
        }
        
        .field input:focus {
            outline: none;
            border-color: #14b8a6;
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.12);
            background: white;
        }
        
        .btn {
            width: 100%;
            border: none;
            padding: 14px 16px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 14px 28px rgba(20, 184, 166, 0.22);
        }

        .btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }
        
        @media (max-width: 900px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <div class="hero">
            <div class="hero-badge">Yoklama Sistemi</div>
            <h1>Okul Yoklama Takip Projesi</h1>
            <p>Öğrenci, öğretmen ve admin panelleriyle yoklama ve ders yönetimi yapılabilir.</p>
            <div class="feature-list">
                <div class="feature-item">QR kod ile yoklama alma</div>
                <div class="feature-item">Ders ve kullanıcı yönetimi</div>
                <div class="feature-item">Devamsızlık takibi</div>
            </div>
        </div>
        <div class="card">
            <h2>Giriş Yap</h2>
            <p>Devam etmek için hesap bilgilerini gir.</p>
            <form method="POST" action="/login">
                @csrf
                <div class="field">
                    <label>Kullanıcı Adı / E-posta</label>
                    <input type="text" name="kullanici" placeholder="örnek@mail.com" required>
                </div>
                <div class="field">
                    <label>Şifre</label>
                    <input type="password" name="sifre" placeholder="Şifreni gir" required>
                </div>
                <button class="btn" type="submit">Giriş Yap</button>
            </form>
        </div>
    </div>
</body>
</html>


