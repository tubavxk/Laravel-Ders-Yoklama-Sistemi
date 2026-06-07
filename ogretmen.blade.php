<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogretmen Paneli</title>
    <style>
        :root{
            --bg:#f4fbff;
            --panel:#ffffff;
            --line:#d8eaf8;
            --text:#1f3440;
            --muted:#6f8594;
            --brand:#2b9a84;
            --brand2:#5aa8df;
        }
        *{box-sizing:border-box;font-family:"Trebuchet MS","Segoe UI",Arial,sans-serif}
        body{margin:0;background:#fff;color:var(--text)}
        .navbar{background:linear-gradient(90deg,#2d9cdb,#2dd4bf);color:#fff;padding:20px 28px;font-size:22px;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
        .shell{display:grid;grid-template-columns:280px minmax(0,1fr);min-height:calc(100vh - 68px)}
        .sidebar{padding:16px 14px}
        .sidebar-inner{height:100%;border-radius:28px;background:#fff;border:1px solid var(--line);box-shadow:0 18px 40px rgba(68,123,179,.12);padding:16px;display:flex;flex-direction:column;gap:14px}
        .sidebar-brand{background:#fff;border:1px solid var(--line);border-radius:20px;padding:16px;text-align:center}
        .sidebar-nav{display:flex;flex-direction:column;gap:12px;height:100%}
        .nav-link{display:block;text-decoration:none;color:#5f7392;padding:16px 18px;border-radius:18px;border:1px solid transparent;background:transparent;transition:.2s}
        .nav-link:hover,.nav-link.active{background:linear-gradient(90deg,#2d9cdb 0%,#5ec8ff 52%,#2dd4bf 100%);color:#fff;transform:translateX(4px)}
        .nav-link span{display:block;font-weight:700;font-size:17px}
        .nav-link small{display:block;margin-top:4px;font-size:12px;color:inherit;opacity:.8}
        .nav-link.logout{margin-top:auto;background:linear-gradient(135deg,#2d9cdb,#2dd4bf);color:#fff}
        .content{padding:14px 18px 40px 4px}
        .alert{margin-bottom:14px;padding:14px 16px;border-radius:16px;font-weight:700;border:1px solid var(--line)}
        .alert.success{background:#f1f0ff;color:#5b6cff}
        .alert.error{background:#f5f7ff;color:#4a4f7a}
        .hero{position:relative;overflow:hidden;background:#fff;border:1px solid #e1e7ef;border-radius:32px;padding:34px 34px 30px 40px;box-shadow:0 20px 46px rgba(46,82,92,.08);margin-bottom:22px}
        .hero:before{content:"";position:absolute;left:0;top:0;bottom:0;width:12px;background:linear-gradient(180deg,#2d9cdb,#5ec8ff 55%,#2dd4bf)}
        .pill{display:inline-flex;padding:8px 14px;border-radius:999px;background:linear-gradient(135deg,#2d9cdb,#2dd4bf);color:#fff;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
        .hero h1{margin:14px 0 8px;font-size:38px;letter-spacing:-.03em}
        .hero p{margin:0;max-width:820px;color:var(--muted);line-height:1.7}
        .profile-grid,.stats-grid,.quick-actions{display:grid;gap:14px}
        .profile-grid{grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-top:18px}
        .profile-item,.card,.panel,.quick-item{background:#fff;border:1px solid var(--line);border-radius:24px;box-shadow:0 14px 30px rgba(28,53,58,.06)}
        .profile-item{padding:14px 16px}
        .label{font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#7c90aa;margin-bottom:5px}
        .value{font-size:16px;font-weight:700;word-break:break-word}
        .stats-grid{grid-template-columns:repeat(auto-fit,minmax(180px,1fr));margin-top:22px}
        .stat{padding:18px 18px 16px;position:relative;overflow:hidden;background:linear-gradient(180deg,#fff 0%,#f8f9ff 100%)}
        .stat:before{content:"";position:absolute;left:0;top:0;right:0;height:6px;background:linear-gradient(90deg,#2d9cdb,#5ec8ff,#2dd4bf)}
        .stat:nth-child(1){background:linear-gradient(145deg,#f7fbff 0%,#eaf6ff 100%)}
        .stat:nth-child(2){background:linear-gradient(145deg,#f6fffe 0%,#e6fbf8 100%)}
        .stat:nth-child(3){background:linear-gradient(145deg,#f7fbff 0%,#edf7ff 100%)}
        .stat:nth-child(4){background:linear-gradient(145deg,#f6fffe 0%,#edfdfa 100%)}
        .stat strong{display:block;font-size:38px;margin-top:8px;color:#1f5668;line-height:1}
        .stat .label{color:#2d6175}
        .stat .muted{margin-top:8px;font-size:13px;line-height:1.5}
        .two-col{display:grid;grid-template-columns:1.2fr .8fr;gap:20px;margin-top:22px}
        .card,.panel{padding:22px}
        .section-title{margin:0 0 8px;font-size:22px;color:#2d9cdb}
        .section-sub{margin:0 0 14px;color:var(--muted);line-height:1.6}
        table{width:100%;border-collapse:collapse}
        th,td{padding:12px 10px;text-align:left;border-bottom:1px solid #e9f1f7}
        th{font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#4b6f7a;background:#f4fbff}
        .empty{padding:18px;border:1px dashed #c7dced;border-radius:16px;color:var(--muted)}
        .quick-actions{grid-template-columns:repeat(auto-fit,minmax(200px,1fr))}
        .quick-item{text-decoration:none;color:#20324a;padding:16px 18px}
        .quick-item strong{display:block;margin-bottom:6px;color:#24508e}
        .lesson-card{padding:18px;border-radius:18px;border:1px solid #e2edf7;background:#fff;margin-bottom:12px}
        .badge{display:inline-flex;padding:7px 12px;border-radius:999px;background:#e8fbfa;color:#2d9cdb;font-size:12px;font-weight:700;margin-bottom:10px}
        .btn{display:inline-block;background:linear-gradient(135deg,#2d9cdb,#2dd4bf);color:#fff;text-decoration:none;padding:11px 18px;border-radius:14px;font-weight:700}
        .muted{color:var(--muted)}
        .time-badge{display:inline-flex;padding:8px 12px;border-radius:999px;background:#e8fbfa;color:#2d9cdb;font-weight:700}
        @media (max-width: 1100px){.shell{grid-template-columns:1fr}.two-col{grid-template-columns:1fr}.content{padding:12px 12px 28px}.hero{padding:26px}}
    </style>
</head>
<body>
    <div class="navbar">ÖĞRETMEN PANELİ</div>
    <div class="shell">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="max-width:190px;width:100%;height:auto;display:block;margin:0 auto">
                </div>
                <nav class="sidebar-nav">
                    <a class="nav-link active" href="/ogretmen"><span>Ana Sayfa</span><small>Öğretmen paneli</small></a>
                    <a class="nav-link" href="/ogretmen/grafikler"><span>Grafikler</span><small>Katılım ve özetler</small></a>
                    <a class="nav-link" href="/ogretmen/derslerim"><span>Derslerim</span><small>Atanmış dersleri gör</small></a>
                    <a class="nav-link" href="/ogretmen/yoklama"><span>Yoklama Gir</span><small>Yoklama ekranına git</small></a>
                    <a class="nav-link" href="/ogretmen/profilim"><span>Profilim</span><small>Kişisel bilgilerin</small></a>
                    <a class="nav-link logout" href="/logout"><span>Çıkış</span><small>Oturumu sonlandır</small></a>
                </nav>
            </div>
        </aside>

        <main class="content">
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            <section class="hero">
                <div class="pill">Yoklama Merkezi</div>
                <h1>Hoş geldin, {{ $ogretmen->name }}</h1>
                <p>Derslerini tek ekranda yönetebilir, bugünün programini görebilir ve seçtiğin ders için hızlı yoklama girebilirsin.</p>
                <div class="profile-grid">
                    <div class="profile-item"><div class="label">Ad Soyad</div><div class="value">{{ $ogretmen->name }}</div></div>
                    <div class="profile-item"><div class="label">E-Posta</div><div class="value">{{ $ogretmen->email }}</div></div>
                    <div class="profile-item"><div class="label">Rol</div><div class="value">{{ ucfirst($ogretmen->rol) }}</div></div>
                </div>
            </section>

            <section class="stats-grid">
                <div class="card stat"><span class="label">Toplam Ders</span><strong>{{ $dersler->count() }}</strong><div class="muted">Sistemde aktif ders sayısı</div></div>
                <div class="card stat"><span class="label">Toplam Öğrenci</span><strong>{{ $toplamOgrenci }}</strong><div class="muted">Derslere atanmış toplam öğrenci</div></div>
                <div class="card stat"><span class="label">Yoklama Günü</span><strong>{{ $toplamYoklamaGunu }}</strong><div class="muted">Kaydedilmiş toplam yoklama tarihi</div></div>
                <div class="card stat"><span class="label">Bugünün Dersi</span><strong>{{ $bugununDersleri->count() }}</strong><div class="muted">{{ $bugununGunu ?? 'Bugün' }} için planlanan ders sayısı</div></div>
            </section>

            <section class="two-col">
                <div class="panel">
                    <h3 class="section-title">Bugünün Dersleri</h3>
                    <p class="section-sub">Bugün yapılacak dersler.</p>
                    @if($bugununDersleri->count() > 0)
                        @foreach($bugununDersleri as $ders)
                            <div class="lesson-card">
                                <div class="time-badge">{{ $ders->saat }}</div>
                                <h4>{{ $ders->ders_adi }}</h4>
                                <div class="muted">{{ $ders->ders_kodu }}</div>
                                <div class="muted">{{ $ders->ogrenci_sayisi }} öğrenci</div>
                                <div class="muted">{{ $ders->devamsiz_ogrenci_sayisi }} devamsiz ogrenci kaydı</div>
                                <a href="/ogretmen/yoklama?ders_id={{ $ders->id }}&tarih={{ $seciliTarih }}" class="btn" style="margin-top:12px">Yoklamaya Git</a>
                            </div>
                        @endforeach
                    @else
                        <div class="empty">Bugün için ders bulunmuyor.</div>
                    @endif
                </div>

                <div class="panel">
                    <h3 class="section-title">Aktif QR Oturumları</h3>
                    <p class="section-sub">Hızlı yoklama için açık oturumlar.</p>
                    @if($aktifOturumlar->count() > 0)
                        @foreach($aktifOturumlar as $oturum)
                            <div class="lesson-card">
                                <div class="badge">{{ $oturum->ders_kodu }}</div>
                                <h4>{{ $oturum->ders_adi }}</h4>
                                <div class="muted">Tarih: {{ $oturum->tarih }}</div>
                                <div class="muted">Token: {{ \Illuminate\Support\Str::limit($oturum->token, 18) }}</div>
                                <form method="POST" action="/qr-oturumu-kapat" style="margin-top:12px">
                                    @csrf
                                    <input type="hidden" name="oturum_id" value="{{ $oturum->id }}">
                                    <button type="submit" class="btn" style="width:100%;background:linear-gradient(135deg,#d85d5d,#b93b3b);">QR Kapat</button>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <div class="empty">Aktif QR oturumu yok.</div>
                    @endif
                </div>
            </section>
        </main>
    </div>
</body>
</html>
