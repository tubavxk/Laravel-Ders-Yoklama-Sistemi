<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogretmen Grafikler</title>
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
        .hero, .panel, .card { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 12px; background: linear-gradient(180deg, #2d9cdb, #5ec8ff 55%, #2dd4bf); }
        .hero h1 { margin: 0 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .two-col { display: grid; grid-template-columns: 1.2fr .8fr; gap: 20px; margin-top: 22px; }
        .card, .panel { padding: 24px; }
        .section-title { margin: 0 0 8px; font-size: 22px; color: #2d9cdb; }
        .section-sub { margin: 0 0 14px; color: #58708b; line-height: 1.6; }
        .chart-row { display: grid; grid-template-columns: 160px minmax(0,1fr) 86px; gap: 12px; align-items: center; margin-bottom: 12px; }
        .track { height: 14px; border-radius: 999px; background: rgba(143,189,232,.18); overflow: hidden; }
        .fill { height: 100%; border-radius: inherit; background: linear-gradient(90deg, #2d9cdb, #5ec8ff, #2dd4bf); }
        .chart-value { text-align: right; font-weight: 700; color: #2d6175; line-height: 1.2; }
        .week-item { display: grid; grid-template-columns: 72px 1fr 1fr; gap: 10px; align-items: center; padding: 12px 14px; border-radius: 16px; background: linear-gradient(180deg, #fff, #f5fbff); border: 1px solid #e2edf7; margin-bottom: 10px; }
        .week-day { font-weight: 700; color: #2d9cdb; }
        .empty { padding: 18px; border: 1px dashed #c7dced; border-radius: 16px; color: #6f8594; }
        .muted { color: #6f8594; }
        .filter-row { display: grid; grid-template-columns: 1fr auto; gap: 12px; margin-bottom: 16px; }
        .btn { display: inline-block; background: linear-gradient(135deg, #2d9cdb, #2dd4bf); color: #fff; text-decoration: none; padding: 11px 18px; border-radius: 14px; font-weight: 700; border: none; }
        @media (max-width: 980px) {
            .layout-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; }
            .content { padding: 0 12px 28px; }
            .two-col, .filter-row { grid-template-columns: 1fr; }
            .chart-row, .week-item { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">ÖĞRETMEN PANELI</div>
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
                    <h1>Katılım ve Ders Özetleri</h1>
                    <p>Bu sayfa grafik odaklıdır. 7 günlük grafik, son 7 takvim gününde <strong>attendance</strong> tablosundaki <strong>var</strong> kayıtlarının gerçek tarih bazlı dağılımından hesaplanır. Ders sıralaması ise öğrenci sayısına göre listelenir; yaninda o dersin toplam katilim sayisi ve kisa detay bilgisi gosterilir.</p>
                </div>

                <div class="card" style="margin-bottom:18px;">
                    <h3 class="section-title">Derse Göre En Çok Katılanlar</h3>
                    <p class="section-sub">Bir ders seç, o derste öğrenciler arasındakı katılım yüzdelerini ve toplam katılım sayılarını gör.</p>
                    <form method="GET" action="/ogretmen/grafikler" class="filter-row">
                        <select name="ders_id" style="width:100%;padding:12px 14px;border-radius:14px;border:1px solid #d8eaf8;background:#f8fbff;">
                            @foreach($dersler as $ders)
                                <option value="{{ $ders->id }}" @selected((string)$seciliDersId === (string)$ders->id)>
                                    {{ $ders->ders_adi }} ({{ $ders->ders_kodu }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn">Dersi Göster</button>
                    </form>

                    @if($seciliDers)
                        <h4 style="margin:0 0 12px;">{{ $seciliDers->ders_adi }}</h4>
                        @forelse($enCokKatilim as $ogrenci)
                            <div class="week-item" style="grid-template-columns:1fr minmax(0,1fr) 90px;">
                                <div>{{ $ogrenci['ad'] }}</div>
                                <div class="track"><div class="fill" style="width: {{ $ogrenci['oran'] }}%"></div></div>
                                <div class="chart-value">%{{ $ogrenci['oran'] }}<br><small class="muted">{{ $ogrenci['var'] }} var</small></div>
                            </div>
                        @empty
                            <div class="empty">Bu ders için öğrenci kaydı bulunmuyor.</div>
                        @endforelse
                    @else
                        <div class="empty">Bir ders seçerek katılım sıralamasını görebilirsin.</div>
                    @endif
                </div>

                <section class="two-col">
                    <div class="card">
                        <h3 class="section-title">Katılım Grafiği</h3>
                        <p class="section-sub">Son 7 takvim gününün katılım dağılımı. Her satır, ilgili tarihteki var kayıt sayısını ve toplam içindeki payını gösterir.</p>
                        @foreach($haftalikKatilim as $satir)
                            <div class="chart-row">
                                <div>
                                    <strong>{{ $satir['gun'] }}</strong>
                                    <div class="muted">{{ $satir['gun_adi'] }}</div>
                                </div>
                                <div class="track"><div class="fill" style="width: {{ $satir['oran'] }}%"></div></div>
                                <div class="chart-value">%{{ $satir['oran'] }}<br><small class="muted">{{ $satir['adet'] }} katilim</small></div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card">
                        <h3 class="section-title">En Yüksek Katılımlı Dersler</h3>
                        <p class="section-sub">Öğrenci sayısına göre sıralanan dersler. Yanlarında toplam katılım sayısı ve ders detayı yer alır.</p>
                        @forelse($enYuksekKatilimliDersler as $ders)
                            <div class="week-item">
                                <div class="week-day">{{ $ders['sira'] }}.</div>
                                <div>
                                    <strong>{{ $ders['ad'] }}</strong>
                                    <div class="muted">{{ $ders['ogrenci_sayisi'] }} öğrenci</div>
                                </div>
                                <div class="muted">
                                    <strong>{{ $ders['toplam'] }}</strong> katılım<br>
                                    <small>{{ $ders['detay'] }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="empty">Ders bulunmuyor.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
