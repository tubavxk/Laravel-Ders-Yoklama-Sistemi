<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogrenci Profili</title>
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
        .content { padding: 10px 20px 44px 4px; min-width: 0; }
        .container { max-width: none; margin: 0 auto; padding: 0; }
        .hero, .panel, .card { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 12px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .badge { display: inline-flex; padding: 6px 11px; border-radius: 999px; background: #e8fbfa; color: #2d9cdb; font-size: 12px; font-weight: 700; }
        .hero h1 { margin: 12px 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .hero-profile { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 14px; margin-top: 18px; }
        .hero-profile-item { background: linear-gradient(180deg, #fff, #f5fbff); border: 1px solid rgba(143,189,232,.18); border-radius: 18px; padding: 14px 16px; }
        .hero-profile-label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #2d6175; margin-bottom: 6px; }
        .hero-profile-value { font-size: 16px; font-weight: 700; color: #1f5668; word-break: break-word; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 24px; }
        .card, .panel { padding: 22px; }
        .card h3, .panel h3, .panel h2 { margin-top: 0; margin-bottom: 12px; color: #2d9cdb; }
        .stat { font-size: 36px; font-weight: 700; margin: 6px 0 10px; color: #1f5668; }
        .muted { color: #6f8594; }
        .profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; }
        .field { background: linear-gradient(180deg, #fff, #f5fbff); border: 1px solid rgba(143,189,232,.18); border-radius: 18px; padding: 14px 16px; }
        .field .label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #2d6175; margin-bottom: 6px; }
        .field .value { font-size: 16px; font-weight: 700; color: #1f5668; word-break: break-word; }
        .mini-list { display: grid; gap: 12px; }
        .mini-item { padding: 14px; border-radius: 14px; background: #f8fafc; border: 1px solid #dbeafe; }
        .lesson-meta { font-size: 13px; line-height: 1.5; word-break: break-word; }
        .empty { padding: 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; color: #475569; }
        .today-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 12px; }
        .btn { display: inline-block; margin-top: 16px; padding: 10px 16px; background: linear-gradient(135deg, #2d9cdb, #2dd4bf); color: #fff; text-decoration: none; border-radius: 12px; border: none; font-weight: 700; }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
            .hero-profile, .profile-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">Ogrenci Paneli</div>
    <div class="layout-shell">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width:100%;max-width:190px;height:auto;display:block;margin:0 auto;">
                </div>
                <nav class="sidebar-nav">
                    <a href="/ogrenci" class="sidebar-link"><div><span>Ana Sayfa</span><br><small>Ogrenci paneli</small></div><span>></span></a>
                    <a href="/ogrenci-program.blade.php" class="sidebar-link"><div><span>Ders Programi</span><br><small>Haftalik program</small></div><span>></span></a>
                    <a href="/ogrenci-grafikler.blade.php" class="sidebar-link"><div><span>Grafikler</span><br><small>Katilim ve devamsizlik</small></div><span>></span></a>
                    <a href="/ogrenci-qr-kamera.blade.php" class="sidebar-link"><div><span>QR Kamera</span><br><small>Yoklama okut</small></div><span>></span></a>
                    <a href="/ogrenci-profil.blade.php" class="sidebar-link active"><div><span>Ogrenci Profili</span><br><small>Kisisel bilgiler</small></div><span>></span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cikis</span><br><small>Oturumu sonlandir</small></div><span>></span></a>
                </nav>
            </div>
        </aside>
        <main class="content">
            <div class="container">
                <div class="hero">
                    <div class="badge">Profil</div>
                    <h1>{{ $ogrenci->name }}</h1>
                    <p>Burada sadece ogrenciye ait bilgiler yer alir. Aynı panel duzeni korunarak profil ozeti gostirilir.</p>
                </div>

                <div class="grid">
                    <div class="card"><h3>Toplam Ders</h3><div class="stat">{{ $ogrenciDersSayisi }}</div><p class="muted">Sana tanimli ders sayisi</p></div>
                    <div class="card"><h3>Toplam Yoklama</h3><div class="stat">{{ $toplamYoklama }}</div><p class="muted">Kayitli yoklama sayin</p></div>
                    <div class="card"><h3>Devamsiz Yoklama</h3><div class="stat">{{ $devamsizYoklama }}</div><p class="muted">Yok yazildigin toplam ders</p></div>
                    <div class="card"><h3>Durum</h3><div class="stat">{{ $devamsizYoklama > 0 ? 'Takip' : 'Iyi' }}</div><p class="muted">Genel profil durumu</p></div>
                </div>

                <div class="panel">
                    <h3>Ogrenci Bilgileri</h3>
                    <div class="profile-grid">
                        <div class="field">
                            <div class="label">Okul Mail</div>
                            <div class="value">{{ $ogrenci->email }}</div>
                        </div>
                        <div class="field">
                            <div class="label">Ad Soyad</div>
                            <div class="value">{{ $ogrenci->name }}</div>
                        </div>
                        <div class="field">
                            <div class="label">Rol</div>
                            <div class="value">{{ ucfirst($ogrenci->rol) }}</div>
                        </div>
                        <div class="field">
                            <div class="label">Not</div>
                            <div class="value">Bilgiler mevcut kayittan okunuyor</div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3>Aldığın Dersler</h3>
                    @if($dersler->count() > 0)
                        <div class="today-grid">
                            @foreach($dersler as $ders)
                                <div class="mini-item">
                                    <div class="lesson-time">{{ $ders->saat }}</div>
                                    <strong>{{ $ders->ders_adi }}</strong>
                                    <div class="lesson-meta muted">{{ $ders->ders_kodu }}</div>
                                    <div class="lesson-meta muted">{{ $ders->ogretmen_adi ?? 'Ogretmen bekleniyor' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty">Henüz kayıtlı dersin bulunmuyor.</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
