<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ders Atama</title>
    <style>
        :root {
            --sky-50: #f8fbff;
            --sky-100: #eef6ff;
            --sky-200: #dbeafe;
            --sky-300: #bfdbfe;
            --sky-400: #93c5fd;
            --sky-500: #74b4f3;
            --sky-600: #4f8fda;
            --ink: #1f2937;
            --ink-soft: #64748b;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(191, 219, 254, 0.36), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef6ff 52%, #e8f3ff 100%);
            color: var(--ink);
        }
        
        .navbar {
            background: linear-gradient(90deg, #4f8fda, #74b4f3);
            color: white;
            padding: 18px 30px;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 10px 28px rgba(79, 143, 218, 0.2);
        }
        
        .container {
            max-width: 1220px;
            margin: 28px auto;
            padding: 0 20px 40px;
        }
        
        .hero {
            background: linear-gradient(135deg, #5d9de5, #8ec4fb);
            color: white;
            padding: 28px;
            border-radius: 22px;
            margin-bottom: 22px;
            box-shadow: 0 18px 40px rgba(93, 157, 229, 0.22);
        }
        
        .hero h1 {
            margin: 0 0 10px;
            font-size: 34px;
        }
        
        .hero p {
            margin: 0;
            line-height: 1.6;
        }
        
        .forms-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 22px;
        }
        
        .tables-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 22px;
        }
        
        .panel {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(239, 247, 255, 0.96) 100%);
            border: 1px solid rgba(191, 219, 254, 0.95);
            border-radius: 20px;
            box-shadow: 0 14px 30px rgba(59, 130, 246, 0.08);
            padding: 22px;
        }

        .panel::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 6px;
            background: linear-gradient(90deg, rgba(79, 143, 218, 0.82), rgba(191, 219, 254, 0.96));
        }
        
        .panel h2 {
            margin-top: 0;
            color: #24508e;
        }
        
        .field {
            margin-bottom: 14px;
        }
        
        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #355070;
        }
        
        .field select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #c6d9f6;
            background: #f8fbff;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        
        .btn {
            display: inline-block;
            border: none;
            padding: 12px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f8fda, #74b4f3);
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 10px 24px rgba(79, 143, 218, 0.2);
        }
        
        .btn-danger {
            background: #dc2626;
            box-shadow: 0 10px 22px rgba(220, 38, 38, 0.18);
        }
        
        .btn-light {
            background: linear-gradient(135deg, #eaf4ff, #d8ecff);
            color: #1e3a8a;
            box-shadow: 0 8px 18px rgba(148, 184, 255, 0.18);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        
        th,
        td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        
        th {
            background: linear-gradient(90deg, #eff6ff, #dbeafe);
            color: #24508e;
            font-size: 13px;
        }
        
        .warning-row {
            background: linear-gradient(180deg, rgba(239, 246, 255, 0.96), rgba(219, 234, 254, 0.84));
        }
        
        .muted {
            color: var(--ink-soft);
        }
        
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        
        @media (max-width: 980px) {
            .forms-grid,
            .tables-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Ders Atama</div>
    <div class="container">
        <div class="hero">
            <h1>Ders Atama Merkezi</h1>
            <p>Ogretmen ve ogrencileri derslerle eslestir, mevcut atamalari takip et ve eksikleri tamamla.</p>
        </div>
        <div class="forms-grid">
            <div class="panel">
                <h2>Ogretmene Ders Ata</h2>
                <form method="POST" action="/ogretmen-ata">
                    @csrf
                    <div class="field">
                        <label>Ogretmen Sec</label>
                        <select name="ogretmen_id" required>
                            <option value="">Ogretmen sec</option>
                            @foreach($ogretmenler as $o)
                                <option value="{{ $o->id }}">{{ $o->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Ders Sec</label>
                        <select name="ders_id" required>
                            <option value="">Ders sec</option>
                            @foreach($dersler as $d)
                                <option value="{{ $d->id }}">{{ $d->ders_adi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn">Atamayi Kaydet</button>
                </form>
            </div>
            <div class="panel">
                <h2>Ogrenciye Ders Ata</h2>
                <form method="POST" action="/ogrenciye-ders-ata">
                    @csrf
                    <div class="field">
                        <label>Ogrenci Sec</label>
                        <select name="ogrenci_id" required>
                            <option value="">Ogrenci sec</option>
                            @foreach($ogrenciler as $o)
                                <option value="{{ $o->id }}">{{ $o->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Ders Sec</label>
                        <select name="ders_id" required>
                            <option value="">Ders sec</option>
                            @foreach($dersler as $d)
                                <option value="{{ $d->id }}">{{ $d->ders_adi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn">Atamayi Kaydet</button>
                </form>
            </div>
        </div>
        <div class="tables-grid">
            <div class="panel">
                <h2>Atanan Ogretmenler</h2>
                <table>
                    <tr><th>Ders</th><th>Ogretmen</th><th>Islem</th></tr>
                    @forelse($atananOgretmenler as $a)
                    <tr>
                        <td>{{ $a->ders_adi }}</td>
                        <td>{{ $a->ogretmen_adi }}</td>
                        <td><a class="btn btn-danger" href="/ogretmen-dersten-cikar/{{ $a->ders_id }}" onclick="return confirm('Ogretmeni bu dersten cikarmak istedigine emin misin?')">Cikar</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="muted">Henuz ogretmen atamasi yok.</td></tr>
                    @endforelse
                </table>
            </div>
            <div class="panel">
                <h2>Atanan Ogrenciler</h2>
                <table>
                    <tr><th>Ogrenci</th><th>Ders</th><th>Islem</th></tr>
                    @forelse($atananOgrenciler as $a)
                    <tr>
                        <td>{{ $a->ogrenci_adi }}</td>
                        <td>{{ $a->ders_adi }}</td>
                        <td><a class="btn btn-danger" href="/ogrenci-dersten-cikar/{{ $a->id }}" onclick="return confirm('Ogrenciyi bu dersten cikarmak istedigine emin misin?')">Cikar</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="muted">Henuz ogrenci atamasi yok.</td></tr>
                    @endforelse
                </table>
            </div>
        </div>
        <div class="panel">
            <h2>Uyari Listesi</h2>
            <table>
                <tr><th>Tur</th><th>Ad</th><th>Durum</th></tr>
                @forelse($atanmamisOgretmenler as $o)
                <tr class="warning-row"><td>Ogretmen</td><td>{{ $o->name }}</td><td>Ders atanmamis, atayin.</td></tr>
                @empty
                @endforelse
                @forelse($atanmamisOgrenciler as $o)
                <tr class="warning-row"><td>Ogrenci</td><td>{{ $o->name }}</td><td>Ders atanmamis, atayin.</td></tr>
                @empty
                @endforelse
                @if($atanmamisOgretmenler->count() == 0 && $atanmamisOgrenciler->count() == 0)
                <tr><td colspan="3" class="muted">Atanmamis ogretmen veya ogrenci yok.</td></tr>
                @endif
            </table>
            <div class="actions">
                <a href="/admin" class="btn btn-light">Admin Panele Don</a>
            </div>
        </div>
    </div>
</body>
</html>
