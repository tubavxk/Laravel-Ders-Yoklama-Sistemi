<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dersler</title>
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
            font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif;
        }
        
        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(191, 219, 254, 0.36), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef6ff 52%, #e8f3ff 100%);
            color: var(--ink);
        }
        
        .navbar {
            background: linear-gradient(90deg, #5f95dd 0%, #6aa0e6 55%, #74aaf0 100%);
            color: white;
            padding: 20px 32px;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            box-shadow: 0 18px 38px rgba(79, 143, 218, 0.20);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .container {
            max-width: none;
            margin: 0 auto;
            padding: 0;
        }

        .layout-shell {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            min-height: calc(100vh - 68px);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: calc(100vh - 68px);
            padding: 16px 14px 18px;
            display: flex;
        }

        .sidebar-inner {
            width: 100%;
            border-radius: 30px;
            padding: 18px 16px 16px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.99) 0%, rgba(241, 248, 255, 0.98) 52%, rgba(214, 234, 255, 0.98) 100%);
            border: 1px solid rgba(143, 189, 232, 0.24);
            box-shadow: 0 24px 48px rgba(99, 169, 230, 0.12);
            display: flex;
            flex-direction: column;
            gap: 18px;
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 18px 12px 12px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(237, 246, 255, 0.98));
            border: 1px solid rgba(143, 189, 232, 0.18);
            text-align: center;
        }

        .sidebar-nav {
            display: grid;
            gap: 12px;
            margin-top: 2px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 18px;
            border-radius: 18px;
            text-decoration: none;
            color: #5f7392;
            background: transparent;
            border: 1px solid transparent;
            transition:
                transform 0.24s ease,
                box-shadow 0.24s ease,
                border-color 0.24s ease,
                background 0.24s ease;
        }

        .sidebar-link:hover {
            transform: translateX(6px);
            color: #ffffff;
            background: linear-gradient(90deg, #8ac8ff 0%, #63a9e6 52%, #4f8fda 100%);
            box-shadow: 0 14px 28px rgba(99, 169, 230, 0.24);
        }

        .sidebar-link small {
            color: #7c90aa;
            font-size: 12px;
        }

        .sidebar-link span {
            font-weight: 700;
        }

        .sidebar-link.logout {
            margin-top: auto;
            background: linear-gradient(135deg, #9fd7ff, #7fbaf0);
            color: #fff;
            box-shadow: 0 16px 30px rgba(127, 186, 240, 0.18);
        }

        .content {
            padding: 10px 20px 44px 4px;
        }
        
        .hero {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 250, 255, 0.98) 58%, rgba(226, 241, 255, 0.96) 100%);
            color: var(--ink);
            padding: 24px 28px;
            border-radius: 26px;
            margin-bottom: 18px;
            box-shadow: 0 18px 42px rgba(99, 169, 230, 0.08);
            border: 1px solid rgba(143, 189, 232, 0.20);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: auto -40px -40px auto;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 169, 230, 0.12), transparent 68%);
            pointer-events: none;
        }
        
        .hero h1 {
            position: relative;
            z-index: 1;
            margin: 0 0 10px;
            font-size: 42px;
            letter-spacing: -0.04em;
            line-height: 1.05;
        }
        
        .hero p {
            position: relative;
            z-index: 1;
            margin: 0;
            line-height: 1.7;
            color: #58708b;
            font-size: 17px;
            max-width: 860px;
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
            font-size: 22px;
            letter-spacing: -0.02em;
        }
        
        .field {
            margin-bottom: 14px;
        }
        
        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #355070;
            font-size: 14px;
        }
        
        .field input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #c6d9f6;
            background: #f8fbff;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
            font-size: 15px;
            color: var(--ink);
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
            font-weight: 700;
            font-size: 14px;
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
            font-size: 14px;
        }
        
        th,
        td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        th {
            background: linear-gradient(90deg, #eff6ff, #dbeafe);
            color: #24508e;
            font-size: 13px;
            font-weight: 700;
        }
        
        .muted {
            color: var(--ink-soft);
            font-size: 14px;
            line-height: 1.6;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .section-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 20px;
            margin-top: 20px;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 16px;
        }

        .subhead {
            margin: 0 0 6px;
            color: #24508e;
            font-size: 22px;
            letter-spacing: -0.02em;
        }

        .section-note {
            margin: 0 0 12px;
            color: var(--ink-soft);
            line-height: 1.6;
            font-size: 14px;
        }

        .compact-table th,
        .compact-table td {
            padding: 12px 10px;
        }

        .pill-list {
            display: grid;
            gap: 10px;
        }

        .pill-item {
            padding: 12px 14px;
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(232,244,255,.92));
            border: 1px solid rgba(173, 208, 255, 0.7);
            box-shadow: 0 10px 22px rgba(59, 130, 246, 0.06);
        }

        .pill-item strong {
            font-size: 15px;
        }
        
        @media (max-width: 980px) {
            .layout-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                height: auto;
            }

            .layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .navbar {
                padding: 16px 18px;
                font-size: 18px;
                letter-spacing: 0.08em;
            }

            .hero {
                padding: 18px 20px;
            }

            .hero h1 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Dersler</div>
    <div class="layout-shell">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width: 100%; max-width: 190px; height: auto; display: block; margin: 0 auto;">
                </div>
                <nav class="sidebar-nav">
                    <a href="/admin" class="sidebar-link">
                        <div><span>Ana Sayfa</span><br><small>İlk panel ekranına dön</small></div>
                        <span>›</span>
                    </a>
                    <a href="/kullanicilar" class="sidebar-link">
                        <div><span>Kullanıcılar</span><br><small>Hesapları gör ve yönet</small></div>
                        <span>›</span>
                    </a>
                    <a href="/dersler" class="sidebar-link">
                        <div><span>Ders Yönetimi</span><br><small>Dersleri düzenle</small></div>
                        <span>›</span>
                    </a>
                    <a href="/ders-atama" class="sidebar-link">
                        <div><span>Ders Atama</span><br><small>Öğrenci ve öğretmen bağla</small></div>
                        <span>›</span>
                    </a>
                    <a href="/logout" class="sidebar-link logout">
                        <div><span>Çıkış</span><br><small>Oturumu sonlandır</small></div>
                        <span>›</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="content">
            <div class="container">
                <div class="hero">
                    <h1>Ders Yönetimi</h1>
                    <p>Sistemin genel durumunu tek bakışta görebilir, ders ekleme ve program bilgilerini buradan yönetebilirsin.</p>
                </div>

                <div class="layout">
                    <div class="panel">
                        <h2>Yeni Ders Ekle</h2>
                        <form method="POST" action="/ders-ekle">
                            @csrf
                            <div class="field"><label>Ders Adı</label><input type="text" name="ders_adi" placeholder="Matematik" required></div>
                            <div class="field"><label>Ders Kodu</label><input type="text" name="ders_kodu" placeholder="MAT101" required></div>
                            <div class="field"><label>Gün</label><input type="text" name="gun" placeholder="Pazartesi" required></div>
                            <div class="field"><label>Saat</label><input type="text" name="saat" placeholder="09:00" required></div>
                            <button type="submit" class="btn">Ders Ekle</button>
                        </form>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="panel">
                        <h2>Ders Listesi</h2>
                        <p class="muted">Toplam {{ $dersler->count() }} ders listeleniyor.</p>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Ders Adı</th>
                                <th>Kod</th>
                                <th>Gün</th>
                                <th>Saat</th>
                                <th>İşlem</th>
                            </tr>
                            @foreach($dersler as $d)
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td>{{ $d->ders_adi }}</td>
                                <td>{{ $d->ders_kodu }}</td>
                                <td>{{ $d->gun }}</td>
                                <td>{{ $d->saat }}</td>
                                <td><a class="btn btn-danger" href="/ders-sil/{{ $d->id }}" onclick="return confirm('Bu dersi silmek istedigine emin misin?')">Sil</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

        <div class="section-grid">
            <div class="panel">
                <h2 class="subhead">Son Eklenen Dersler</h2>
                <p class="section-note">Sisteme yeni eklenen dersleri burada hızlıca görebilirsin.</p>
                @if($sonEklenenDersler->count() > 0)
                    <div class="table-wrap">
                        <table class="compact-table">
                            <tr>
                                <th>Ders</th>
                                <th>Kod</th>
                                <th>Program</th>
                            </tr>
                            @foreach($sonEklenenDersler as $ders)
                                <tr>
                                    <td>{{ $ders->ders_adi }}</td>
                                    <td>{{ $ders->ders_kodu }}</td>
                                    <td>{{ $ders->gun }} / {{ $ders->saat }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="empty">Henüz ders eklenmemiş.</div>
                @endif
            </div>

            <div class="panel">
                <h2 class="subhead">Dersler İçin  Zaman Çizelgesi</h2>
                <p class="section-note">Bugün ders yönetimi için öne çıkan zaman çizelgesi.</p>
                @if($bugunkuDersProgrami->count() > 0)
                    <div class="pill-list">
                        @foreach($bugunkuDersProgrami as $ders)
                            <div class="pill-item">
                                <strong>{{ $ders->ders_adi }}</strong>
                                <div class="muted">{{ $ders->saat }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty">Bugün için ders bulunamadı.</div>
                @endif
            </div>
        </div>
        </main>
    </div>
</body>
</html>
