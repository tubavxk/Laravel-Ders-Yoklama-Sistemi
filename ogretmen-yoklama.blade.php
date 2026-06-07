<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yoklama Gir</title>
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
        .hero, .panel, .selected-box, .status-card, .qr-box { background: #fff; border: 1px solid rgba(143,189,232,.2); border-radius: 28px; box-shadow: 0 18px 40px rgba(99,169,230,.08); }
        .hero { padding: 30px 34px; margin-bottom: 20px; position: relative; overflow: hidden; }
        .hero:before{content:"";position:absolute;left:0;top:0;bottom:0;width:12px;background:linear-gradient(180deg,#2d9cdb,#5ec8ff 55%,#2dd4bf)}
        .hero h1 { margin: 0 0 10px; font-size: 38px; color: #173152; letter-spacing: -.03em; }
        .hero p { margin: 0; color: #58708b; line-height: 1.7; max-width: 820px; }
        .panel { padding: 24px; margin-bottom: 20px; }
        .panel h2, .panel h3 { margin-top: 0; color: #24508e; }
        .form-top { display: grid; grid-template-columns: 1.2fr 1fr auto; gap: 12px; align-items: end; margin-bottom: 20px; padding: 18px; border-radius: 22px; background: linear-gradient(180deg, rgba(243,255,249,.92), rgba(255,255,255,.94)); border: 1px solid rgba(43,154,132,.12); }
        label { display: block; margin-bottom: 6px; font-weight: 700; color: #39535a; text-transform: uppercase; letter-spacing: .05em; font-size: 12px; }
        select, input[type="date"] { width: 100%; padding: 11px 13px; border-radius: 14px; border: 1px solid #cadbd8; background: #fff; }
        .btn { display: inline-block; border: none; padding: 12px 16px; border-radius: 12px; text-decoration: none; background: linear-gradient(135deg, #2d9cdb, #2dd4bf); color: #fff; font-weight: 700; box-shadow: 0 10px 24px rgba(79,143,218,.2); cursor: pointer; }
        .btn-danger { background: #dc2626; }
        .selected-box { padding: 18px; margin-bottom: 16px; }
        .status-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 18px; }
        .status-card { padding: 14px 16px; }
        .status-card strong { display: block; font-size: 28px; margin-top: 8px; color: #1f5668; }
        .qr-box { display: grid; grid-template-columns: 220px 1fr; gap: 18px; padding: 18px; margin-bottom: 16px; }
        .qr-box img { width: 220px; height: 220px; border-radius: 20px; background: white; border: 1px solid rgba(43,154,132,.14); padding: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #e6eef4; vertical-align: top; }
        th { background: linear-gradient(90deg, #eff6ff, #dbeafe); color: #24508e; font-size: 13px; }
        .row-danger { background: rgba(254,242,242,.55); }
        .row-success { background: rgba(240,253,244,.55); }
        .muted { color: #6b8288; }
        .empty { padding: 20px; border: 1px dashed rgba(143,189,232,.28); border-radius: 20px; color: #6b8288; background: rgba(255,255,255,.76); }
        @media (max-width: 980px) { .layout-shell { grid-template-columns: 1fr; } .sidebar { position: static; height: auto; } .content { padding: 0 12px 28px; } .form-top, .qr-box { grid-template-columns: 1fr; } .qr-box img { width: 100%; max-width: 220px; height: auto; } }
    </style>
</head>
<body>
    <div class="navbar">Ogretmen Paneli</div>
    <div class="layout-shell">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand"><img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width: 100%; max-width: 190px; height: auto; display: block; margin: 0 auto;"></div>
                <nav class="sidebar-nav">
                    <a href="/ogretmen" class="sidebar-link"><div><span>Ana Sayfa</span><br><small>Ogretmen paneli</small></div><span>›</span></a>
        <a href="/ogretmen/grafikler" class="sidebar-link"><div><span>Grafikler</span><br><small>Detayli ozetler</small></div><span>›</span></a>
                    <a href="/ogretmen/derslerim" class="sidebar-link"><div><span>Derslerim</span><br><small>Atanmis dersleri gor</small></div><span>›</span></a>
                    <a href="/ogretmen/yoklama" class="sidebar-link active"><div><span>Yoklama Gir</span><br><small>Yoklama ekranina git</small></div><span>›</span></a>
                    <a href="/ogretmen/profilim" class="sidebar-link"><div><span>Profilim</span><br><small>Kisisel bilgilerin</small></div><span>›</span></a>
                    <a href="/logout" class="sidebar-link logout"><div><span>Cikis</span><br><small>Oturumu sonlandir</small></div><span>›</span></a>
                </nav>
            </div>
        </aside>
        <main class="content">
            <div class="container">
                <div class="hero"><h1>Yoklama Gir</h1><p>Bir ders ve tarih secerek yoklama kaydini buradan yonetebilirsin.</p></div>
                <div class="status-grid" style="margin-bottom:18px;">
                    <div class="status-card">Toplam Ders Sayisi<strong>{{ $dersler->count() }}</strong></div>
                    <div class="status-card">Secili Ders<strong>{{ $seciliDers ? $seciliDers->ders_adi : 'Yok' }}</strong></div>
                    <div class="status-card">Aktif QR<strong>{{ $aktifQrOturumu ? 1 : 0 }}</strong></div>
                    <div class="status-card">Toplam Ogrenci<strong>{{ $seciliDers ? ($seciliDersGelenSayisi + $seciliDersGelmeyenSayisi + $seciliDersKalanSayisi) : 0 }}</strong></div>
                </div>
                <div class="panel">
                    <form method="GET" action="/ogretmen/yoklama" class="form-top">
                        <div><label>Ders Sec</label><select name="ders_id" required><option value="">Ders sec</option>@foreach($dersler as $ders)<option value="{{ $ders->id }}" {{ $seciliDers && $seciliDers->id == $ders->id ? 'selected' : '' }}>{{ $ders->ders_adi }} ({{ $ders->ders_kodu }})</option>@endforeach</select></div>
                        <div><label>Tarih</label><input type="date" name="tarih" value="{{ $seciliTarih }}" required></div>
                        <div><button type="submit" class="btn">Listele</button></div>
                    </form>
                    @if($seciliDers)
                        <div class="selected-box"><strong>Secili Ders:</strong> {{ $seciliDers->ders_adi }} - {{ $seciliDers->gun }} / {{ $seciliDers->saat }}</div>
                        <div class="status-grid">
                            <div class="status-card">Toplam Ders Sayisi<strong>{{ $seciliDersToplamDersSayisi }}</strong></div>
                            <div class="status-card">Bugun Gelen<strong>{{ $seciliDersGelenSayisi }}</strong></div>
                            <div class="status-card">Bugun Gelmeyen<strong>{{ $seciliDersGelmeyenSayisi }}</strong></div>
                            <div class="status-card">Kalan Ogrenci<strong>{{ $seciliDersKalanSayisi }}</strong></div>
                        </div>
                        @if($aktifQrOturumu)
                            <div class="qr-box">
                                <div><img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode(url('/qr-yoklama/' . $aktifQrOturumu->token)) }}" alt="QR Kod"></div>
                                <div>
                                    <h3 style="margin-top:0;">Aktif QR Yoklama</h3>
                                    <p><strong>Tarih:</strong> {{ $aktifQrOturumu->tarih }}</p>
                                    <p><strong>Ders:</strong> {{ $seciliDers->ders_adi }}</p>
                                    <p class="muted">Ogrenciler bu QR kodu okutunca otomatik olarak var yazilir.</p>
                                    <p class="muted">Baglanti: {{ url('/qr-yoklama/' . $aktifQrOturumu->token) }}</p>
                                    <div style="margin-top:16px"><form method="POST" action="/qr-oturumu-kapat">@csrf<input type="hidden" name="oturum_id" value="{{ $aktifQrOturumu->id }}"><button type="submit" class="btn btn-danger">QR Yoklamayi Kapat</button></form></div>
                                </div>
                            </div>
                        @endif
                        @if($ogrenciler->count() > 0)
                            <form method="POST" action="/yoklama-kaydet">@csrf<input type="hidden" name="ders_id" value="{{ $seciliDers->id }}"><input type="hidden" name="tarih" value="{{ $seciliTarih }}"><table><tr><th>Ogrenci</th><th>E-posta</th><th>Bugunku Durum</th><th>Toplam Devamsizlik</th><th>Sonuc</th><th>Islem</th></tr>@foreach($ogrenciler as $ogrenci)<tr class="{{ $ogrenci->bugunku_durum === 'yok' ? 'row-danger' : ($ogrenci->bugunku_durum === 'var' ? 'row-success' : '') }}"><td>{{ $ogrenci->name }}</td><td>{{ $ogrenci->email }}</td><td>@if($ogrenci->bugunku_durum === 'var')<span style="color:#16a34a;">Geldi</span>@elseif($ogrenci->bugunku_durum === 'yok')<span style="color:#dc2626;">Gelmedi</span>@else<span style="color:#b45309;">Henuz isaretlenmedi</span>@endif</td><td>{{ $ogrenci->devamsizlik_sayisi }}</td><td>@if($ogrenci->kaldi)<span style="color:#dc2626;">Kaldi</span>@else<span style="color:#16a34a;">Devam ediyor</span>@endif</td><td><select name="durumlar[{{ $ogrenci->id }}]"><option value="var" {{ ($ogrenci->mevcut_durum ?? 'var') == 'var' ? 'selected' : '' }}>Var</option><option value="yok" {{ ($ogrenci->mevcut_durum ?? '') == 'yok' ? 'selected' : '' }}>Yok</option></select></td></tr>@endforeach</table><div style="margin-top:16px"><button type="submit" class="btn">Yoklamayi Kaydet</button></div></form>
                        @endif
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
