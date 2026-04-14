<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli</title>
    <style>
        :root {
            --sea-50: #f3fcf8;
            --sea-100: #dcf5eb;
            --sea-200: #c1eadc;
            --sea-300: #98d9c4;
            --sea-500: #2d9f86;
            --sea-700: #0f6f65;
            --ink: #18343b;
            --ink-soft: #617980;
            --powder-100: #eef7ff;
            --powder-200: #d8edff;
            --powder-300: #c7e4ff;
            --powder-500: #5ea8d8;
            --shell: rgba(255, 255, 255, 0.84);
        }

        * {
            box-sizing: border-box;
            font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 12% 10%, rgba(199, 228, 255, 0.28), transparent 22%),
                radial-gradient(circle at 88% 14%, rgba(45, 159, 134, 0.2), transparent 18%),
                linear-gradient(135deg, #f8fffd 0%, #edf9f4 46%, #eef7ff 100%);
            color: var(--ink);
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                linear-gradient(115deg, rgba(255, 255, 255, 0.68) 0%, rgba(255, 255, 255, 0) 38%),
                repeating-linear-gradient(90deg, rgba(45, 159, 134, 0.04) 0 1px, transparent 1px 120px);
            pointer-events: none;
            z-index: 0;
        }

        .navbar {
            position: relative;
            z-index: 1;
            background: linear-gradient(90deg, rgba(15, 111, 101, 0.98), rgba(45, 159, 134, 0.95), rgba(166, 214, 247, 0.92));
            color: #fffaf8;
            padding: 20px 32px;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            box-shadow: 0 18px 38px rgba(15, 91, 82, 0.18);
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1220px;
            margin: 30px auto;
            padding: 0 20px 44px;
        }

        .hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #0f6f65 0%, #2d9f86 58%, #c7e4ff 120%);
            color: white;
            padding: 34px;
            border-radius: 34px;
            margin-bottom: 24px;
            box-shadow: 0 28px 58px rgba(15, 111, 101, 0.24);
        }

        .hero::before {
            content: "";
            position: absolute;
            top: -92px;
            right: 54px;
            width: 220px;
            height: 220px;
            border-radius: 40px;
            background: rgba(255, 255, 255, 0.12);
            transform: rotate(18deg);
        }

        .hero::after {
            content: "";
            position: absolute;
            right: -30px;
            bottom: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(209, 236, 255, 0.28);
            filter: blur(4px);
        }

        .hero h1 {
            position: relative;
            z-index: 1;
            margin: 0 0 10px;
            font-size: 38px;
            letter-spacing: -0.03em;
        }

        .hero p {
            position: relative;
            z-index: 1;
            margin: 0;
            max-width: 720px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.93);
        }

        .hero-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 12px;
            margin-top: 18px;
            position: relative;
            z-index: 1;
        }

        .hero-pill {
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12);
        }

        .hero-pill-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            opacity: 0.82;
            margin-bottom: 6px;
        }

        .hero-pill-value {
            font-size: 22px;
            font-weight: 700;
        }
        
        .card,
        .panel,
        .action-card,
        .mini-status {
            background: var(--shell);
            border: 1px solid rgba(45, 159, 134, 0.14);
            border-radius: 26px;
            box-shadow: 0 18px 42px rgba(24, 52, 59, 0.08);
            backdrop-filter: blur(14px);
        }

        .card,
        .panel,
        .action-card {
            padding: 22px;
        }

        .card h3,
        .panel h3,
        .action-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: var(--sea-700);
            letter-spacing: -0.02em;
        }

        .stat {
            font-size: 40px;
            font-weight: 700;
            margin: 6px 0 8px;
            color: var(--ink);
        }

        .circle-stat {
            min-height: 218px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
        }

        .circle-stat .number-bubble {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin-top: 10px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72), 0 14px 26px rgba(24, 52, 59, 0.12);
        }

        .shape-blue {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.96) 0%, rgba(220, 245, 235, 0.92) 52%, rgba(222, 241, 255, 0.82) 100%);
        }

        .shape-blue .number-bubble {
            background: rgba(255, 255, 255, 0.78);
            color: var(--sea-700);
        }

        .shape-sand {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.98) 0%, rgba(245, 251, 255, 0.94) 62%, rgba(199, 228, 255, 0.72) 100%);
            border-radius: 24px 54px 24px 24px;
        }

        .shape-sand .number-bubble {
            background: rgba(255, 255, 255, 0.82);
            color: #4f87aa;
        }

        .shape-alert {
            background: linear-gradient(160deg, rgba(244, 250, 255, 0.98) 0%, rgba(255, 255, 255, 0.96) 48%, rgba(193, 234, 220, 0.74) 100%);
            border-radius: 56px 24px 24px 24px;
        }

        .shape-alert .number-bubble {
            background: rgba(199, 228, 255, 0.82);
            color: #3e7ba3;
        }

        .muted {
            color: var(--ink-soft);
        }

        .summary-table {
            margin-bottom: 22px;
        }

        .summary-table-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 12px;
        }

        .summary-item {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94) 0%, rgba(222, 241, 255, 0.34) 100%);
            border: 1px solid rgba(94, 168, 216, 0.18);
            border-radius: 20px;
            padding: 18px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .summary-title {
            font-size: 12px;
            color: #7d8f95;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .summary-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--sea-700);
            margin-bottom: 6px;
        }

        .summary-note {
            color: var(--ink-soft);
            font-size: 13px;
            line-height: 1.45;
        }

        .overview-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .mini-status-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        .mini-status {
            padding: 16px;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(220, 245, 235, 0.6) 100%);
            border: 1px solid rgba(45, 159, 134, 0.16);
        }

        .mini-status:nth-child(even) {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(214, 236, 255, 0.58) 100%);
            border-color: rgba(94, 168, 216, 0.18);
        }

        .mini-status-title {
            font-size: 13px;
            color: #597178;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .mini-status strong {
            display: block;
            margin-top: 6px;
            font-size: 24px;
            color: var(--ink);
        }

        .warning {
            color: #4f87aa;
        }

        .success {
            color: #0c7a61;
        }
        
        .table-wrap {
            overflow-x: auto;
            border-radius: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid rgba(24, 52, 59, 0.08);
            vertical-align: top;
        }

        th {
            background: linear-gradient(90deg, rgba(45, 159, 134, 0.14), rgba(214, 236, 255, 0.42));
            color: var(--sea-700);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        table tr:hover td {
            background: rgba(243, 252, 248, 0.72);
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 16px;
        }

        .action-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94) 0%, rgba(243, 252, 248, 0.88) 100%);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .action-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 40px rgba(32, 88, 80, 0.12);
            border-color: rgba(94, 168, 216, 0.28);
        }

        .action-card p {
            color: #4e6870;
            line-height: 1.7;
            min-height: 72px;
        }

        .action-card.circle-stat {
            min-height: 218px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .shape-blue {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.96) 0%, rgba(220, 245, 235, 0.92) 52%, rgba(222, 241, 255, 0.82) 100%);
        }

        .shape-blue .number-bubble {
            background: rgba(255, 255, 255, 0.78);
            color: var(--sea-700);
        }

        .shape-sand {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.98) 0%, rgba(245, 251, 255, 0.94) 62%, rgba(199, 228, 255, 0.72) 100%);
            border-radius: 24px 54px 24px 24px;
        }

        .shape-sand .number-bubble {
            background: rgba(255, 255, 255, 0.82);
            color: #4f87aa;
        }

        .shape-alert {
            background: linear-gradient(160deg, rgba(244, 250, 255, 0.98) 0%, rgba(255, 255, 255, 0.96) 48%, rgba(193, 234, 220, 0.74) 100%);
            border-radius: 56px 24px 24px 24px;
        }

        .shape-alert .number-bubble {
            background: rgba(199, 228, 255, 0.82);
            color: #3e7ba3;
        }

        .shape-teal {
            background: linear-gradient(145deg, #116c63 0%, #2d9f86 58%, #8ed8c5 110%);
            border-radius: 24px 24px 54px 24px;
            color: white;
        }

        .shape-teal .number-bubble {
            background: rgba(255, 255, 255, 0.18);
            color: white;
            box-shadow: none;
        }

        .shape-teal h3,
        .shape-teal p {
            color: white;
        }

        .number-bubble {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin-top: 10px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(214, 236, 255, 0.78);
            color: #3e7ba3;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .shape-teal .badge {
            background: rgba(255, 255, 255, 0.18);
            color: white;
        }

        .btn {
            display: inline-block;
            margin-top: 12px;
            padding: 11px 18px;
            background: linear-gradient(135deg, #127266, #2d9f86);
            color: white;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 700;
            box-shadow: 0 12px 20px rgba(18, 114, 102, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(18, 114, 102, 0.24);
            filter: saturate(1.05);
        }

        .btn-danger {
            background: linear-gradient(135deg, #5ea8d8, #3f86b7);
            box-shadow: 0 12px 22px rgba(63, 134, 183, 0.24);
        }

        .shape-teal .btn:not(.btn-danger) {
            background: white;
            color: var(--sea-700);
            box-shadow: 0 14px 26px rgba(14, 79, 71, 0.16);
        }

        .empty {
            padding: 20px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px dashed rgba(45, 159, 134, 0.28);
            border-radius: 18px;
            color: var(--ink-soft);
        }

        @media (max-width: 980px) {
            .overview-grid {
                grid-template-columns: 1fr;
            }
        
            .mini-status-grid {
                grid-template-columns: 1fr 1fr;
            }
        
            .summary-table-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        
        @media (max-width: 640px) {
            .navbar {
                padding: 18px 20px;
                font-size: 18px;
                letter-spacing: 0.08em;
            }

            .hero {
                padding: 26px 22px;
                border-radius: 28px;
            }

            .hero h1 {
                font-size: 30px;
            }

            .summary-table-grid {
                grid-template-columns: 1fr;
            }
        
            .mini-status-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Admin Paneli</div>

    <div class="container">
        <div class="hero">
            <h1>Hos geldin Admin</h1>
            <p>Sistemin genel durumunu tek bakista gorebilir, kullanici ve ders yonetimini hizli kartlar uzerinden yapabilirsin.</p>
            <div class="hero-strip">
                <div class="hero-pill">
                    <div class="hero-pill-label">Toplam Kullanici</div>
                    <div class="hero-pill-value">{{ $istatistikler['toplam_kullanici'] }}</div>
                </div>
                <div class="hero-pill">
                    <div class="hero-pill-label">Toplam Ders</div>
                    <div class="hero-pill-value">{{ $istatistikler['toplam_ders'] }}</div>
                </div>
                <div class="hero-pill">
                    <div class="hero-pill-label">Toplam Atama</div>
                    <div class="hero-pill-value">{{ $istatistikler['toplam_atama'] }}</div>
                </div>
                <div class="hero-pill">
                    <div class="hero-pill-label">Aktif QR</div>
                    <div class="hero-pill-value">{{ $istatistikler['aktif_qr'] }}</div>
                </div>
            </div>
        </div>

        <div class="action-grid">
            <div class="action-card circle-stat shape-blue" style="grid-row: span 2;">
                <div>
                    <div class="badge">Yonetim</div>
                    <h3>Kullanicilar</h3>
                    <p>Ogrenci, ogretmen ve admin kullanicilarini yonet ve yeni hesaplar ekle.</p>
                    <a href="/kullanicilar" class="btn">Kullanicilari Gor</a>
                </div>
                <div class="number-bubble">U</div>
            </div>

            <div class="action-card circle-stat shape-sand">
                <div>
                    <div class="badge">Dersler</div>
                    <h3>Ders Yonetimi</h3>
                    <p>Dersleri olustur, program bilgilerini duzenle ve ders havuzunu kontrol et.</p>
                    <a href="/dersler" class="btn">Dersleri Gor</a>
                </div>
                <div class="number-bubble">D</div>
            </div>

            <div class="action-card circle-stat shape-alert">
                <div>
                    <div class="badge">Atama</div>
                    <h3>Ders Atama</h3>
                    <p>Ogretmen ve ogrencileri derslerle eslestir, eksik atamalari tamamla.</p>
                    <a href="/ders-atama" class="btn">Atama Yap</a>
                </div>
                <div class="number-bubble">A</div>
            </div>

            <div class="action-card circle-stat shape-teal">
                <div>
                    <div class="badge">Oturum</div>
                    <h3>Cikis</h3>
                    <p>Admin oturumunu guvenli sekilde sonlandir.</p>
                    <a href="/logout" class="btn btn-danger">Cikis Yap</a>
                </div>
                <div class="number-bubble">O</div>
            </div>
        </div>

        <div class="panel summary-table" style="margin-top: 22px;">
            <h3>Kullanici ve Ders Ozeti</h3>
            <div class="summary-table-grid">
                <div class="summary-item">
                    <div class="summary-title">Ogrenciler</div>
                    <div class="summary-value">{{ $istatistikler['toplam_ogrenci'] }}</div>
                    <div class="summary-note">Sistemde aktif gorunen toplam ogrenci sayisi</div>
                </div>

                <div class="summary-item">
                    <div class="summary-title">Ogretmenler</div>
                    <div class="summary-value">{{ $istatistikler['toplam_ogretmen'] }}</div>
                    <div class="summary-note">Ders yoneten ogretmenler</div>
                </div>

                <div class="summary-item">
                    <div class="summary-title">Adminler</div>
                    <div class="summary-value">{{ $istatistikler['toplam_admin'] }}</div>
                    <div class="summary-note">Panel yetkili kullanicilar</div>
                </div>

                <div class="summary-item">
                    <div class="summary-title">Ogretmensiz Ders</div>
                    <div class="summary-value">{{ $istatistikler['ogretmensiz_ders'] }}</div>
                    <div class="summary-note">Atama bekleyen dersler</div>
                </div>
            </div>
        </div>

        <div class="overview-grid" style="margin-top: 22px;">
            <div class="panel">
                <h3>Hizli Durum</h3>
                <div class="mini-status-grid">
                    <div class="mini-status">
                        <div class="mini-status-title">Derssiz Ogrenci</div>
                        <strong class="{{ $istatistikler['derssiz_ogrenci'] > 0 ? 'warning' : 'success' }}">{{ $istatistikler['derssiz_ogrenci'] }}</strong>
                    </div>
                    <div class="mini-status">
                        <div class="mini-status-title">Derssiz Ogretmen</div>
                        <strong class="{{ $istatistikler['derssiz_ogretmen'] > 0 ? 'warning' : 'success' }}">{{ $istatistikler['derssiz_ogretmen'] }}</strong>
                    </div>
                    <div class="mini-status">
                        <div class="mini-status-title">Aktif QR Oturumu</div>
                        <strong class="{{ $istatistikler['aktif_qr'] > 0 ? 'warning' : 'success' }}">{{ $istatistikler['aktif_qr'] }}</strong>
                    </div>
                    <div class="mini-status">
                        <div class="mini-status-title">Toplam Atama</div>
                        <strong>{{ $istatistikler['toplam_atama'] }}</strong>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h3>Son Eklenen Dersler</h3>
                @if($sonEklenenDersler->count() > 0)
                    <div class="table-wrap">
                        <table>
                            <tr>
                                <th>Ders</th>
                                <th>Kod</th>
                                <th>Program</th>
                            </tr>
                            @foreach($sonEklenenDersler as $ders)
                                <tr>
                                    <td>{{ $ders->ders_adi }}</td>
                                    <td>{{ $ders->ders_kodu }}</td>
                                    <td>{{ $ders->gun }} / {{ $ders->saat }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="empty">Henuz ders eklenmemis.</div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>




