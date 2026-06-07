<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafikler</title>
    <style>
        * { box-sizing: border-box; font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif; }
        body { margin: 0; color: #20324a; background: radial-gradient(circle at top, #effaff 0, #fff 42%, #ffffff 100%); }
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
        .hero, .card, .panel { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 12px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .badge { display: inline-flex; padding: 6px 11px; border-radius: 999px; background: #e8fbfa; color: #2d9cdb; font-size: 12px; font-weight: 700; }
        .hero h1 { margin: 12px 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 24px; }
        .card { padding: 22px; position: relative; overflow: hidden; }
        .card h3 { margin: 0 0 10px; color: #2d9cdb; }
        .stat { font-size: 36px; font-weight: 700; margin: 6px 0 10px; color: #1f5668; }
        .muted { color: #6f8594; }
        .chart-panel { padding: 22px; margin-bottom: 18px; }
        .section-title { margin: 0 0 14px; color: #173152; font-size: 22px; }
        .chart-list { display: grid; gap: 14px; }
        .chart-row { background: linear-gradient(180deg, #ffffff, #f8fbff); border: 1px solid rgba(143,189,232,.2); border-radius: 20px; padding: 14px 16px 16px; box-shadow: 0 12px 24px rgba(59,130,246,.06); }
        .chart-head { display:flex; justify-content:space-between; gap:12px; align-items:center; margin-bottom:10px; }
        .chart-name { font-weight: 700; color: #173152; }
        .chart-meta { color:#64748b; font-size:13px; }
        .bar-track { height: 16px; border-radius: 999px; background: #dbe4ea; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 999px; display:flex; align-items:center; justify-content:flex-end; padding-right: 10px; color:#fff; font-weight:800; font-size:12px; animation: grow 1.1s ease-out both; }
        .bar-fill.blue { background: linear-gradient(90deg, #2563eb, #38bdf8); }
        .bar-fill.green { background: linear-gradient(90deg, #16a34a, #2dd4bf); }
        .bar-fill.orange { background: linear-gradient(90deg, #f59e0b, #fb7185); }
        .live-pulse { display:inline-block; width:10px; height:10px; border-radius:50%; background:#22c55e; box-shadow:0 0 0 0 rgba(34,197,94,.7); animation:pulse 1.5s infinite; margin-right:8px; }
        .mini-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:18px; margin-bottom: 18px; }
        .info-box { padding: 20px; }
        .info-box h3 { margin-top:0; color:#2d9cdb; }
        .info-value { font-size: 34px; font-weight: 800; color:#1f5668; }
        .empty { padding: 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; color: #475569; }
        @keyframes grow { from { width: 0; } }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(34,197,94,.7); } 70% { box-shadow: 0 0 0 12px rgba(34,197,94,0); } 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); } }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
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
                    <a href="/ogrenci-grafikler.blade.php" class="sidebar-link active"><div><span>Grafikler</span><br><small>Katilim ve devamsizlik</small></div><span>></span></a>
                    <a href="/ogrenci-qr-kamera.blade.php" class="sidebar-link"><div><span>QR Kamera</span><br><small>Yoklama okut</small></div><span>></span></a>
                    <a href="/ogrenci-profil.blade.php" class="sidebar-link"><div><span>Ogrenci Profili</span><br><small>Kisisel bilgiler</small></div><span>></span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cikis</span><br><small>Oturumu sonlandir</small></div><span>></span></a>
                </nav>
            </div>
        </aside>
        <main class="content">
            <div class="container">
                <div class="hero">
                    <div class="badge"><span class="live-pulse"></span>Canli Grafikler</div>
                    <h1>Katilim ve Devamsizlik</h1>
                    <p>Renkli barlar, ders bazli risk kartlari ve durum ozeti tek ekranda.</p>
                </div>

                <div class="grid">
                    <div class="card"><h3>Toplam Ders</h3><div class="stat">{{ $dersler->count() }}</div><p class="muted">Aktif ders sayın</p></div>
                    <div class="card"><h3>Toplam Devamsizlik</h3><div class="stat">{{ $genelDevamsizlik }}</div><p class="muted">Toplam yok yazılma sayın</p></div>
                    <div class="card"><h3>Devamsizlik Yuzdesi</h3><div class="stat">%{{ $genelDevamsizlikYuzdesi }}</div><p class="muted">Genel devamsızlık oranı</p></div>
                    <div class="card"><h3>Aktif Dersler</h3><div class="stat">{{ $dersler->count() }}</div><p class="muted">Grafiklerde izlenen dersler</p></div>
                </div>

                <div class="mini-grid">
                    <div class="card info-box">
                        <h3>En Riskli Dersler</h3>
                        <div class="muted" style="margin-bottom:10px;">Devamsızlığı en yüksek olan dersler</div>
                        @if($enCokDevamsizlikYapanDersler->count() > 0)
                            <div class="chart-list">
                                @foreach($enCokDevamsizlikYapanDersler as $ders)
                                    @php $risk = $ders->toplam_yoklama > 0 ? min(round(($ders->devamsizlik / $ders->toplam_yoklama) * 100), 100) : 0; @endphp
                                    <div class="chart-row">
                                        <div class="chart-head">
                                            <div>
                                                <div class="chart-name">{{ $ders->ders_adi }}</div>
                                                <div class="chart-meta">{{ $ders->ders_kodu }} · {{ $ders->devamsizlik }} devamsızlık</div>
                                            </div>
                                            <div class="info-value">%{{ $risk }}</div>
                                        </div>
                                        <div class="bar-track">
                                            <div class="bar-fill orange" style="width: {{ $risk }}%;">%{{ $risk }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty">Henüz veri bulunmuyor.</div>
                        @endif
                    </div>

                    <div class="card info-box">
                        <h3>En Yüksek Katılım</h3>
                        <div class="muted" style="margin-bottom:10px;">Katılım oranı en iyi dersler</div>
                        @if($enYuksekKatilimDersler->count() > 0)
                            <div class="chart-list">
                                @foreach($enYuksekKatilimDersler as $ders)
                                    @php $katilim = $ders->toplam_yoklama > 0 ? min(round((($ders->toplam_yoklama - $ders->devamsizlik) / $ders->toplam_yoklama) * 100), 100) : 0; @endphp
                                    <div class="chart-row">
                                        <div class="chart-head">
                                            <div>
                                                <div class="chart-name">{{ $ders->ders_adi }}</div>
                                                <div class="chart-meta">{{ $ders->ders_kodu }} · {{ $ders->toplam_yoklama }} yoklama</div>
                                            </div>
                                            <div class="info-value">%{{ $katilim }}</div>
                                        </div>
                                        <div class="bar-track">
                                            <div class="bar-fill green" style="width: {{ $katilim }}%;">%{{ $katilim }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty">Henüz veri bulunmuyor.</div>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
