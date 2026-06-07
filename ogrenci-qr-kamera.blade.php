<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogrenci QR Kamera</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: linear-gradient(180deg, #0f172a 0%, #111827 100%); color: #e5e7eb; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: rgba(15, 23, 42, 0.95); padding: 24px; border-right: 1px solid rgba(255,255,255,.08); }
        .brand { font-size: 22px; font-weight: 700; margin-bottom: 18px; }
        .muted { color: #94a3b8; }
        .sidebar-link { display:flex; justify-content:space-between; align-items:center; padding:14px 16px; margin-top:10px; border-radius:16px; text-decoration:none; color:#e5e7eb; background: rgba(255,255,255,.04); }
        .sidebar-link.active { background: linear-gradient(135deg, #2563eb, #06b6d4); color: white; }
        .content { flex:1; padding: 28px; }
        .panel { background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(255,255,255,.08); border-radius: 24px; padding: 24px; }
        .scanner-grid { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(280px, .9fr); gap: 20px; margin-top: 18px; }
        .scanner-preview { position: relative; aspect-ratio: 16 / 10; border-radius: 20px; overflow: hidden; background: #020617; border: 1px solid rgba(255,255,255,.08); }
        .scanner-preview video { width: 100%; height: 100%; object-fit: cover; }
        .scanner-hint { position:absolute; inset: 16px; border: 2px solid rgba(34,197,94,.65); border-radius: 18px; }
        .scanner-status, .empty { margin-top: 12px; padding: 14px 16px; border-radius: 16px; background: rgba(255,255,255,.05); color: #d1d5db; }
        .btn { padding: 12px 16px; border-radius: 12px; border: 0; cursor: pointer; font-weight: 700; background: #2563eb; color: white; }
        .btn-danger { background: #ef4444; }
        .mini-list { display: grid; gap: 10px; }
        .mini-item { padding: 14px 16px; border-radius: 16px; background: rgba(255,255,255,.05); }
        .lesson-meta { font-size: 13px; margin-top: 4px; }
        @media (max-width: 960px) { .layout { flex-direction: column; } .sidebar { width: auto; } .scanner-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Ogrenci Paneli</div>
            <div class="muted">{{ $ogrenci->name ?? 'Ogrenci' }}</div>
            <a href="/ogrenci" class="sidebar-link"><div><span>Anasayfa</span><br><small>Diger kartlar</small></div><span>></span></a>
           
            <a href="/ogrenci-qr-kamera.blade.php" class="sidebar-link active"><div><span>QR Kamera</span><br><small>Yoklama okut</small></div><span>></span></a>
        </aside>

        <main class="content">
            <div class="panel">
                <div class="muted">QR Kamera</div>
                <h1 style="margin:8px 0 0;">Yoklama okutma ekrani</h1>
                <div class="scanner-grid">
                    <div>
                        <div class="scanner-preview">
                            <video id="qr-video" playsinline muted></video>
                            <div class="scanner-hint"></div>
                        </div>
                        <div id="scanner-status" class="scanner-status">Kamerayi baslatip ogretmenin gosterdigi QR kodu okut.</div>
                        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;">
                            <button type="button" id="start-scan" class="btn">Kamerayi Baslat</button>
                            <button type="button" id="stop-scan" class="btn btn-danger">Kamerayi Durdur</button>
                        </div>
                    </div>
                    <div>
                        <h3 style="margin-top:0;">Aktif QR Oturumlari</h3>
                        @if($aktifQrOturumlari->count() > 0)
                            <div class="mini-list">
                                @foreach($aktifQrOturumlari as $oturum)
                                    <div class="mini-item">
                                        <strong>{{ $oturum->ders_adi }}</strong>
                                        <div class="lesson-meta muted">{{ $oturum->ders_kodu }}</div>
                                        <div class="lesson-meta muted">Tarih: {{ $oturum->tarih }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty">Uzerine acik QR yoklama oturumu yok.</div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script>
    const startButton = document.getElementById('start-scan');
    const stopButton = document.getElementById('stop-scan');
    const video = document.getElementById('qr-video');
    const statusBox = document.getElementById('scanner-status');
    let stream = null;
    let detector = null;
    let scanTimer = null;

    function setStatus(message) { statusBox.textContent = message; }

    function stopScanner() {
        if (scanTimer) { clearInterval(scanTimer); scanTimer = null; }
        if (stream) { stream.getTracks().forEach(track => track.stop()); stream = null; }
        video.srcObject = null;
        setStatus('Kamera durduruldu.');
    }

    async function startScanner() {
        if (!('BarcodeDetector' in window)) {
            setStatus('Bu tarayicida QR kamera destegi yok. Telefonunun kamera uygulamasi ile de QR acabilirsin.');
            return;
        }

        try {
            detector = detector || new BarcodeDetector({ formats: ['qr_code'] });
            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
            video.srcObject = stream;
            await video.play();
            setStatus('Kamera acildi. QR kodu cizginin icine hizala.');

            if (scanTimer) clearInterval(scanTimer);
            scanTimer = setInterval(async () => {
                try {
                    const barcodes = await detector.detect(video);
                    if (barcodes.length > 0) {
                        const code = barcodes[0].rawValue;
                        setStatus('QR bulundu: ' + code);
                        stopScanner();
                    }
                } catch (error) {
                    console.error(error);
                }
            }, 700);
        } catch (error) {
            setStatus('Kamera acilamadi. Kamera iznini kontrol et.');
        }
    }

    if (startButton && stopButton) {
        startButton.addEventListener('click', startScanner);
        stopButton.addEventListener('click', stopScanner);
    }
</script>
</html>
