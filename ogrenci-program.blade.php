<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ders Programi</title>
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
        .hero, .panel { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 12px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .badge { display: inline-flex; padding: 6px 11px; border-radius: 999px; background: #e8fbfa; color: #2d9cdb; font-size: 12px; font-weight: 700; }
        .hero h1 { margin: 12px 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-top: 18px; }
        .summary-card { padding: 16px 18px; border-radius: 18px; color: #fff; box-shadow: 0 16px 32px rgba(37,99,235,.16); }
        .summary-card.blue { background: linear-gradient(135deg, #2563eb, #38bdf8); }
        .summary-card.teal { background: linear-gradient(135deg, #0f766e, #2dd4bf); }
        .summary-card.orange { background: linear-gradient(135deg, #f59e0b, #fb7185); }
        .summary-card .label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; opacity: .9; }
        .summary-card .value { font-size: 30px; font-weight: 800; margin-top: 6px; }
        .panel { padding: 22px; }
        .schedule-board { overflow-x: auto; padding-bottom: 8px; }
        .schedule-grid { display: grid; grid-template-columns: repeat(5, minmax(190px, 1fr)); gap: 14px; min-width: 1030px; }
        .day-column { background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%); border: 1px solid rgba(143,189,232,.18); border-radius: 18px; padding: 14px; min-height: 280px; position: relative; overflow: hidden; }
        .day-column:before { content: ""; position: absolute; inset: 0 auto auto 0; width: 100%; height: 6px; background: linear-gradient(90deg, #2d9cdb, #5ec8ff, #2dd4bf); }
        .day-column h4 { margin: 10px 0 8px; color: #173152; font-size: 17px; }
        .day-subtitle { margin: -4px 0 12px; color: #64748b; font-size: 12px; }
        .lesson-chip { background: linear-gradient(180deg, #fff, #f3f9ff); border: 1px solid #dbeafe; border-radius: 14px; padding: 12px; margin-bottom: 10px; box-shadow: 0 8px 18px rgba(59,130,246,.08); position: relative; overflow: hidden; }
        .lesson-chip:after { content: ""; position: absolute; right: -18px; top: -18px; width: 60px; height: 60px; border-radius: 50%; background: radial-gradient(circle, rgba(45,156,219,.18), rgba(45,156,219,0)); }
        .lesson-chip strong { display: block; margin-bottom: 6px; color: #0f172a; line-height: 1.45; word-break: break-word; }
        .lesson-time { display: inline-block; padding: 5px 9px; border-radius: 999px; background: #dbeafe; color: #1d4ed8; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .lesson-meta { font-size: 13px; line-height: 1.5; word-break: break-word; }
        .empty { padding: 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; color: #475569; }
        .program-wrap { display:grid; grid-template-columns: 1.6fr 1fr; gap: 18px; }
        .mini-summary { display:grid; gap:12px; }
        .mini-summary .mini-card { padding: 16px; border-radius: 18px; background: linear-gradient(135deg, #eff6ff, #ecfeff); border: 1px solid #cfe8ff; }
        .mini-summary .mini-card strong { display:block; margin-bottom:6px; color:#173152; }
        .chart-list { display:grid; gap:14px; }
        .chart-row { background: linear-gradient(180deg, #ffffff, #f8fbff); border: 1px solid rgba(143,189,232,.2); border-radius: 18px; padding: 14px 16px 16px; box-shadow: 0 12px 24px rgba(59,130,246,.06); }
        .chart-head { display:flex; justify-content:space-between; gap:12px; align-items:center; margin-bottom:10px; }
        .chart-name { font-weight:700; color:#173152; }
        .chart-meta { color:#64748b; font-size:13px; }
        .bar-track { height: 16px; border-radius: 999px; background: #dbe4ea; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 999px; display:flex; align-items:center; justify-content:flex-end; padding-right: 10px; color:#fff; font-weight:800; font-size:12px; animation: grow 1.1s ease-out both; }
        .bar-fill.blue { background: linear-gradient(90deg, #2563eb, #38bdf8); }
        .bar-fill.green { background: linear-gradient(90deg, #16a34a, #2dd4bf); }
        .bar-fill.orange { background: linear-gradient(90deg, #f59e0b, #fb7185); }
        @keyframes grow { from { width: 0; } }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
            .schedule-grid { grid-template-columns: 1fr; }
            .program-wrap { grid-template-columns: 1fr; }
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
                    <a href="/ogrenci-program.blade.php" class="sidebar-link active"><div><span>Ders Programi</span><br><small>Haftalik program</small></div><span>></span></a>
                    <a href="/ogrenci/grafikler" class="sidebar-link"><div><span>Grafikler</span><br><small>Katilim ve devamsizlik</small></div><span>></span></a>
                    <a href="/ogrenci-qr-kamera.blade.php" class="sidebar-link"><div><span>QR Kamera</span><br><small>Yoklama okut</small></div><span>></span></a>
                    <a href="/ogrenci-profil.blade.php" class="sidebar-link"><div><span>Ogrenci Profili</span><br><small>Kisisel bilgiler</small></div><span>></span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cikis</span><br><small>Oturumu sonlandir</small></div><span>></span></a>
                </nav>
            </div>
        </aside>

        <main class="content">
            <div class="container">
                <div class="hero">
                    <div class="badge">Ders Programi</div>
                    <h1>Haftalik Program</h1>
                    <p>Bu sayfada sadece haftalik ders programin gorunur.</p>
                    <div class="summary-grid">
                        <div class="summary-card blue">
                            <div class="label">Toplam Ders</div>
                            <div class="value">{{ $dersler->count() }}</div>
                        </div>
                        <div class="summary-card teal">
                            <div class="label">Bu Hafta Plan</div>
                            <div class="value">{{ $haftalikProgram->flatten(1)->count() }}</div>
                        </div>
                        <div class="summary-card orange">
                            <div class="label">Dolu Gün</div>
                            <div class="value">{{ $haftalikProgram->filter(fn ($derslerGun) => $derslerGun->count() > 0)->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="program-wrap">
                <div class="panel">
                    <div class="schedule-board">
                        <div class="schedule-grid">
                            @foreach($haftalikProgram as $gun => $gunDersleri)
                                <div class="day-column">
                                    <h4>{{ $gun }}</h4>
                                    <div class="day-subtitle">{{ $gunDersleri->count() }} ders</div>
                                    @forelse($gunDersleri as $ders)
                                        <div class="lesson-chip">
                                            <div class="lesson-time">{{ $ders->saat }}</div>
                                            <strong>{{ $ders->ders_adi }}</strong>
                                            <div class="lesson-meta muted">{{ $ders->ders_kodu }}</div>
                                            <div class="lesson-meta muted">{{ $ders->ogretmen_adi ?? 'Ogretmen bekleniyor' }}</div>
                                        </div>
                                    @empty
                                        <div class="empty">Bu gun icin ders yok.</div>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="panel" style="margin-top:20px;">
                    <h3>Ders Bazlı Çubuklar</h3>
                    @if($dersler->count() > 0)
                        <div class="chart-list">
                            @foreach($dersler as $ders)
                                @php
                                    $katilim = $ders->toplam_yoklama > 0 ? min(round((($ders->toplam_yoklama - $ders->devamsizlik) / $ders->toplam_yoklama) * 100), 100) : 0;
                                    $devamsiz = $ders->toplam_yoklama > 0 ? min(round(($ders->devamsizlik / $ders->toplam_yoklama) * 100), 100) : 0;
                                @endphp
                                <div class="chart-row">
                                    <div class="chart-head">
                                        <div>
                                            <div class="chart-name">{{ $ders->ders_adi }}</div>
                                            <div class="chart-meta">{{ $ders->ders_kodu }} · {{ $ders->gun }} · {{ $ders->saat }}</div>
                                        </div>
                                        <div class="chart-meta">{{ $ders->ogretmen_adi ?? 'Ogretmen bekleniyor' }}</div>
                                    </div>
                                    <div class="bar-track" style="margin-bottom:8px;">
                                        <div class="bar-fill blue" style="width: {{ $katilim }}%;">Katılım %{{ $katilim }}</div>
                                    </div>
                                    <div class="bar-track">
                                        <div class="bar-fill orange" style="width: {{ $devamsiz }}%;">Devamsızlık %{{ $devamsiz }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty">Henüz kayıtlı dersin bulunmuyor.</div>
                    @endif
                </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
