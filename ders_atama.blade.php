<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ders Atama</title>
    <style>
        :root {
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
            overflow-x: hidden;
        }

        .navbar {
            position: relative;
            z-index: 1;
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
            align-items: stretch;
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

        .sidebar-link:hover small,
        .sidebar-link:hover span {
            color: #ffffff;
        }

        .sidebar-link span {
            font-weight: 700;
        }

        .sidebar-link small {
            color: #7c90aa;
            font-size: 12px;
        }

        .sidebar-link.logout {
            margin-top: auto;
            background: linear-gradient(135deg, #9fd7ff, #7fbaf0);
            color: #fff;
            box-shadow: 0 16px 30px rgba(127, 186, 240, 0.18);
        }

        .sidebar-link.logout small {
            color: rgba(255, 255, 255, 0.84);
        }

        .content {
            padding: 10px 20px 44px 4px;
            min-width: 0;
        }

        .container {
            max-width: none;
            margin: 0 auto;
            padding: 0;
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
            color: #173152;
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

        .forms-grid,
        .tables-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 22px;
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

        .field select {
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
            vertical-align: top;
        }

        th {
            background: linear-gradient(90deg, #eff6ff, #dbeafe);
            color: #24508e;
            font-size: 13px;
            font-weight: 700;
        }

        .warning-row {
            background: linear-gradient(180deg, rgba(239, 246, 255, 0.96), rgba(219, 234, 254, 0.84));
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

        @media (max-width: 980px) {
            .layout-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                height: auto;
            }

            .content {
                padding: 0 12px 28px;
            }

            .forms-grid,
            .tables-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 30px;
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
        }
    </style>
</head>
<body>
    <div class="navbar">Ders Atama</div>
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
                    <h1>Ders Atama Merkezi</h1>
                    <p>Öğretmen ve öğrencileri derslerle eşleştir, mevcut atamaları takip et ve eksikleri tamamla.</p>
                </div>

                <div class="forms-grid">
                    <div class="panel">
                        <h2>Öğretmene Ders Ata</h2>
                        <form method="POST" action="/ogretmen-ata">
                            @csrf
                            <div class="field">
                                <label>Öğretmen Seç</label>
                                <select name="ogretmen_id" required>
                                    <option value="">Öğretmen seç</option>
                                    @foreach($ogretmenler as $o)
                                        <option value="{{ $o->id }}">{{ $o->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Ders Seç</label>
                                <select name="ders_id" required>
                                    <option value="">Ders seç</option>
                                    @foreach($dersler as $d)
                                        <option value="{{ $d->id }}">{{ $d->ders_adi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn">Atamayı Kaydet</button>
                        </form>
                    </div>

                    <div class="panel">
                        <h2>Öğrenciye Ders Ata</h2>
                        <form method="POST" action="/ogrenciye-ders-ata">
                            @csrf
                            <div class="field">
                                <label>Öğrenci Seç</label>
                                <select name="ogrenci_id" required>
                                    <option value="">Öğrenci seç</option>
                                    @foreach($ogrenciler as $o)
                                        <option value="{{ $o->id }}">{{ $o->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Ders Seç</label>
                                <select name="ders_id" required>
                                    <option value="">Ders seç</option>
                                    @foreach($dersler as $d)
                                        <option value="{{ $d->id }}">{{ $d->ders_adi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn">Atamayı Kaydet</button>
                        </form>
                    </div>
                </div>

                <div class="tables-grid">
                    <div class="panel">
                        <h2>Atanan Öğretmenler</h2>
                        <table>
                            <tr><th>Ders</th><th>Öğretmen</th><th>İşlem</th></tr>
                            @forelse($atananOgretmenler as $a)
                            <tr>
                                <td>{{ $a->ders_adi }}</td>
                                <td>{{ $a->ogretmen_adi }}</td>
                                <td><a class="btn btn-danger" href="/ogretmen-dersten-cikar/{{ $a->ders_id }}" onclick="return confirm('Öğretmeni bu dersten çıkarmak istediğine emin misin?')">Cikar</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="muted">Henüz öğretmen ataması yok.</td></tr>
                            @endforelse
                        </table>
                    </div>

                    <div class="panel">
                        <h2>Atanan Öğrenciler</h2>
                        <table>
                            <tr><th>Öğrenci</th><th>Ders</th><th>İşlem</th></tr>
                            @forelse($atananOgrenciler as $a)
                            <tr>
                                <td>{{ $a->ogrenci_adi }}</td>
                                <td>{{ $a->ders_adi }}</td>
                                <td><a class="btn btn-danger" href="/ogrenci-dersten-cikar/{{ $a->id }}" onclick="return confirm('Öğrenciyi bu dersten çıkarmak istediğine emin misin?')">Cikar</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="muted">Henüz öğrenci ataması yok.</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>

                <div class="panel">
                    <h2>Uyarı Listesi</h2>
                    <table>
                        <tr><th>Tür</th><th>Ad</th><th>Durum</th></tr>
                        @forelse($atanmamisOgretmenler as $o)
                        <tr class="warning-row"><td>Öğretmen</td><td>{{ $o->name }}</td><td>Ders atanmamış, atayın.</td></tr>
                        @empty
                        @endforelse
                        @forelse($atanmamisOgrenciler as $o)
                        <tr class="warning-row"><td>Öğrenci</td><td>{{ $o->name }}</td><td>Ders atanmamış, atayın.</td></tr>
                        @empty
                        @endforelse
                        @if($atanmamisOgretmenler->count() == 0 && $atanmamisOgrenciler->count() == 0)
                        <tr><td colspan="3" class="muted">Atanmamış öğretmen veya öğrenci yok.</td></tr>
                        @endif
                    </table>
                    <div class="actions">

                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
