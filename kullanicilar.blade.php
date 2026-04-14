<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanicilar</title>
    <style>
        :root {
            --sky-50: #f8fbff;
            --sky-100: #eef6ff;
            --sky-200: #dbeafe;
            --sky-300: #bfdbfe;
            --sky-400: #93c5fd;
            --sky-500: #74b4f3;
            --sky-600: #4f8fda;
            --ink: #1f2937;
            --ink-soft: #64748b;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(191, 219, 254, 0.36), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef6ff 52%, #e8f3ff 100%);
            color: var(--ink);
        }
        
        .navbar {
            background: linear-gradient(90deg, #4f8fda, #74b4f3);
            color: white;
            padding: 18px 30px;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 10px 28px rgba(79, 143, 218, 0.2);
        }
        
        .container {
            max-width: 1180px;
            margin: 28px auto;
            padding: 0 20px 40px;
        }
        
        .hero {
            background: linear-gradient(135deg, #5d9de5, #8ec4fb);
            color: white;
            padding: 28px;
            border-radius: 22px;
            margin-bottom: 22px;
            box-shadow: 0 18px 40px rgba(93, 157, 229, 0.22);
        }
        
        .hero h1 {
            margin: 0 0 10px;
            font-size: 34px;
        }
        
        .hero p {
            margin: 0;
            opacity: 0.95;
            line-height: 1.6;
        }
        
        .layout {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 20px;
        }
        
        .panel {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.97) 0%, rgba(239, 247, 255, 0.94) 100%);
            border: 1px solid rgba(173, 208, 255, 0.72);
            border-radius: 20px;
            box-shadow: 0 14px 30px rgba(59, 130, 246, 0.08);
            padding: 22px;
        }

        .panel::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 6px;
            background: linear-gradient(90deg, rgba(79, 143, 218, 0.82), rgba(191, 219, 254, 0.96));
        }
        
        .panel h2 {
            margin-top: 0;
            color: #24508e;
        }
        
        .field {
            margin-bottom: 14px;
        }
        
        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #355070;
        }
        
        .field input,
        .field select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #c6d9f6;
            background: #f8fbff;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        
        .btn {
            display: inline-block;
            border: none;
            padding: 12px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f8fda, #74b4f3);
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 10px 24px rgba(79, 143, 218, 0.2);
        }
        
        .btn-danger {
            background: #dc2626;
            box-shadow: 0 10px 22px rgba(220, 38, 38, 0.18);
        }
        
        .btn-light {
            background: linear-gradient(135deg, #eaf4ff, #d8ecff);
            color: #1e3a8a;
            box-shadow: 0 8px 18px rgba(148, 184, 255, 0.18);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        
        th,
        td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        
        th {
            background: linear-gradient(90deg, #eff6ff, #dbeafe);
            color: #24508e;
            font-size: 13px;
        }
        
        .role-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .role-admin {
            background: #dbeafe;
            color: #1d4ed8;
        }
        
        .role-ogretmen {
            background: #dcfce7;
            color: #166534;
        }
        
        .role-ogrenci {
            background: #fef3c7;
            color: #92400e;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        
        .muted {
            color: var(--ink-soft);
        }
        
        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Kullanicilar</div>
    <div class="container">
        <div class="hero">
            <h1>Kullanici Yonetimi</h1>
            <p>Ogrenci, ogretmen ve admin hesaplarini bu ekrandan kolayca yonetebilirsin.</p>
        </div>
        <div class="layout">
            <div class="panel">
                <h2>Yeni Kullanici Ekle</h2>
                <form method="POST" action="/kullanici-ekle">
                    @csrf
                    <div class="field">
                        <label>Ad Soyad</label>
                        <input type="text" name="ad" placeholder="Ad soyad" required>
                    </div>
                    <div class="field">
                        <label>E-posta</label>
                        <input type="email" name="email" placeholder="ornek@mail.com" required>
                    </div>
                    <div class="field">
                        <label>Sifre</label>
                        <input type="text" name="sifre" placeholder="Sifre" required>
                    </div>
                    <div class="field">
                        <label>Rol</label>
                        <select name="rol">
                            <option value="ogrenci">Ogrenci</option>
                            <option value="ogretmen">Ogretmen</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Kullanici Ekle</button>
                </form>
                <div class="actions">
                    <a href="/admin" class="btn btn-light">Admin Panele Don</a>
                </div>
            </div>
            <div class="panel">
                <h2>Kullanici Listesi</h2>
                <p class="muted">Toplam {{ $kullanicilar->count() }} kullanici listeleniyor.</p>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Ad</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Islem</th>
                    </tr>
                    @foreach($kullanicilar as $k)
                    <tr>
                        <td>{{ $k->id }}</td>
                        <td>{{ $k->name }}</td>
                        <td>{{ $k->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $k->rol }}">{{ ucfirst($k->rol) }}</span>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="/kullanici-sil/{{ $k->id }}" onclick="return confirm('Silmek istedigine emin misin?')">Sil</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>
</html>
