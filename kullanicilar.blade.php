<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanicilar</title>
    <style>
        :root {
            --sea-50: #f6fbff;
            --sea-100: #eef7ff;
            --sea-200: #dcefff;
            --sea-300: #c5e0ff;
            --sea-500: #8cbfe6;
            --sea-700: #4f84b8;
            --ink: #20324a;
            --ink-soft: #6d7f95;
            --shell: rgba(255, 255, 255, 0.88);
        }

        * {
            box-sizing: border-box;
            font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 12% 10%, rgba(220, 239, 255, 0.75), transparent 24%),
                radial-gradient(circle at 88% 14%, rgba(245, 225, 255, 0.55), transparent 18%),
                linear-gradient(135deg, #ffffff 0%, #f7fbff 42%, #edf6ff 100%);
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                linear-gradient(115deg, rgba(255, 255, 255, 0.72) 0%, rgba(255, 255, 255, 0) 38%),
                repeating-linear-gradient(90deg, rgba(143, 189, 232, 0.08) 0 1px, transparent 1px 120px);
            pointer-events: none;
            z-index: 0;
        }

        .navbar {
            position: relative;
            z-index: 1;
            background: linear-gradient(90deg, #5f95dd 0%, #6aa0e6 55%, #74aaf0 100%);
            color: #ffffff;
            padding: 20px 32px;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            box-shadow: 0 18px 38px rgba(79, 143, 218, 0.20);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }

        .layout {
            position: relative;
            z-index: 1;
            width: 100%;
            margin: 0;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            min-height: calc(100vh - 68px);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: calc(100vh - 68px);
            padding: 16px 14px 18px;
            background: transparent;
            backdrop-filter: blur(16px);
            display: flex;
            justify-content: center;
            align-items: stretch;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 14%, rgba(255, 255, 255, 0.7), transparent 22%),
                radial-gradient(circle at 82% 8%, rgba(214, 232, 255, 0.7), transparent 20%),
                linear-gradient(135deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0));
            pointer-events: none;
        }

        .sidebar::after {
            content: "";
            position: absolute;
            left: -80px;
            bottom: -80px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(143, 189, 232, 0.18);
            filter: blur(12px);
            pointer-events: none;
        }

        .sidebar-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
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

        .sidebar-title {
            display: none;
        }

        .sidebar-brand {
            position: relative;
            z-index: 1;
            padding: 18px 12px 12px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(237, 246, 255, 0.98));
            border: 1px solid rgba(143, 189, 232, 0.18);
            text-align: center;
            margin-bottom: 0;
        }

        .sidebar-nav {
            position: relative;
            z-index: 1;
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
            box-shadow: none;
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
            border: 1px solid transparent;
            box-shadow: 0 16px 30px rgba(127, 186, 240, 0.18);
        }

        .sidebar-link.logout small {
            color: rgba(255, 255, 255, 0.84);
        }

        .main-content {
            min-width: 0;
            padding: 10px 20px 44px 4px;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: none;
            margin: 0 auto;
        }

        .page-hero {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 24px 28px;
            border-radius: 26px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 250, 255, 0.98) 58%, rgba(226, 241, 255, 0.96) 100%);
            border: 1px solid rgba(143, 189, 232, 0.20);
            box-shadow: 0 18px 42px rgba(99, 169, 230, 0.08);
            margin-bottom: 18px;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .page-hero::after {
            content: "";
            position: absolute;
            inset: auto -40px -40px auto;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 169, 230, 0.12), transparent 68%);
            pointer-events: none;
        }

        .page-hero-content {
            position: relative;
            z-index: 1;
        }

        .page-hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(227, 243, 255, 0.94);
            color: #2f74ba;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .page-hero-title {
            margin: 0;
            font-size: 42px;
            letter-spacing: -0.04em;
            line-height: 1.05;
            color: #173152;
        }

        .page-hero-subtitle {
            margin: 10px 0 0;
            color: #58708b;
            font-size: 17px;
            line-height: 1.6;
            max-width: 860px;
        }

        .layout-content {
            display: grid;
            grid-template-columns: 380px minmax(0, 1fr);
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

        .field input,
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

        .role-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
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
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 1100px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
                min-height: 0;
            }

            .main-content {
                padding: 0 12px 28px;
            }

            .layout-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .navbar {
                padding: 16px 18px;
                font-size: 18px;
            }

            .page-hero {
                padding: 18px 20px;
            }

            .page-hero-title {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Kullanıcılar</div>
    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-title">Admin Menü</div>
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width: 100%; max-width: 190px; height: auto; display: block; margin: 0 auto;">
                </div>

                <nav class="sidebar-nav">
                    <a href="/admin" class="sidebar-link">
                        <div>
                            <span>Ana Sayfa</span><br>
                            <small>İlk panel ekranına dön</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/kullanicilar" class="sidebar-link">
                        <div>
                            <span>Kullanıcılar</span><br>
                            <small>Hesapları gör ve yönet</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/dersler" class="sidebar-link">
                        <div>
                            <span>Ders Yönetimi</span><br>
                            <small>Dersleri düzenle</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/ders-atama" class="sidebar-link">
                        <div>
                            <span>Ders Atama</span><br>
                            <small>Öğrenci ve öğretmen bağla</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/logout" class="sidebar-link logout">
                        <div>
                            <span>Çıkış</span><br>
                            <small>Oturumu sonlandır</small>
                        </div>
                        <span>›</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="main-content">
            <div class="container">
                <div class="page-hero">
                    <div class="page-hero-content">
                        <div class="page-hero-kicker">Hoşgeldin</div>
                        <h1 class="page-hero-title">Kullanıcılar</h1>
                        <p class="page-hero-subtitle">Öğrenci, öğretmen ve admin hesaplarını bu ekrandan kolayca yönetebilirsin.</p>
                    </div>
                </div>

                <div class="layout-content">
                    <div class="panel">
                        <h2>Yeni Kullanıcı Ekle</h2>
                        <form method="POST" action="/kullanici-ekle">
                            @csrf
                            <div class="field">
                                <label>Ad Soyad</label>
                                <input type="text" name="ad" placeholder="Ad soyad" required>
                            </div>
                            <div class="field">
                                <label>E-posta</label>
                                <input type="email" name="email" placeholder="örnek@mail.com" required>
                            </div>
                            <div class="field">
                                <label>Şifre</label>
                                <input type="text" name="sifre" placeholder="Şifre" required>
                            </div>
                            <div class="field">
                                <label>Rol</label>
                                <select name="rol">
                                    <option value="ogrenci">Ogrenci</option>
                                    <option value="ogretmen">Ogretmen</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn">Kullanıcı Ekle</button>
                        </form>
                        <div class="actions">
                            
                        </div>
                    </div>

                    <div class="panel">
                        <h2>Kullanıcı Listesi</h2>
                        <p class="muted">Toplam {{ $kullanicilar->count() }} kullanıcı listeleniyor.</p>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Işlem</th>
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
                                    <a class="btn btn-danger" href="/kullanici-sil/{{ $k->id }}" onclick="return confirm('Silmek istediğine emin misin?')">Sil</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
