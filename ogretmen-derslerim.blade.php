<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derslerim</title>
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
        .content { padding: 10px 20px 44px 4px; }
        .container { max-width: none; margin: 0 auto; padding: 0; }
        .hero, .panel, .stat-card, .course-card { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 12px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .hero h1 { margin: 0 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .schedule-panel { position: relative; overflow: hidden; padding: 26px 28px 22px; margin-bottom: 20px; min-height: 280px; background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%); }
        .schedule-panel:before { content: ""; position: absolute; inset: 0 auto 0 0; width: 14px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .schedule-header { display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; margin-bottom: 18px; }
        .schedule-header h2 { margin: 0; font-size: 24px; color: #24508e; }
        .schedule-header p { margin: 6px 0 0; color: #58708b; line-height: 1.6; }
        .schedule-chip { display: inline-flex; padding: 8px 12px; border-radius: 999px; background: #e8fbfa; color: #2d9cdb; font-weight: 700; font-size: 12px; letter-spacing: .06em; text-transform: uppercase; }
        .schedule-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; }
        .schedule-day { padding: 16px; border-radius: 20px; background: linear-gradient(180deg, #ffffff 0%, #f3f9ff 100%); border: 1px solid rgba(143,189,232,.18); min-height: 170px; }
        .schedule-day h3 { margin: 0 0 10px; font-size: 16px; color: #173152; }
        .schedule-day .course { padding: 10px 12px; border-radius: 14px; background: #fff; border: 1px solid #dceaf6; margin-bottom: 10px; }
        .schedule-day .course:last-child { margin-bottom: 0; }
        .schedule-day .course strong { display: block; margin-bottom: 4px; color: #24508e; }
        .schedule-day .course span { display: block; color: #6b8288; font-size: 13px; line-height: 1.4; }
        .stat-grid { display: none; }
        .panel { padding: 24px; }
        .panel h2 { margin: 0 0 12px; color: #24508e; }
        .course-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px; }
        .course-card { position: relative; overflow: hidden; padding: 18px; border-radius: 20px; background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(245,251,255,.96)); border: 1px solid rgba(94,168,216,.18); box-shadow: 0 14px 28px rgba(22,72,65,.06); }
        .course-card::before { content: ""; position: absolute; left: 0; right: 0; top: 0; height: 6px; background: linear-gradient(90deg, #2d9cdb, #5ec8ff, #2dd4bf); }
        .badge { display: inline-flex; padding: 6px 11px; border-radius: 999px; background: #e8fbfa; color: #2d9cdb; font-size: 12px; font-weight: 700; margin-bottom: 10px; }
        .course-card h4 { margin: 0 0 10px; }
        .course-card p { margin: 0 0 8px; color: #20324a; line-height: 1.5; }
        .muted { color: #6b8288; }
        .empty { padding: 20px; border: 1px dashed rgba(143,189,232,.28); border-radius: 20px; color: #6b8288; background: rgba(255,255,255,.76); }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
            .schedule-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">Öğretmen Paneli</div>
    <div class="layout-shell">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width: 100%; max-width: 190px; height: auto; display: block; margin: 0 auto;">
                </div>
                <nav class="sidebar-nav">
                    <a href="/ogretmen" class="sidebar-link"><div><span>Ana Sayfa</span><br><small>Öğretmen paneli</small></div><span>></span></a>
                    <a href="/ogretmen/grafikler" class="sidebar-link active"><div><span>Grafikler</span><br><small>Detaylı özetler</small></div><span>></span></a>
                    <a href="/ogretmen/derslerim" class="sidebar-link"><div><span>Derslerim</span><br><small>Atanmış dersleri gör</small></div><span>></span></a>
                    <a href="/ogretmen/yoklama" class="sidebar-link"><div><span>Yoklama Gir</span><br><small>Yoklama ekranına git</small></div><span>></span></a>
                    <a href="/ogretmen/profilim" class="sidebar-link"><div><span>Profilim</span><br><small>Kişisel bilgilerin</small></div><span>></span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cıkış</span><br><small>Oturumu sonlandır</small></div><span>></span></a>
                </nav>
            </div>
        </aside>
        <main class="content">
            <div class="container">
                <div class="hero">
                    <h1>Derslerim</h1>
                    <p>Atanmış derslerini tek yerde görebilir, ders bazlı özetleri inceleyebilirsin.</p>
                </div>

                <div class="panel schedule-panel">
                    <div class="schedule-header">
                        <div>
                            <span class="schedule-chip">Ders Programı</span>
                            <h2>Haftalık Program</h2>
                            <p>Derslerinin gün ve saat bilgileri burada büyük bir program kutusunda görünür. Bu alan, okul için hızlı bakış ekranı gibi calışır.</p>
                        </div>
                    </div>
                    <div class="schedule-grid">
                        @php
                            $gunSirasi = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma'];
                            $normalizeGun = function ($metin) {
                                $metin = trim((string) $metin);
                                $metin = str_replace(
                                    ['Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü'],
                                    ['C', 'c', 'G', 'g', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u'],
                                    $metin
                                );
                                return strtolower($metin);
                            };
                        @endphp
                        @foreach($gunSirasi as $gun)
                            @php
                                $gunDersleri = $dersler->filter(fn ($ders) => $normalizeGun($ders->gun) === $normalizeGun($gun))->sortBy('saat');
                            @endphp
                            @if($gunDersleri->count() > 0)
                                <div class="schedule-day">
                                    <h3>{{ $gun }}</h3>
                                    @foreach($gunDersleri as $ders)
                                        <div class="course">
                                            <strong>{{ $ders->ders_adi }}</strong>
                                            <span>{{ $ders->ders_kodu }}</span>
                                            <span>{{ $ders->saat }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="panel">
                    <h2>Atanmış Dersler</h2>
                    @if($dersler->count() > 0)
                        <div class="course-grid">
                            @foreach($dersler as $ders)
                                <div class="course-card">
                                    <div class="badge">{{ $ders->ders_kodu }}</div>
                                    <h4>{{ $ders->ders_adi }}</h4>
                                    <p><strong>Gün:</strong> {{ $ders->gun }}</p>
                                    <p><strong>Saat:</strong> {{ $ders->saat }}</p>
                                    <p><strong>Toplam Ogrenci:</strong> {{ $ders->ogrenci_sayisi }}</p>
                                    <p><strong>Toplam Ders Sayisi:</strong> {{ $ders->toplam_ders_sayisi }}</p>
                                    <p><strong>Gelmeyen Öğrenci:</strong> {{ $ders->devamsiz_ogrenci_sayisi }}</p>
                                    <p class="muted"><strong>Kalan Öğrenci:</strong> {{ $ders->kalan_ogrenci_sayisi }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty">Sana henüz ders atanmamış. Admin panelinden ders atandığında burada görünecek.</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
