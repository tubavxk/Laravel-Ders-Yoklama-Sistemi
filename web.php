<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

Route::get('/', function () {
    return view('login');
});

Route::get('/ogrenci', function () {
    if (!session()->has('user_id') || session('rol') != 'ogrenci') {
        return redirect('/');
    }

    try {
        $ogrenci = DB::table('users')
            ->where('id', session('user_id'))
            ->where('rol', 'ogrenci')
            ->first();

        if (!$ogrenci) {
            return 'Ogrenci bulunamadi';
        }

        $dersler = DB::table('ogrenci_ders')
            ->join('courses', 'ogrenci_ders.ders_id', '=', 'courses.id')
            ->leftJoin('users as ogretmen', 'courses.ogretmen_id', '=', 'ogretmen.id')
            ->where('ogrenci_ders.ogrenci_id', session('user_id'))
            ->select(
                'courses.id as ders_id',
                'courses.ders_adi',
                'courses.ders_kodu',
                'courses.gun',
                'courses.saat',
                'ogretmen.name as ogretmen_adi'
            )
            ->orderBy('courses.ders_adi')
            ->get()
            ->map(function ($ders) {
                $toplamYoklama = DB::table('attendance')
                    ->where('ogrenci_id', session('user_id'))
                    ->where('ders_id', $ders->ders_id)
                    ->count();

                $devamsizlik = DB::table('attendance')
                    ->where('ogrenci_id', session('user_id'))
                    ->where('ders_id', $ders->ders_id)
                    ->where('durum', 'yok')
                    ->count();

                $ders->toplam_yoklama = $toplamYoklama;
                $ders->devamsizlik = $devamsizlik;
                $ders->kalan_hak = max(4 - $devamsizlik, 0);
                $ders->devamsizlik_yuzdesi = $toplamYoklama > 0
                    ? round(($devamsizlik / $toplamYoklama) * 100, 1)
                    : 0;

                return $ders;
            });

        $genelToplamYoklama = $dersler->sum('toplam_yoklama');
        $genelDevamsizlik = $dersler->sum('devamsizlik');
        $genelDevamsizlikYuzdesi = $genelToplamYoklama > 0
            ? round(($genelDevamsizlik / $genelToplamYoklama) * 100, 1)
            : 0;
    } catch (\Throwable $e) {
        $ogrenci = (object) [
            'name' => 'Ogrenci',
            'email' => '',
            'rol' => 'ogrenci',
        ];
        $dersler = collect();
        $genelToplamYoklama = 0;
        $genelDevamsizlik = 0;
        $genelDevamsizlikYuzdesi = 0;
    }
    $gunuNormalizeEt = function ($metin) {
        $metin = trim((string) $metin);
        $metin = Str::ascii($metin);
        $metin = str_replace([' ', '-', '_', '.'], '', $metin);

        return strtolower($metin);
    };

    $gunEslesiyorMu = function ($dersGun, $hedefGun) use ($gunuNormalizeEt) {
        $dersGunNorm = $gunuNormalizeEt($dersGun);
        $hedefGunNorm = $gunuNormalizeEt($hedefGun);

        $aliaslar = [
            'pazartesi' => ['pazartesi', 'pzt', 'mon'],
            'sali' => ['sali', 'salı', 'sal', 'tue'],
            'carsamba' => ['carsamba', 'çarşamba', 'carsi', 'wed'],
            'persembe' => ['persembe', 'perşembe', 'per', 'thu'],
            'cuma' => ['cuma', 'fri'],
            'cumartesi' => ['cumartesi', 'cmt', 'sat'],
            'pazar' => ['pazar', 'sun'],
        ];

        foreach ($aliaslar as $gunKey => $degerler) {
            if ($hedefGunNorm === $gunKey) {
                foreach ($degerler as $deger) {
                    if (str_contains($dersGunNorm, $gunuNormalizeEt($deger))) {
                        return true;
                    }
                }
            }
        }

        return $dersGunNorm === $hedefGunNorm
            || str_contains($dersGunNorm, $hedefGunNorm)
            || str_contains($hedefGunNorm, $dersGunNorm);
    };

    $gunSirasi = ['Pazartesi', 'Sali', 'Carsamba', 'Persembe', 'Cuma'];
    $haftalikProgram = collect($gunSirasi)->mapWithKeys(function ($gun) use ($dersler, $gunEslesiyorMu) {
        return [
            $gun => $dersler
                ->filter(function ($ders) use ($gunEslesiyorMu, $gun) {
                    return $gunEslesiyorMu($ders->gun, $gun);
                })
                ->sortBy('saat')
                ->values(),
        ];
    });

    $istanbulNow = now('Europe/Istanbul');

    $gunMap = [
        1 => 'Pazartesi',
        2 => 'Sali',
        3 => 'Carsamba',
        4 => 'Persembe',
        5 => 'Cuma',
        6 => 'Cumartesi',
        7 => 'Pazar',
    ];
    $bugununGunu = $gunMap[$istanbulNow->dayOfWeekIso] ?? null;
    $bugununDersleri = $dersler
        ->filter(fn ($ders) => $gunuNormalizeEt($ders->gun) === $gunuNormalizeEt($bugununGunu))
        ->sortBy('saat')
        ->values();
    try {
        $sonYoklamalarTum = DB::table('attendance')
            ->join('courses', 'attendance.ders_id', '=', 'courses.id')
            ->where('attendance.ogrenci_id', session('user_id'))
            ->select(
                'attendance.ders_id',
                'attendance.tarih',
                'attendance.durum',
                'courses.ders_adi'
            )
            ->orderByDesc('attendance.tarih')
            ->orderByDesc('attendance.id')
            ->get();
        $seciliDersId = request('ders_id');
        $seciliDersAdi = null;
        if ($seciliDersId) {
            $seciliDers = $dersler->firstWhere('ders_id', (int) $seciliDersId);
            $seciliDersAdi = $seciliDers->ders_adi ?? null;
        }
        $sonYoklamalar = $seciliDersId
            ? $sonYoklamalarTum->where('ders_id', (int) $seciliDersId)->take(5)->values()
            : $sonYoklamalarTum->take(5)->values();
        $buHaftaKacirilanDers = DB::table('attendance')
            ->where('ogrenci_id', session('user_id'))
            ->where('durum', 'yok')
            ->whereDate('tarih', '>=', $istanbulNow->copy()->startOfWeek(Carbon::MONDAY)->toDateString())
            ->whereDate('tarih', '<=', $istanbulNow->copy()->endOfWeek(Carbon::SUNDAY)->toDateString())
            ->count();
    } catch (\Throwable $e) {
        $sonYoklamalarTum = collect();
        $seciliDersId = request('ders_id');
        $seciliDersAdi = null;
        $sonYoklamalar = collect();
        $buHaftaKacirilanDers = 0;
    }
    $toplamPlanliDers = 14;
    $devamOrani = $genelToplamYoklama > 0
        ? round((($genelToplamYoklama - $genelDevamsizlik) / $genelToplamYoklama) * 100)
        : 0;
    $hedefDevam = 90;
    $ilerlemeOrani = $toplamPlanliDers > 0
        ? min(round(($genelToplamYoklama / $toplamPlanliDers) * 100), 100)
        : 0;
    $rozetler = collect();
    if ($devamOrani >= 100 && $genelToplamYoklama > 0) {
        $rozetler->push('🥇 %100 Devam Rozeti');
    }
    if ($bugununDersleri->count() > 0 && $bugununDersleri->every(fn ($ders) => $ders->devamsizlik === 0) && $genelToplamYoklama > 0) {
        $rozetler->push('⭐ Aktif Öğrenci');
    }
    if ($genelToplamYoklama >= 10 && $genelDevamsizlik === 0) {
        $rozetler->push('🔥 10 Ders Üst Üste Katılım');
    }
    if ($rozetler->isEmpty()) {
        $rozetler->push('⭐ Aktif Öğrenci');
    }
    $kritikDers = $dersler->sortBy('kalan_hak')->first();
    $uyariTipi = 'ok';
    $uyariMesaji = 'Devamsizlik durumun su an guvenli gorunuyor.';
    try {
        $aktifQrOturumlari = DB::table('attendance_sessions')
            ->join('courses', 'attendance_sessions.ders_id', '=', 'courses.id')
            ->where('attendance_sessions.aktif', 1)
            ->whereIn('attendance_sessions.ders_id', $dersler->pluck('ders_id'))
            ->select(
                'attendance_sessions.token',
                'attendance_sessions.tarih',
                'courses.ders_adi',
                'courses.ders_kodu'
            )
            ->orderBy('courses.ders_adi')
            ->get();
    } catch (\Throwable $e) {
        $aktifQrOturumlari = collect();
    }

    if ($kritikDers && $kritikDers->kalan_hak === 0) {
        $uyariTipi = 'danger';
        $uyariMesaji = $kritikDers->ders_adi . ' dersi icin devamsizlik hakkin doldu.';
    } elseif ($kritikDers && $kritikDers->kalan_hak === 1) {
        $uyariTipi = 'warn';
        $uyariMesaji = $kritikDers->ders_adi . ' dersi icin yalnizca 1 devamsizlik hakkin kaldi.';
    }

    return view('ogrenci', [
        'ogrenci' => $ogrenci,
        'dersler' => $dersler,
        'genelToplamYoklama' => $genelToplamYoklama,
        'genelDevamsizlik' => $genelDevamsizlik,
        'genelDevamsizlikYuzdesi' => $genelDevamsizlikYuzdesi,
        'haftalikProgram' => $haftalikProgram,
        'bugununDersleri' => $bugununDersleri,
        'bugununGunu' => $bugununGunu,
        'uyariTipi' => $uyariTipi,
        'uyariMesaji' => $uyariMesaji,
        'kritikDers' => $kritikDers,
        'sonYoklamalar' => $sonYoklamalar,
        'tumSonYoklamalar' => $sonYoklamalarTum,
        'seciliDersId' => $seciliDersId,
        'seciliDersAdi' => $seciliDersAdi,
        'buHaftaKacirilanDers' => $buHaftaKacirilanDers,
        'rozetler' => $rozetler,
        'devamOrani' => $devamOrani,
        'hedefDevam' => $hedefDevam,
        'ilerlemeOrani' => $ilerlemeOrani,
        'aktifQrOturumlari' => $aktifQrOturumlari,
    ]);
});

Route::get('/ogrenci/program', function () {
    if (!session()->has('user_id') || session('rol') != 'ogrenci') {
        return redirect('/');
    }

    $ogrenci = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogrenci')
        ->first();

    if (!$ogrenci) {
        return 'Ogrenci bulunamadi';
    }

    $dersler = DB::table('ogrenci_ders')
        ->join('courses', 'ogrenci_ders.ders_id', '=', 'courses.id')
        ->leftJoin('users as ogretmen', 'courses.ogretmen_id', '=', 'ogretmen.id')
        ->where('ogrenci_ders.ogrenci_id', session('user_id'))
        ->select(
            'courses.id as ders_id',
            'courses.ders_adi',
            'courses.ders_kodu',
            'courses.gun',
            'courses.saat',
            'ogretmen.name as ogretmen_adi'
        )
        ->orderBy('courses.ders_adi')
        ->get()
        ->map(function ($ders) {
            $toplamYoklama = DB::table('attendance')
                ->where('ogrenci_id', session('user_id'))
                ->where('ders_id', $ders->ders_id)
                ->count();

            $devamsizlik = DB::table('attendance')
                ->where('ogrenci_id', session('user_id'))
                ->where('ders_id', $ders->ders_id)
                ->where('durum', 'yok')
                ->count();

            $ders->toplam_yoklama = $toplamYoklama;
            $ders->devamsizlik = $devamsizlik;
            $ders->kalan_hak = max(4 - $devamsizlik, 0);
            $ders->devamsizlik_yuzdesi = $toplamYoklama > 0
                ? round(($devamsizlik / $toplamYoklama) * 100, 1)
                : 0;

            return $ders;
        });

    $gunuNormalizeEt = function ($metin) {
        $metin = trim((string) $metin);
        $metin = str_replace(
            ['Ã‡', 'Ã§', 'Ä', 'ÄŸ', 'I', 'Ä±', 'Ä°', 'i', 'Ã–', 'Ã¶', 'Å', 'ÅŸ', 'Ãœ', 'Ã¼'],
            ['C', 'c', 'G', 'g', 'I', 'i', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u'],
            $metin
        );

        return strtolower($metin);
    };

    $gunSirasi = ['Pazartesi', 'Sali', 'Carsamba', 'Persembe', 'Cuma'];
    $haftalikProgram = collect($gunSirasi)->mapWithKeys(fn ($gun) => [$gun => collect()]);
    $eslesenDersIds = collect();

    foreach ($dersler as $ders) {
        $bulunanGun = null;
        foreach ($gunSirasi as $gun) {
            if ($gunuNormalizeEt($ders->gun) === $gunuNormalizeEt($gun)
                || str_contains($gunuNormalizeEt($ders->gun), $gunuNormalizeEt($gun))
                || str_contains($gunuNormalizeEt($gun), $gunuNormalizeEt($ders->gun))) {
                $bulunanGun = $gun;
                break;
            }
        }

        if (!$bulunanGun) {
            $sira = $eslesenDersIds->count() % count($gunSirasi);
            $bulunanGun = $gunSirasi[$sira];
        }

        $haftalikProgram[$bulunanGun]->push($ders);
        $eslesenDersIds->push($ders->ders_id);
    }

    $haftalikProgram = $haftalikProgram->map(fn ($items) => $items->sortBy('saat')->values());

    return view('ogrenci-program', [
        'ogrenci' => $ogrenci,
        'haftalikProgram' => $haftalikProgram,
        'dersler' => $dersler,
    ]);
});

Route::get('/ogrenci-program.blade.php', function () {
    return redirect('/ogrenci/program');
});

Route::get('/ogrenci/qr-kamera', function () {
    if (!session()->has('user_id') || session('rol') != 'ogrenci') {
        return redirect('/');
    }

    $ogrenci = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogrenci')
        ->first();

    if (!$ogrenci) {
        return 'Ogrenci bulunamadi';
    }

    $aktifQrOturumlari = DB::table('attendance_sessions')
        ->join('courses', 'attendance_sessions.ders_id', '=', 'courses.id')
        ->where('attendance_sessions.aktif', 1)
        ->select(
            'attendance_sessions.token',
            'attendance_sessions.tarih',
            'courses.ders_adi',
            'courses.ders_kodu'
        )
        ->orderBy('courses.ders_adi')
        ->get();

    return view('ogrenci-qr-kamera', [
        'ogrenci' => $ogrenci,
        'aktifQrOturumlari' => $aktifQrOturumlari,
    ]);
});

Route::get('/ogrenci-qr-kamera.blade.php', function () {
    return redirect('/ogrenci/qr-kamera');
});

Route::get('/ogrenci/profil', function () {
    if (!session()->has('user_id') || session('rol') != 'ogrenci') {
        return redirect('/');
    }

    $ogrenci = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogrenci')
        ->first();

    if (!$ogrenci) {
        return 'Ogrenci bulunamadi';
    }

    $ogrenciDersSayisi = DB::table('ogrenci_ders')
        ->where('ogrenci_id', session('user_id'))
        ->count();

    $toplamYoklama = DB::table('attendance')
        ->where('ogrenci_id', session('user_id'))
        ->count();

    $devamsizYoklama = DB::table('attendance')
        ->where('ogrenci_id', session('user_id'))
        ->where('durum', 'yok')
        ->count();

    return view('ogrenci-profil', [
        'ogrenci' => $ogrenci,
        'ogrenciDersSayisi' => $ogrenciDersSayisi,
        'toplamYoklama' => $toplamYoklama,
        'devamsizYoklama' => $devamsizYoklama,
        'dersler' => DB::table('ogrenci_ders')
            ->join('courses', 'ogrenci_ders.ders_id', '=', 'courses.id')
            ->leftJoin('users as ogretmen', 'courses.ogretmen_id', '=', 'ogretmen.id')
            ->where('ogrenci_ders.ogrenci_id', session('user_id'))
            ->select(
                'courses.id as ders_id',
                'courses.ders_adi',
                'courses.ders_kodu',
                'courses.gun',
                'courses.saat',
                'ogretmen.name as ogretmen_adi'
            )
            ->orderBy('courses.ders_adi')
            ->get(),
    ]);
});

Route::get('/ogrenci-profil.blade.php', function () {
    return redirect('/ogrenci/profil');
});

Route::get('/ogrenci/grafikler', function () {
    if (!session()->has('user_id') || session('rol') != 'ogrenci') {
        return redirect('/');
    }

    $ogrenci = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogrenci')
        ->first();

    if (!$ogrenci) {
        return 'Ogrenci bulunamadi';
    }

    $dersler = DB::table('ogrenci_ders')
        ->join('courses', 'ogrenci_ders.ders_id', '=', 'courses.id')
        ->leftJoin('users as ogretmen', 'courses.ogretmen_id', '=', 'ogretmen.id')
        ->where('ogrenci_ders.ogrenci_id', session('user_id'))
        ->select(
            'courses.id as ders_id',
            'courses.ders_adi',
            'courses.ders_kodu',
            'courses.gun',
            'courses.saat',
            'ogretmen.name as ogretmen_adi'
        )
        ->orderBy('courses.ders_adi')
        ->get()
        ->map(function ($ders) {
            $toplamYoklama = DB::table('attendance')
                ->where('ogrenci_id', session('user_id'))
                ->where('ders_id', $ders->ders_id)
                ->count();

            $devamsizlik = DB::table('attendance')
                ->where('ogrenci_id', session('user_id'))
                ->where('ders_id', $ders->ders_id)
                ->where('durum', 'yok')
                ->count();

            $ders->toplam_yoklama = $toplamYoklama;
            $ders->devamsizlik = $devamsizlik;
            $ders->kalan_hak = max(4 - $devamsizlik, 0);
            $ders->devamsizlik_yuzdesi = $toplamYoklama > 0
                ? round(($devamsizlik / $toplamYoklama) * 100, 1)
                : 0;

            return $ders;
        });

    $genelToplamYoklama = $dersler->sum('toplam_yoklama');
    $genelDevamsizlik = $dersler->sum('devamsizlik');
    $genelDevamsizlikYuzdesi = $genelToplamYoklama > 0
        ? round(($genelDevamsizlik / $genelToplamYoklama) * 100, 1)
        : 0;

    $gunuNormalizeEt = function ($metin) {
        $metin = trim((string) $metin);
        $metin = str_replace(
            ['Ã‡', 'Ã§', 'Ä', 'ÄŸ', 'I', 'Ä±', 'Ä°', 'i', 'Ã–', 'Ã¶', 'Å', 'ÅŸ', 'Ãœ', 'Ã¼'],
            ['C', 'c', 'G', 'g', 'I', 'i', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u'],
            $metin
        );

        return strtolower($metin);
    };

    $gunSirasi = ['Pazartesi', 'Sali', 'Carsamba', 'Persembe', 'Cuma'];
    $haftalikProgram = collect($gunSirasi)->mapWithKeys(function ($gun) use ($dersler, $gunuNormalizeEt) {
        return [
            $gun => $dersler
                ->filter(fn ($ders) => $gunuNormalizeEt($ders->gun) === $gunuNormalizeEt($gun))
                ->sortBy('saat')
                ->values(),
        ];
    });

    return view('ogrenci-grafikler', [
        'ogrenci' => $ogrenci,
        'dersler' => $dersler,
        'genelToplamYoklama' => $genelToplamYoklama,
        'genelDevamsizlik' => $genelDevamsizlik,
        'genelDevamsizlikYuzdesi' => $genelDevamsizlikYuzdesi,
        'haftalikProgram' => $haftalikProgram,
        'enCokDevamsizlikYapanDersler' => $dersler->sortByDesc('devamsizlik')->take(3)->values(),
        'enYuksekKatilimDersler' => $dersler->sortByDesc(function ($ders) {
            return $ders->toplam_yoklama > 0
                ? ($ders->toplam_yoklama - $ders->devamsizlik) / $ders->toplam_yoklama
                : 0;
        })->take(3)->values(),
    ]);
});

Route::get('/ogrenci-grafikler.blade.php', function () {
    return redirect('/ogrenci/grafikler');
});

Route::get('/ogretmen', function () {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    try {
        $ogretmen = DB::table('users')
            ->where('id', session('user_id'))
            ->where('rol', 'ogretmen')
            ->first();

        if (!$ogretmen) {
            return 'Ogretmen bulunamadi';
        }

        $dersler = DB::table('courses')
            ->where('ogretmen_id', session('user_id'))
            ->orderBy('ders_adi')
            ->get();

        $dersOzetleri = $dersler->map(function ($ders) {
            $ders->ogrenci_sayisi = DB::table('ogrenci_ders')->where('ders_id', $ders->id)->count();
            $ders->yoklama_sayisi = DB::table('attendance')->where('ders_id', $ders->id)->distinct('tarih')->count('tarih');
            $ders->devamsiz_ogrenci_sayisi = DB::table('attendance')->where('ders_id', $ders->id)->where('durum', 'yok')->distinct('ogrenci_id')->count('ogrenci_id');
            return $ders;
        });

        $istanbulNow = now('Europe/Istanbul');
        $gunMap = [1 => 'Pazartesi', 2 => 'Sali', 3 => 'Carsamba', 4 => 'Persembe', 5 => 'Cuma', 6 => 'Cumartesi', 7 => 'Pazar'];
        $bugununGunu = $gunMap[$istanbulNow->dayOfWeekIso] ?? null;

        $normalize = function ($metin) {
            $metin = trim((string) $metin);
            $metin = strtr($metin, [
                'Ç' => 'C', 'ç' => 'c',
                'Ğ' => 'G', 'ğ' => 'g',
                'İ' => 'I', 'ı' => 'i',
                'Ö' => 'O', 'ö' => 'o',
                'Ş' => 'S', 'ş' => 's',
                'Ü' => 'U', 'ü' => 'u',
            ]);
            return strtolower($metin);
        };

        $bugununDersleri = $dersOzetleri
            ->filter(fn ($ders) => $normalize($ders->gun) === $normalize($bugununGunu))
            ->sortBy('saat')
            ->values();

        $aktifOturumlar = DB::table('attendance_sessions')
            ->join('courses', 'attendance_sessions.ders_id', '=', 'courses.id')
            ->where('attendance_sessions.ogretmen_id', session('user_id'))
            ->where('attendance_sessions.aktif', 1)
            ->select('attendance_sessions.id', 'attendance_sessions.token', 'attendance_sessions.tarih', 'courses.ders_adi', 'courses.ders_kodu')
            ->latest('attendance_sessions.id')
            ->get();

        $toplamOgrenci = $dersOzetleri->sum('ogrenci_sayisi');
        $toplamYoklamaGunu = $dersOzetleri->sum('yoklama_sayisi');
        $toplamRiskliOgrenci = $dersOzetleri->sum('devamsiz_ogrenci_sayisi');

        $haftalikKatilim = collect([
            ['gun' => 'Pazartesi', 'oran' => 90],
            ['gun' => 'Sali', 'oran' => 85],
            ['gun' => 'Carsamba', 'oran' => 95],
            ['gun' => 'Persembe', 'oran' => 70],
            ['gun' => 'Cuma', 'oran' => 88],
        ]);

        $riskliOgrenciler = DB::table('attendance')
            ->join('users', 'attendance.ogrenci_id', '=', 'users.id')
            ->where('attendance.durum', 'yok')
            ->whereIn('attendance.ders_id', $dersOzetleri->pluck('id'))
            ->select('users.name', DB::raw('COUNT(*) as devamsizlik'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('devamsizlik')
            ->limit(5)
            ->get()
            ->map(fn ($ogrenci) => ['ad' => $ogrenci->name, 'oran' => min(100, (int) $ogrenci->devamsizlik * 7)]);

        $sonYoklamalar = DB::table('attendance')
            ->join('courses', 'attendance.ders_id', '=', 'courses.id')
            ->select('courses.ders_adi', 'attendance.tarih', 'attendance.durum')
            ->whereIn('attendance.ders_id', $dersOzetleri->pluck('id'))
            ->orderByDesc('attendance.tarih')
            ->limit(5)
            ->get();

        $haftalikProgramVeri = $dersOzetleri->sortBy('saat')->take(5)->values()->map(function ($ders) {
            return [
                'gun' => $ders->gun,
                'saat' => $ders->saat,
                'ders_adi' => $ders->ders_adi,
            ];
        });

        $enYuksekKatilimliDersler = $dersOzetleri->sortByDesc('ogrenci_sayisi')->take(5)->values()->map(function ($ders, $index) {
            return [
                'sira' => $index + 1,
                'ad' => $ders->ders_adi,
                'oran' => max(60, 95 - ($index * 4)),
            ];
        });

        $bildirimler = collect();
        if ($bugununDersleri->count() > 0) {
            $bildirimler->push("Bugun {$bugununDersleri->first()->saat}'da {$bugununDersleri->first()->ders_adi} dersi var.");
        }
        if ($toplamRiskliOgrenci > 0) {
            $bildirimler->push("{$toplamRiskliOgrenci} ogrencinin devamsizligi kritik seviyeye ulasti.");
        }
        if ($aktifOturumlar->count() > 0) {
            $bildirimler->push('Aktif QR yoklama oturumlari devam ediyor.');
        }
        if ($bildirimler->isEmpty()) {
            $bildirimler->push('Henuz yeni bildirim yok.');
        }

        return view('ogretmen', [
            'ogretmen' => $ogretmen,
            'dersler' => $dersOzetleri,
            'seciliDers' => null,
            'seciliTarih' => $istanbulNow->format('Y-m-d'),
            'ogrenciler' => collect(),
            'aktifQrOturumu' => null,
            'aktifOturumlar' => $aktifOturumlar,
            'bugununDersleri' => $bugununDersleri,
            'bugununGunu' => $bugununGunu,
            'toplamOgrenci' => $toplamOgrenci,
            'toplamYoklamaGunu' => $toplamYoklamaGunu,
            'toplamRiskliOgrenci' => $toplamRiskliOgrenci,
            'haftalikKatilim' => $haftalikKatilim,
            'riskliOgrenciler' => $riskliOgrenciler,
            'sonYoklamalar' => $sonYoklamalar,
            'haftalikProgramVeri' => $haftalikProgramVeri,
            'enYuksekKatilimliDersler' => $enYuksekKatilimliDersler,
            'bildirimler' => $bildirimler,
            'seciliDersToplamDersSayisi' => 0,
            'seciliDersGelenSayisi' => 0,
            'seciliDersGelmeyenSayisi' => 0,
            'seciliDersKalanSayisi' => 0,
        ]);
    } catch (\Throwable $e) {
        report($e);
        return response('Ogretmen paneli gecici olarak acilamadi.', 500);
    }
});

Route::get('/ogretmen/profilim', function () {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $ogretmen = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogretmen')
        ->first();

    if (!$ogretmen) {
        return 'Ogretmen bulunamadi';
    }

    return view('ogretmen-profilim', compact('ogretmen'));
});

Route::post('/ogretmen/profilim', function (Request $request) {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'unvan' => ['nullable', 'string', 'max:255'],
        'calistigi_okul' => ['nullable', 'string', 'max:255'],
        'mezun_oldugu_okul' => ['nullable', 'string', 'max:255'],
        'bolum' => ['nullable', 'string', 'max:255'],
    ]);

    DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogretmen')
        ->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'unvan' => $validated['unvan'] ?? null,
            'calistigi_okul' => $validated['calistigi_okul'] ?? null,
            'mezun_oldugu_okul' => $validated['mezun_oldugu_okul'] ?? null,
            'bolum' => $validated['bolum'] ?? null,
            'updated_at' => now(),
        ]);

    return redirect('/ogretmen/profilim')->with('success', 'Profil bilgileriniz kaydedildi.');
});

Route::get('/ogretmen/derslerim', function () {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $ogretmen = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogretmen')
        ->first();

    if (!$ogretmen) {
        return 'Ogretmen bulunamadi';
    }

    $dersler = DB::table('courses')
        ->where('ogretmen_id', session('user_id'))
        ->orderBy('ders_adi')
        ->get()
        ->map(function ($ders) {
            $ders->ogrenci_sayisi = DB::table('ogrenci_ders')
                ->where('ders_id', $ders->id)
                ->count();

            $ders->toplam_ders_sayisi = DB::table('attendance')
                ->where('ders_id', $ders->id)
                ->distinct('tarih')
                ->count('tarih');

            $ders->devamsiz_ogrenci_sayisi = DB::table('attendance')
                ->where('ders_id', $ders->id)
                ->where('durum', 'yok')
                ->distinct('ogrenci_id')
                ->count('ogrenci_id');

            $ders->kalan_ogrenci_sayisi = DB::table('attendance')
                ->select('ogrenci_id')
                ->where('ders_id', $ders->id)
                ->where('durum', 'yok')
                ->groupBy('ogrenci_id')
                ->havingRaw('COUNT(*) >= 5')
                ->count();

            return $ders;
        });

    return view('ogretmen-derslerim', [
        'ogretmen' => $ogretmen,
        'dersler' => $dersler,
    ]);
});

Route::get('/ogretmen/yoklama', function () {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $ogretmen = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogretmen')
        ->first();

    if (!$ogretmen) {
        return 'Ogretmen bulunamadi';
    }

    $dersler = DB::table('courses')
        ->where('ogretmen_id', session('user_id'))
        ->orderBy('ders_adi')
        ->get();

    $gunuNormalizeEt = function ($metin) {
        $metin = trim((string) $metin);
        $metin = str_replace(
            ['ÃƒÆ’Ã¢â‚¬Â¡', 'ÃƒÆ’Ã‚Â§', 'Ãƒâ€Ã‚Â', 'Ãƒâ€Ã…Â¸', 'I', 'Ãƒâ€Ã‚Â±', 'Ãƒâ€Ã‚Â°', 'i', 'ÃƒÆ’Ã¢â‚¬â€œ', 'ÃƒÆ’Ã‚Â¶', 'Ãƒâ€¦Ã‚Â', 'Ãƒâ€¦Ã…Â¸', 'ÃƒÆ’Ã…â€œ', 'ÃƒÆ’Ã‚Â¼'],
            ['C', 'c', 'G', 'g', 'I', 'i', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u'],
            $metin
        );

        return strtolower($metin);
    };

    $seciliDersId = request('ders_id');
    $istanbulNow = now('Europe/Istanbul');
    $seciliTarih = request('tarih', $istanbulNow->format('Y-m-d'));
    $seciliDers = null;
    $ogrenciler = collect();
    $aktifQrOturumu = null;
    $seciliDersToplamDersSayisi = 0;
    $seciliDersGelenSayisi = 0;
    $seciliDersGelmeyenSayisi = 0;
    $seciliDersKalanSayisi = 0;

    if ($seciliDersId) {
        $seciliDers = DB::table('courses')
            ->where('id', $seciliDersId)
            ->where('ogretmen_id', session('user_id'))
            ->first();

        if ($seciliDers) {
            $seciliDersToplamDersSayisi = DB::table('attendance')
                ->where('ders_id', $seciliDersId)
                ->distinct('tarih')
                ->count('tarih');

            $aktifQrOturumu = DB::table('attendance_sessions')
                ->where('ders_id', $seciliDersId)
                ->where('ogretmen_id', session('user_id'))
                ->where('tarih', $seciliTarih)
                ->where('aktif', 1)
                ->latest('id')
                ->first();

            $ogrenciler = DB::table('ogrenci_ders')
                ->join('users', 'ogrenci_ders.ogrenci_id', '=', 'users.id')
                ->leftJoin('attendance', function ($join) use ($seciliDersId, $seciliTarih) {
                    $join->on('attendance.ogrenci_id', '=', 'users.id')
                        ->where('attendance.ders_id', '=', $seciliDersId)
                        ->whereDate('attendance.tarih', '=', $seciliTarih);
                })
                ->where('ogrenci_ders.ders_id', $seciliDersId)
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'attendance.durum as mevcut_durum'
                )
                ->orderBy('users.name')
                ->get()
                ->map(function ($ogrenci) use ($seciliDersId) {
                    $ogrenci->devamsizlik_sayisi = DB::table('attendance')
                        ->where('ogrenci_id', $ogrenci->id)
                        ->where('ders_id', $seciliDersId)
                        ->where('durum', 'yok')
                        ->count();

                    $ogrenci->kaldi = $ogrenci->devamsizlik_sayisi >= 5;
                    $ogrenci->bugunku_durum = $ogrenci->mevcut_durum ?? 'bekliyor';

                    return $ogrenci;
                });

            $seciliDersGelenSayisi = $ogrenciler->where('bugunku_durum', 'var')->count();
            $seciliDersGelmeyenSayisi = $ogrenciler->where('bugunku_durum', 'yok')->count();
            $seciliDersKalanSayisi = $ogrenciler->where('kaldi', true)->count();
        }
    }

    return view('ogretmen-yoklama', [
        'ogretmen' => $ogretmen,
        'dersler' => $dersler,
        'seciliDersId' => $seciliDersId,
        'seciliTarih' => $seciliTarih,
        'seciliDers' => $seciliDers,
        'ogrenciler' => $ogrenciler,
        'aktifQrOturumu' => $aktifQrOturumu,
        'seciliDersToplamDersSayisi' => $seciliDersToplamDersSayisi,
        'seciliDersGelenSayisi' => $seciliDersGelenSayisi,
        'seciliDersGelmeyenSayisi' => $seciliDersGelmeyenSayisi,
        'seciliDersKalanSayisi' => $seciliDersKalanSayisi,
    ]);
});

Route::get('/ogretmen/grafikler', function () {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $ogretmen = DB::table('users')
        ->where('id', session('user_id'))
        ->where('rol', 'ogretmen')
        ->first();

    if (!$ogretmen) {
        return 'Ogretmen bulunamadi';
    }

    $dersler = DB::table('courses')
        ->where('ogretmen_id', session('user_id'))
        ->orderBy('ders_adi')
        ->get()
        ->map(function ($ders) {
            $ders->ogrenci_sayisi = DB::table('ogrenci_ders')
                ->where('ders_id', $ders->id)
                ->count();

            $ders->devamsiz_ogrenci_sayisi = DB::table('attendance')
                ->where('ders_id', $ders->id)
                ->where('durum', 'yok')
                ->distinct('ogrenci_id')
                ->count('ogrenci_id');

            return $ders;
        });

    $seciliDersId = request('ders_id', $dersler->first()->id ?? null);
    $seciliDers = null;
    $ogrenciKatilimlari = collect();
    $enCokKatilim = collect();

    if ($seciliDersId) {
        $seciliDers = $dersler->firstWhere('id', (int) $seciliDersId);
        if ($seciliDers) {
            $ogrenciKatilimlari = DB::table('ogrenci_ders')
                ->join('users', 'ogrenci_ders.ogrenci_id', '=', 'users.id')
                ->leftJoin('attendance', function ($join) use ($seciliDersId) {
                    $join->on('attendance.ogrenci_id', '=', 'users.id')
                        ->where('attendance.ders_id', '=', $seciliDersId);
                })
                ->where('ogrenci_ders.ders_id', $seciliDersId)
                ->select(
                    'users.id',
                    'users.name',
                    DB::raw('COUNT(attendance.id) as toplam_yoklama'),
                    DB::raw('SUM(CASE WHEN attendance.durum = "var" THEN 1 ELSE 0 END) as var_sayisi'),
                    DB::raw('SUM(CASE WHEN attendance.durum = "yok" THEN 1 ELSE 0 END) as yok_sayisi')
                )
                ->groupBy('users.id', 'users.name')
                ->get()
                ->map(function ($ogrenci) {
                    $toplam = (int) $ogrenci->toplam_yoklama;
                    $var = (int) $ogrenci->var_sayisi;
                    $yuzde = $toplam > 0 ? round(($var / $toplam) * 100, 1) : 0;

                    return [
                        'ad' => $ogrenci->name,
                        'oran' => $yuzde,
                        'var' => $var,
                        'yok' => (int) $ogrenci->yok_sayisi,
                    ];
                })
                ->sortByDesc('oran')
                ->values();

            $enCokKatilim = $ogrenciKatilimlari->take(5)->values();
        }
    }

    $sonYediGunTarihleri = collect(range(6, 0))->map(function ($gunSayisi) {
        return Carbon::now('Europe/Istanbul')->subDays($gunSayisi)->startOfDay();
    });

    $haftalikKatilimKaynak = DB::table('attendance')
        ->join('courses', 'attendance.ders_id', '=', 'courses.id')
        ->where('courses.ogretmen_id', session('user_id'))
        ->where('attendance.durum', 'var')
        ->whereBetween('attendance.tarih', [
            $sonYediGunTarihleri->first()->toDateString(),
            $sonYediGunTarihleri->last()->toDateString(),
        ])
        ->select(DB::raw('DATE(attendance.tarih) as tarih_gun'), DB::raw('COUNT(*) as toplam'))
        ->groupBy(DB::raw('DATE(attendance.tarih)'))
        ->get()
        ->mapWithKeys(function ($satir) {
            return [(string) $satir->tarih_gun => (int) $satir->toplam];
        });

    $haftalikToplam = max(1, array_sum($haftalikKatilimKaynak->all()));

    $haftalikKatilim = $sonYediGunTarihleri->map(function (Carbon $tarih) use ($haftalikKatilimKaynak, $haftalikToplam) {
        $tarihKey = $tarih->toDateString();
        $adet = (int) ($haftalikKatilimKaynak[$tarihKey] ?? 0);

        return [
            'gun' => $tarih->locale('tr')->translatedFormat('d M'),
            'tarih' => $tarihKey,
            'gun_adi' => $tarih->locale('tr')->translatedFormat('l'),
            'oran' => round(($adet / $haftalikToplam) * 100, 1),
            'adet' => $adet,
        ];
    });

    $toplamDevamsizlik = DB::table('attendance')
        ->join('courses', 'attendance.ders_id', '=', 'courses.id')
        ->where('courses.ogretmen_id', session('user_id'))
        ->where('attendance.durum', 'yok')
        ->count();

    $riskliOgrenciler = DB::table('attendance')
        ->join('users', 'attendance.ogrenci_id', '=', 'users.id')
        ->where('attendance.durum', 'yok')
        ->whereIn('attendance.ders_id', $dersler->pluck('id'))
        ->select('users.name', DB::raw('COUNT(*) as devamsizlik'))
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('devamsizlik')
        ->limit(5)
        ->get()
        ->map(fn ($ogrenci) => [
            'ad' => $ogrenci->name,
            'oran' => min(100, (int) $ogrenci->devamsizlik * 7),
        ]);

    $sonYoklamalar = DB::table('attendance')
        ->join('courses', 'attendance.ders_id', '=', 'courses.id')
        ->select('courses.ders_adi', 'attendance.tarih', 'attendance.durum')
        ->whereIn('attendance.ders_id', $dersler->pluck('id'))
        ->orderByDesc('attendance.tarih')
        ->limit(7)
        ->get();

    $enYuksekKatilimliDersler = $dersler
        ->sortByDesc('ogrenci_sayisi')
        ->take(5)
        ->values()
        ->map(function ($ders, $index) {
            $toplamKatilim = DB::table('attendance')
                ->where('ders_id', $ders->id)
                ->where('durum', 'var')
                ->count();

            return [
                'sira' => $index + 1,
                'ad' => $ders->ders_adi,
                'ogrenci_sayisi' => (int) $ders->ogrenci_sayisi,
                'toplam' => $toplamKatilim,
                'detay' => $toplamKatilim . ' toplam katılım, ' . (int) $ders->ogrenci_sayisi . ' öğrenci',
            ];
        });

    return view('ogretmen-grafikler', [
        'ogretmen' => $ogretmen,
        'dersler' => $dersler,
        'seciliDersId' => $seciliDersId,
        'seciliDers' => $seciliDers,
        'ogrenciKatilimlari' => $ogrenciKatilimlari,
        'enCokKatilim' => $enCokKatilim,
        'haftalikKatilim' => $haftalikKatilim,
        'toplamDevamsizlik' => $toplamDevamsizlik,
        'riskliOgrenciler' => $riskliOgrenciler,
        'sonYoklamalar' => $sonYoklamalar,
        'enYuksekKatilimliDersler' => $enYuksekKatilimliDersler,
    ]);
});

Route::get('/admin', function () {
    $rolSayilari = DB::table('users')
        ->select('rol', DB::raw('COUNT(*) as sayi'))
        ->groupBy('rol')
        ->pluck('sayi', 'rol');

    $istatistikler = [
        'toplam_kullanici' => DB::table('users')->count(),
        'toplam_ogrenci' => $rolSayilari['ogrenci'] ?? 0,
        'toplam_ogretmen' => $rolSayilari['ogretmen'] ?? 0,
        'toplam_admin' => $rolSayilari['admin'] ?? 0,
        'toplam_ders' => DB::table('courses')->count(),
        'toplam_atama' => DB::table('ogrenci_ders')->count(),
        'aktif_qr' => DB::table('attendance_sessions')->where('aktif', 1)->count(),
        'ogretmensiz_ders' => DB::table('courses')->whereNull('ogretmen_id')->count(),
        'derssiz_ogrenci' => DB::table('users')
            ->where('rol', 'ogrenci')
            ->whereNotIn('id', function ($query) {
                $query->select('ogrenci_id')->from('ogrenci_ders');
            })
            ->count(),
        'derssiz_ogretmen' => DB::table('users')
            ->where('rol', 'ogretmen')
            ->whereNotIn('id', function ($query) {
                $query->select('ogretmen_id')
                    ->from('courses')
                    ->whereNotNull('ogretmen_id');
            })
            ->count(),
    ];

    $sonEklenenDersler = DB::table('courses')
        ->orderByDesc('id')
        ->limit(5)
        ->get();

    $haftalikGiris = [18, 24, 31, 28, 35, 42, 26];
    $dersDagilimi = [
        ['ad' => 'Mobil Programlama', 'deger' => 60],
        ['ad' => 'VeritabanÄ±', 'deger' => 35],
        ['ad' => 'Nesneye YÃ¶nelik Programlama', 'deger' => 15],
    ];
    $son30GunKullanim = [12, 14, 11, 16, 18, 15, 21, 19, 23, 18, 25, 20, 24, 26, 22, 28, 30, 27, 31, 29, 33, 35, 32, 36, 38, 34, 37, 40, 39, 41];
    $sonIslemler = [
        'Ahmet YÄ±lmaz kullanÄ±cÄ± eklendi',
        'Mobil Programlama dersi oluÅŸturuldu',
        '3 yeni atama yapÄ±ldÄ±',
        'Admin giriÅŸ yaptÄ±',
    ];
    $bugunkuDersProgrami = DB::table('courses')
        ->select('ders_adi', 'saat')
        ->whereNotNull('saat')
        ->orderBy('saat')
        ->limit(3)
        ->get();
    $enAktifOgrenciler = DB::table('users')
        ->where('rol', 'ogrenci')
        ->orderByDesc('id')
        ->limit(3)
        ->pluck('name');
    $sonGirisler = [
        ['kullanici' => 'admin', 'saat' => '14:23'],
        ['kullanici' => 'ogretmen1', 'saat' => '13:55'],
        ['kullanici' => 'ogrenci3', 'saat' => '13:42'],
    ];
    $duyurular = [
        'Yaz dÃ¶nemi ders kayÄ±tlarÄ± baÅŸlamÄ±ÅŸtÄ±r.',
        'Sistem bakÄ±m tarihi: 15 Haziran.',
    ];

    $buAyKullanici = max((int) ceil($istatistikler['toplam_kullanici'] * 0.18), 1);
    $buHaftaDers = max((int) ceil($istatistikler['toplam_ders'] * 0.25), 1);
    $tamamlananAtama = max((int) ceil($istatistikler['toplam_atama'] * 0.62), 1);
    $ortalamaDoluluk = $istatistikler['toplam_ders'] > 0
        ? min(100, (int) round(($istatistikler['toplam_atama'] / max($istatistikler['toplam_ders'], 1)) * 11))
        : 0;

    return view('admin', [
        'istatistikler' => $istatistikler,
        'sonEklenenDersler' => $sonEklenenDersler,
        'haftalikGiris' => $haftalikGiris,
        'dersDagilimi' => $dersDagilimi,
        'son30GunKullanim' => $son30GunKullanim,
        'sonIslemler' => $sonIslemler,
        'bugunkuDersProgrami' => $bugunkuDersProgrami,
        'enAktifOgrenciler' => $enAktifOgrenciler,
        'sonGirisler' => $sonGirisler,
        'duyurular' => $duyurular,
        'buAyKullanici' => $buAyKullanici,
        'buHaftaDers' => $buHaftaDers,
        'tamamlananAtama' => $tamamlananAtama,
        'ortalamaDoluluk' => $ortalamaDoluluk,
    ]);
});

Route::post('/login', function (Request $request) {
    $kullanici = DB::table('users')
        ->where('email', $request->kullanici)
        ->where('password', $request->sifre)
        ->first();

    if ($kullanici) {
        session([
            'user_id' => $kullanici->id,
            'rol' => $kullanici->rol,
            'name' => $kullanici->name,
        ]);

        if ($kullanici->rol == 'admin') {
            return redirect('/admin');
        } elseif ($kullanici->rol == 'ogretmen') {
            return redirect('/ogretmen');
        } else {
            return redirect('/ogrenci');
        }
    }

    return 'Hatali giris';
});

Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

Route::get('/kullanicilar', function () {
    $kullanicilar = DB::table('users')->get();
    return view('kullanicilar', ['kullanicilar' => $kullanicilar]);
});

Route::post('/kullanici-ekle', function (Request $request) {
    DB::table('users')->insert([
        'name' => $request->ad,
        'email' => $request->email,
        'password' => $request->sifre,
        'rol' => $request->rol,
    ]);

    return redirect('/kullanicilar');
});

Route::get('/kullanici-sil/{id}', function ($id) {
    DB::table('users')->where('id', $id)->delete();
    return redirect('/kullanicilar');
});

Route::get('/dersler', function () {
    $dersler = DB::table('courses')->get();
    $sonEklenenDersler = DB::table('courses')
        ->orderByDesc('id')
        ->limit(5)
        ->get();
    $bugunkuDersProgrami = DB::table('courses')
        ->select('ders_adi', 'saat')
        ->whereNotNull('saat')
        ->orderBy('saat')
        ->limit(3)
        ->get();

    return view('dersler', [
        'dersler' => $dersler,
        'sonEklenenDersler' => $sonEklenenDersler,
        'bugunkuDersProgrami' => $bugunkuDersProgrami,
    ]);
});

Route::post('/ders-ekle', function (Request $request) {
    DB::table('courses')->insert([
        'ders_adi' => $request->ders_adi,
        'ders_kodu' => $request->ders_kodu,
        'gun' => $request->gun,
        'saat' => $request->saat,
    ]);

    return redirect('/dersler');
});

Route::get('/ders-sil/{id}', function ($id) {
    DB::table('courses')->where('id', $id)->delete();
    return redirect('/dersler');
});

Route::get('/ders-atama', function () {
    $dersler = DB::table('courses')->get();
    $ogretmenler = DB::table('users')->where('rol', 'ogretmen')->get();
    $ogrenciler = DB::table('users')->where('rol', 'ogrenci')->get();

    $atananOgretmenler = DB::table('courses')
        ->leftJoin('users', 'courses.ogretmen_id', '=', 'users.id')
        ->select('courses.id as ders_id', 'courses.ders_adi', 'users.name as ogretmen_adi')
        ->whereNotNull('courses.ogretmen_id')
        ->get();

    $atananOgrenciler = DB::table('ogrenci_ders')
        ->join('users', 'ogrenci_ders.ogrenci_id', '=', 'users.id')
        ->join('courses', 'ogrenci_ders.ders_id', '=', 'courses.id')
        ->select('ogrenci_ders.id', 'users.name as ogrenci_adi', 'courses.ders_adi')
        ->get();

    $atanmamisOgretmenler = DB::table('users')
        ->where('rol', 'ogretmen')
        ->whereNotIn('id', function ($query) {
            $query->select('ogretmen_id')
                ->from('courses')
                ->whereNotNull('ogretmen_id');
        })
        ->get();

    $atanmamisOgrenciler = DB::table('users')
        ->where('rol', 'ogrenci')
        ->whereNotIn('id', function ($query) {
            $query->select('ogrenci_id')
                ->from('ogrenci_ders');
        })
        ->get();

    return view('ders_atama', compact(
        'dersler',
        'ogretmenler',
        'ogrenciler',
        'atananOgretmenler',
        'atananOgrenciler',
        'atanmamisOgretmenler',
        'atanmamisOgrenciler'
    ));
});

Route::post('/ogretmen-ata', function (Request $request) {
    DB::table('courses')
        ->where('id', $request->ders_id)
        ->update([
            'ogretmen_id' => $request->ogretmen_id,
        ]);

    return redirect('/ders-atama');
});

Route::post('/ogrenciye-ders-ata', function (Request $request) {
    $varMi = DB::table('ogrenci_ders')
        ->where('ogrenci_id', $request->ogrenci_id)
        ->where('ders_id', $request->ders_id)
        ->first();

    if (!$varMi) {
        DB::table('ogrenci_ders')->insert([
            'ogrenci_id' => $request->ogrenci_id,
            'ders_id' => $request->ders_id,
        ]);
    }

    return redirect('/ders-atama');
});

Route::post('/qr-oturumu-baslat', function (Request $request) {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $ders = DB::table('courses')
        ->where('id', $request->ders_id)
        ->where('ogretmen_id', session('user_id'))
        ->first();

    if (!$ders) {
        return redirect('/ogretmen')->with('error', 'Ders bulunamadi.');
    }

    DB::table('attendance_sessions')
        ->where('ders_id', $request->ders_id)
        ->where('ogretmen_id', session('user_id'))
        ->where('aktif', 1)
        ->update([
            'aktif' => 0,
            'kapanis_zamani' => now('Europe/Istanbul'),
            'updated_at' => now('Europe/Istanbul'),
        ]);

    DB::table('attendance_sessions')->insert([
        'ogretmen_id' => session('user_id'),
        'ders_id' => $request->ders_id,
        'token' => (string) Str::uuid(),
        'tarih' => $request->tarih,
        'aktif' => 1,
        'created_at' => now('Europe/Istanbul'),
        'updated_at' => now('Europe/Istanbul'),
    ]);

    return redirect('/ogretmen?ders_id=' . $request->ders_id . '&tarih=' . $request->tarih)
        ->with('success', 'QR yoklama oturumu baslatildi.');
});

Route::post('/qr-oturumu-kapat', function (Request $request) {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $oturum = DB::table('attendance_sessions')
        ->where('id', $request->oturum_id)
        ->where('ogretmen_id', session('user_id'))
        ->where('aktif', 1)
        ->first();

    if (!$oturum) {
        return redirect('/ogretmen')->with('error', 'Aktif QR oturumu bulunamadi.');
    }

    DB::table('attendance_sessions')
        ->where('id', $oturum->id)
        ->update([
            'aktif' => 0,
            'kapanis_zamani' => now('Europe/Istanbul'),
            'updated_at' => now('Europe/Istanbul'),
        ]);

    $ogrenciIdleri = DB::table('ogrenci_ders')
        ->where('ders_id', $oturum->ders_id)
        ->pluck('ogrenci_id');

    foreach ($ogrenciIdleri as $ogrenciId) {
        $kayitVarMi = DB::table('attendance')
            ->where('ogrenci_id', $ogrenciId)
            ->where('ders_id', $oturum->ders_id)
            ->whereDate('tarih', $oturum->tarih)
            ->exists();

        if (!$kayitVarMi) {
            DB::table('attendance')->insert([
                'ogrenci_id' => $ogrenciId,
                'ders_id' => $oturum->ders_id,
                'tarih' => $oturum->tarih . ' 00:00:00',
                'durum' => 'yok',
            ]);
        }
    }

    return redirect('/ogretmen?ders_id=' . $oturum->ders_id . '&tarih=' . $oturum->tarih)
        ->with('success', 'QR yoklama kapatildi. Okutmayan ogrenciler yok yazildi.');
});

Route::get('/qr-yoklama/{token}', function ($token) {
    if (!session()->has('user_id') || session('rol') != 'ogrenci') {
        return redirect('/');
    }

    $oturum = DB::table('attendance_sessions')
        ->where('token', $token)
        ->where('aktif', 1)
        ->first();

    if (!$oturum) {
        return redirect('/ogrenci')->with('error', 'Bu QR oturumu aktif degil.');
    }

    $ogrenciDersteVarMi = DB::table('ogrenci_ders')
        ->where('ogrenci_id', session('user_id'))
        ->where('ders_id', $oturum->ders_id)
        ->exists();

    if (!$ogrenciDersteVarMi) {
        return redirect('/ogrenci')->with('error', 'Bu derse kayitli degilsin.');
    }

    $mevcutKayit = DB::table('attendance')
        ->where('ogrenci_id', session('user_id'))
        ->where('ders_id', $oturum->ders_id)
        ->whereDate('tarih', $oturum->tarih)
        ->first();

    if ($mevcutKayit) {
        DB::table('attendance')
            ->where('id', $mevcutKayit->id)
            ->update([
                'durum' => 'var',
                'tarih' => $oturum->tarih . ' 00:00:00',
            ]);
    } else {
        DB::table('attendance')->insert([
            'ogrenci_id' => session('user_id'),
            'ders_id' => $oturum->ders_id,
            'tarih' => $oturum->tarih . ' 00:00:00',
            'durum' => 'var',
        ]);
    }

    return redirect('/ogrenci')->with('success', 'QR okutuldu, yoklaman var olarak kaydedildi.');
});

Route::post('/yoklama-kaydet', function (Request $request) {
    if (!session()->has('user_id') || session('rol') != 'ogretmen') {
        return redirect('/');
    }

    $ders = DB::table('courses')
        ->where('id', $request->ders_id)
        ->where('ogretmen_id', session('user_id'))
        ->first();

    if (!$ders) {
        return redirect('/ogretmen');
    }

    $durumlar = $request->input('durumlar', []);

    foreach ($durumlar as $ogrenciId => $durum) {
        if (!in_array($durum, ['var', 'yok'])) {
            continue;
        }

        $ogrenciDersteVarMi = DB::table('ogrenci_ders')
            ->where('ogrenci_id', $ogrenciId)
            ->where('ders_id', $request->ders_id)
            ->exists();

        if (!$ogrenciDersteVarMi) {
            continue;
        }

        $mevcutKayit = DB::table('attendance')
            ->where('ogrenci_id', $ogrenciId)
            ->where('ders_id', $request->ders_id)
            ->whereDate('tarih', $request->tarih)
            ->first();

        if ($mevcutKayit) {
            DB::table('attendance')
                ->where('id', $mevcutKayit->id)
                ->update([
                    'durum' => $durum,
                    'tarih' => $request->tarih . ' 00:00:00',
                ]);
        } else {
            DB::table('attendance')->insert([
                'ogrenci_id' => $ogrenciId,
                'ders_id' => $request->ders_id,
                'tarih' => $request->tarih . ' 00:00:00',
                'durum' => $durum,
            ]);
        }
    }

    return redirect('/ogretmen?ders_id=' . $request->ders_id . '&tarih=' . $request->tarih);
});

Route::get('/ogrenci-dersten-cikar/{id}', function ($id) {
    DB::table('ogrenci_ders')->where('id', $id)->delete();
    return redirect('/ders-atama');
});

Route::get('/ogretmen-dersten-cikar/{ders_id}', function ($ders_id) {
    DB::table('courses')
        ->where('id', $ders_id)
        ->update(['ogretmen_id' => null]);

    return redirect('/ders-atama');
});
