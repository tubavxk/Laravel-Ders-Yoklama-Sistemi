<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogrenci Paneli</title>
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
        .sidebar-link.skip { margin-top: 6px; }
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
        .alert { margin-top: 18px; padding: 14px 16px; border-radius: 16px; font-weight: 700; }
        .page-alert { margin-bottom: 18px; padding: 14px 16px; border-radius: 16px; font-weight: 700; }
        .page-alert.success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .page-alert.error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert.warn { background: #fff7ed; color: #b45309; border: 1px solid #fdba74; }
        .alert.danger { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert.ok { background: #ecfdf5; color: #047857; border: 1px solid #86efac; }
        .muted { color: #6f8594; }
        .schedule-board { overflow-x: auto; padding-bottom: 8px; margin-top: 14px; }
        .schedule-grid { display: grid; grid-template-columns: repeat(5, minmax(190px, 1fr)); gap: 14px; min-width: 1030px; }
        .day-column { background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%); border: 1px solid rgba(143,189,232,.18); border-radius: 18px; padding: 14px; min-height: 280px; }
        .day-column h4 { margin: 0 0 12px; color: #173152; font-size: 17px; }
        .day-subtitle { margin: -4px 0 12px; color: #64748b; font-size: 12px; }
        .lesson-chip { background: linear-gradient(180deg, #fff, #f3f9ff); border: 1px solid #dbeafe; border-radius: 14px; padding: 12px; margin-bottom: 10px; box-shadow: 0 8px 18px rgba(59,130,246,.08); }
        .lesson-chip strong { display: block; margin-bottom: 6px; color: #0f172a; line-height: 1.45; word-break: break-word; }
        .lesson-time { display: inline-block; padding: 5px 9px; border-radius: 999px; background: #dbeafe; color: #1d4ed8; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .lesson-meta { font-size: 13px; line-height: 1.5; word-break: break-word; }
        .mini-list { display: grid; gap: 12px; }
        .today-strip { margin-bottom: 24px; }
        .today-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 12px; }
        .mini-item { padding: 14px; border-radius: 14px; background: #f8fafc; border: 1px solid #dbeafe; }
        .empty { padding: 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; color: #475569; }
        .section-title { margin: 0 0 12px; color: #173152; font-size: 20px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px; margin: 18px 0 24px; }
        .info-card { padding: 22px; }
        .info-card h3 { margin-top: 0; margin-bottom: 12px; color: #2d9cdb; }
        .badge-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
        .badge-pill { padding: 10px 14px; border-radius: 999px; background: #f0fdfa; border: 1px solid #a7f3d0; color: #065f46; font-weight: 700; }
        .goal-box { padding: 18px; border-radius: 18px; background: linear-gradient(180deg, #f8fbff, #ffffff); border: 1px solid #dbeafe; }
        .progress-bar { width: 100%; height: 14px; border-radius: 999px; overflow: hidden; background: #dbe4ea; margin-top: 12px; }
        .progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #2d9cdb, #2dd4bf); }
        .progress-label { margin-top: 10px; font-weight: 700; color: #1f5668; }
        .progress-track { width: 100%; height: 18px; border-radius: 999px; background: #dbe4ea; overflow: hidden; margin-top: 10px; position: relative; }
        .progress-track-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #2d9cdb, #2dd4bf); display: flex; align-items: center; justify-content: flex-end; padding-right: 10px; color: #fff; font-size: 12px; font-weight: 800; white-space: nowrap; }
        .alert-list { display: grid; gap: 10px; margin-top: 8px; }
        .alert-row { padding: 14px 16px; border-radius: 16px; background: #fff7ed; border: 1px solid #fed7aa; color: #9a3412; font-weight: 700; }
        .alert-row strong { display:block; margin-bottom: 4px; color: #7c2d12; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        th { background: #f0fdfa; color: #115e59; }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
            .hero-profile { grid-template-columns: 1fr; }
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
                    <a href="/ogrenci" class="sidebar-link active"><div><span>Ana Sayfa</span><br><small>Ogrenci paneli</small></div><span>></span></a>
                    <a href="/ogrenci-program.blade.php" class="sidebar-link skip"><div><span>Ders Programi</span><br><small>Haftalik program</small></div><span>></span></a>
                    <a href="/ogrenci-grafikler.blade.php" class="sidebar-link skip"><div><span>Grafikler</span><br><small>Katilim ve devamsizlik</small></div><span>></span></a>
                    <a href="/ogrenci-qr-kamera.blade.php" class="sidebar-link skip"><div><span>QR Kamera</span><br><small>Yoklama okut</small></div><span>></span></a>
                    <a href="/ogrenci-profil.blade.php" class="sidebar-link skip"><div><span>Ogrenci Profili</span><br><small>Kisisel bilgiler</small></div><span>></span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cikis</span><br><small>Oturumu sonlandir</small></div><span>></span></a>
                </nav>
            </div>
        </aside>
        <main class="content">
            <div class="container">
                @if(session('success'))
                    <div class="page-alert success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="page-alert error">{{ session('error') }}</div>
                @endif

                <div class="hero" id="ogrenci-profil">
                    <div class="badge">Akademik Ozet</div>
                    <h1>Hos geldin, {{ $ogrenci->name }}</h1>
                    <p>Ders programini ve bugunun derslerini tek ekranda takip edebilirsin.</p>
                    <div class="hero-profile">
                        <div class="hero-profile-item">
                            <div class="hero-profile-label">Ad Soyad</div>
                            <div class="hero-profile-value">{{ $ogrenci->name }}</div>
                        </div>
                        <div class="hero-profile-item">
                            <div class="hero-profile-label">E-posta</div>
                            <div class="hero-profile-value">{{ $ogrenci->email }}</div>
                        </div>
                        <div class="hero-profile-item">
                            <div class="hero-profile-label">Rol</div>
                            <div class="hero-profile-value">{{ ucfirst($ogrenci->rol) }}</div>
                        </div>
                    </div>
                    <div class="alert {{ $uyariTipi }}">{{ $uyariMesaji }}</div>
                </div>

                <div class="panel today-strip" id="program">
                    <h3>Bugunun Dersleri</h3>
                    @if($bugununDersleri->count() > 0)
                        <div class="today-grid">
                            @foreach($bugununDersleri as $ders)
                                <div class="mini-item">
                                    <div class="lesson-time">{{ $ders->saat }}</div>
                                    <strong>{{ $ders->ders_adi }}</strong>
                                    <div class="lesson-meta muted">{{ $ders->ders_kodu }}</div>
                                    <div class="lesson-meta muted">{{ $ders->ogretmen_adi ?? 'Ogretmen bekleniyor' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty">Bugun icin planlanmis dersin bulunmuyor.</div>
                    @endif
                </div>

                <div class="info-grid">
                    <div class="card info-card">
                        <h3>🔔 Yoklama Uyarıları</h3>
                        <div class="alert-list">
                            <div class="alert-row">
                                <strong>{{ $kritikDers ? $kritikDers->ders_adi : 'Yoklama durumu' }}</strong>
                                @if($kritikDers)
                                    @if($kritikDers->kalan_hak <= 0)
                                        dersi için devamsızlık sınırına ulaştınız.
                                    @elseif($kritikDers->kalan_hak === 1)
                                        dersi için devamsızlık sınırına yaklaştınız.
                                    @else
                                        dersi için şu an güvenli durumdasınız.
                                    @endif
                                @else
                                    Henüz bir ders kaydı bulunamadı.
                                @endif
                            </div>
                            <div class="alert-row">
                                <strong>Haftalık özet</strong>
                                Bu hafta {{ $buHaftaKacirilanDers }} ders kaçırdınız.
                            </div>
                        </div>
                    </div>

                    <div class="card info-card">
                        <h3>🏆 Başarı Rozetleri</h3>
                        <div class="badge-list">
                            @foreach($rozetler as $rozet)
                                <span class="badge-pill">{{ $rozet }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="card info-card">
                        <h3>🎯 Hedef Takibi</h3>
                        <div class="goal-box">
                            <div><strong>Bu dönem hedefiniz %{{ $hedefDevam }} devam.</strong></div>
                            <div style="margin-top:8px;" class="muted">14 ders bazında ilerleme</div>
                            <div class="progress-track" aria-label="Devam oranı">
                                <div class="progress-track-fill" style="width: {{ $ilerlemeOrani }}%;">%{{ $ilerlemeOrani }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3>📝 Son Yoklamalar</h3>
                    <form method="get" action="/ogrenci" style="margin-bottom: 12px;">
                        <label for="ders_id" class="muted" style="display:block; margin-bottom:8px; font-weight:700;">Ders seç</label>
                        <select id="ders_id" name="ders_id" onchange="this.form.submit()" style="width:100%; max-width:420px; padding:12px 14px; border-radius:14px; border:1px solid #cbd5e1; background:#fff; color:#173152; font-weight:700;">
                            <option value="">Tüm dersler</option>
                            @foreach($dersler as $ders)
                                <option value="{{ $ders->ders_id }}" {{ (string) $seciliDersId === (string) $ders->ders_id ? 'selected' : '' }}>
                                    {{ $ders->ders_adi }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    @if($seciliDersAdi)
                        <div class="muted" style="margin-bottom: 10px;">Seçili ders: <strong>{{ $seciliDersAdi }}</strong></div>
                    @endif
                    @if($sonYoklamalar->count() > 0)
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Ders</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sonYoklamalar as $yoklama)
                                        <tr>
                                            <td>{{ $yoklama->tarih }}</td>
                                            <td>{{ $yoklama->ders_adi }}</td>
                                            <td>{{ $yoklama->durum === 'yok' ? '❌ Gelmedi' : '✅ Katıldı' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty">Henüz yoklama kaydın bulunmuyor.</div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</body>
</html>
