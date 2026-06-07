<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilim</title>
    <style>
        * { box-sizing: border-box; font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif; }
        body { margin: 0; color: #20324a; background: #fff; }
        .navbar { background: linear-gradient(90deg, #2d9cdb 0%, #5ec8ff 52%, #2dd4bf 100%); color: #fff; padding: 20px 32px; font-size: 23px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; box-shadow: 0 18px 38px rgba(79,143,218,.2); }
        .layout-shell { display: grid; grid-template-columns: 280px minmax(0,1fr); min-height: calc(100vh - 68px); }
        .sidebar { position: sticky; top: 0; height: calc(100vh - 68px); padding: 16px 14px 18px; display: flex; }
        .sidebar-inner { width: 100%; border-radius: 30px; padding: 18px 16px 16px; background: #fff; border: 1px solid rgba(143,189,232,.24); box-shadow: 0 24px 48px rgba(99,169,230,.12); display: flex; flex-direction: column; gap: 18px; }
        .sidebar-brand { padding: 18px 12px 12px; border-radius: 24px; background: #fff; border: 1px solid rgba(143,189,232,.18); text-align: center; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 12px; margin-top: 2px; height: 100%; }
        .sidebar-link { display: flex; justify-content: space-between; gap: 14px; padding: 16px 18px; border-radius: 18px; text-decoration: none; color: #5f7392; border: 1px solid transparent; transition: .24s; }
        .sidebar-link:hover, .sidebar-link.active { transform: translateX(6px); color: #fff; background: linear-gradient(90deg, #2d9cdb 0%, #5ec8ff 52%, #2dd4bf 100%); box-shadow: 0 14px 28px rgba(99,169,230,.24); }
        .sidebar-link span { font-weight: 700; }
        .sidebar-link small { color: #7c90aa; font-size: 12px; }
        .sidebar-link:hover small, .sidebar-link:hover span, .sidebar-link.active small, .sidebar-link.active span { color: #fff; }
        .sidebar-link.logout { margin-top: auto; background: linear-gradient(135deg, #2d9cdb, #2dd4bf); color: #fff; box-shadow: 0 16px 30px rgba(127,186,240,.18); }
        .sidebar-link.logout small, .sidebar-link.logout span { color: rgba(255,255,255,.9); }
        .content { min-width: 0; padding: 10px 20px 44px 4px; }
        .container { max-width: none; margin: 0 auto; padding: 0; }
        .hero, .panel, .profile-card { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 12px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .badge { display: inline-flex; padding: 6px 11px; border-radius: 999px; background: #e8fbfa; color: #2d9cdb; font-size: 12px; font-weight: 700; }
        .hero h1 { margin: 12px 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .panel { padding: 22px; }
        .panel h2 { margin: 0 0 14px; color: #24508e; }
        .profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; }
        .profile-card { padding: 18px; position: relative; overflow: hidden; }
        .profile-card:before { content: ""; position: absolute; left: 0; top: 0; right: 0; height: 6px; background: linear-gradient(90deg, #2d9cdb, #5ec8ff, #2dd4bf); }
        .profile-card .label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #2d6175; margin-bottom: 8px; }
        .profile-card .value { font-size: 20px; font-weight: 700; color: #1f5668; word-break: break-word; }
        .profile-card .handwritten { font-family: "Segoe Script", "Brush Script MT", cursive; font-size: 22px; color: #24508e; }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
            .profile-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">Ogretmen Paneli</div>
    <div class="layout-shell">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width: 100%; max-width: 190px; height: auto; display: block; margin: 0 auto;">
                </div>
                <nav class="sidebar-nav">
                    <a href="/ogretmen" class="sidebar-link"><div><span>Ana Sayfa</span><br><small>Ogretmen paneli</small></div><span>></span></a>
                    <a href="/ogretmen/derslerim" class="sidebar-link"><div><span>Derslerim</span><br><small>Atanmis dersleri gor</small></div><span>></span></a>
                    <a href="/ogretmen/yoklama" class="sidebar-link"><div><span>Yoklama Gir</span><br><small>Yoklama ekranina git</small></div><span>></span></a>
                    <a href="/ogretmen/profilim" class="sidebar-link active"><div><span>Profilim</span><br><small>Kisisel bilgilerin</small></div><span>></span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cikis</span><br><small>Oturumu sonlandir</small></div><span>></span></a>
                </nav>
            </div>
        </aside>
        <main class="content">
            <div class="container">
                <div class="hero">
                    <span class="badge">Profilim</span>
                    <h1>{{ $ogretmen->name }}</h1>
                    <p>Hoca bilgileri tek sayfada. Okul maili, unvan ve akademik durum gibi temel bilgileri burada gorursun.</p>
                </div>

                <div class="panel">
                    <h2>Hoca Bilgileri</h2>
                    <div class="profile-grid">
                        <div class="profile-card"><div class="label">Ad Soyad</div><div class="value">{{ $ogretmen->name }}</div></div>
                        <div class="profile-card"><div class="label">Okul Maili</div><div class="value">{{ $ogretmen->email }}</div></div>
                        <div class="profile-card"><div class="label">Unvan</div><div class="value handwritten">....................</div></div>
                        <div class="profile-card"><div class="label">Calistigi Okul</div><div class="value">....................</div></div>
                        <div class="profile-card"><div class="label">Mezun Oldugu Okul</div><div class="value">....................</div></div>
                        <div class="profile-card"><div class="label">Bolum</div><div class="value">....................</div></div>
                        <div class="profile-card"><div class="label">Rol</div><div class="value">{{ ucfirst($ogretmen->rol) }}</div></div>
                        <div class="profile-card"><div class="label">Kullanici ID</div><div class="value">{{ $ogretmen->id }}</div></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
