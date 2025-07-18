<?php

namespace App\Helpers;

use App\Models\EproIsytihar;
use App\Models\EproKehadiran;
use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Records
{
    public static function kiraJumlah($bilangan_hari, $bilangan_jam)
    {
        $kiraJumlah = $bilangan_hari + $bilangan_jam;
        $decimal = $kiraJumlah - floor($kiraJumlah);

        if ($decimal >= 0.6) {
            $kiraJumlah += 0.4;
        }
        return $kiraJumlah;
    }

    public static function rekodPengguna()
    {
        $kehadiranQuery = EproKehadiran::query()
            ->join('epro_pengguna', 'epro_kehadiran.keh_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kursus', 'epro_kehadiran.keh_idkursus', '=', 'epro_kursus.kur_id')
            ->join('epro_tempat', 'epro_kursus.kur_idtempat', '=', 'epro_tempat.tem_id')
            ->join('epro_penganjur', 'epro_kursus.kur_idpenganjur', '=', 'epro_penganjur.pjr_id')
            ->join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->join('epro_bahagian', 'epro_pengguna.pen_idbahagian', '=', 'epro_bahagian.bah_id')
            ->select(
                'epro_kehadiran.keh_idusers as id_pengguna',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_ketpenu as kumpulan',
                'epro_bahagian.bah_ketpenu as bahagian',
                'epro_pengguna.pen_idbahagian as id_bahagian',
                'epro_kursus.kur_nama as nama_kursus',
                'epro_kursus.kur_tkhmula as tarikh_mula',
                'epro_kursus.kur_tkhtamat as tarikh_tamat',
                'epro_tempat.tem_keterangan as tempat',
                'epro_penganjur.pjr_keterangan as penganjur',
                DB::raw('CASE WHEN epro_kursus.kur_tkhmula !=  epro_kursus.kur_tkhtamat THEN COUNT(epro_kehadiran.keh_idusers) ELSE NULL END as bilangan_hari'),
                DB::raw('CASE WHEN epro_kursus.kur_tkhmula =  epro_kursus.kur_tkhtamat THEN (epro_kursus.kur_msatamat - epro_kursus.kur_msamula) / 10 ELSE NULL END as bilangan_jam')
            )
            ->groupBy(
                'epro_kehadiran.keh_idusers',
                'epro_pengguna.pen_nama',
                'epro_pengguna.pen_jawatan',
                'epro_pengguna.pen_gred',
                'epro_kumpulan.kum_ketpenu',
                'epro_bahagian.bah_ketpenu',
                'epro_pengguna.pen_idbahagian',
                'epro_kursus.kur_nama',
                'epro_kursus.kur_tkhmula',
                'epro_kursus.kur_tkhtamat',
                'epro_tempat.tem_keterangan',
                'epro_penganjur.pjr_keterangan',
                'epro_kursus.kur_bilhari',
                'epro_kursus.kur_msatamat',
                'epro_kursus.kur_msamula'
            );

        $isytiharQuery = EproIsytihar::query()
            ->where('isy_status', '4')
            ->join('epro_pengguna', 'epro_isytihar.isy_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->join('epro_bahagian', 'epro_pengguna.pen_idbahagian', '=', 'epro_bahagian.bah_id')
            ->select(
                'epro_isytihar.isy_idusers as id_pengguna',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_ketpenu as kumpulan',
                'epro_bahagian.bah_ketpenu as bahagian', // Added for consistency with kehadiranQuery
                'epro_pengguna.pen_idbahagian as id_bahagian',
                'epro_isytihar.isy_nama as nama_kursus',
                'epro_isytihar.isy_tkhmula as tarikh_mula',
                'epro_isytihar.isy_tkhtamat as tarikh_tamat',
                'epro_isytihar.isy_tempat as tempat',
                'epro_isytihar.isy_anjuran as penganjur',
                DB::raw('CASE WHEN epro_isytihar.isy_tkhmula != epro_isytihar.isy_tkhtamat THEN TIMESTAMPDIFF(DAY, epro_isytihar.isy_tkhmula, epro_isytihar.isy_tkhtamat) + 1 ELSE NULL END as bilangan_hari'),
                DB::raw('CASE WHEN epro_isytihar.isy_tkhmula = epro_isytihar.isy_tkhtamat THEN epro_isytihar.isy_jam / 10 ELSE NULL END as bilangan_jam')
            )
            ->groupBy(
                'epro_isytihar.isy_idusers',
                'epro_pengguna.pen_nama',
                'epro_pengguna.pen_jawatan',
                'epro_pengguna.pen_gred',
                'epro_kumpulan.kum_ketpenu',
                'epro_bahagian.bah_ketpenu',
                'epro_pengguna.pen_idbahagian',
                'epro_isytihar.isy_nama',
                'epro_isytihar.isy_tkhmula',
                'epro_isytihar.isy_tkhtamat',
                'epro_isytihar.isy_tempat',
                'epro_isytihar.isy_anjuran',
                'epro_isytihar.isy_jam'
            );

        $rekodKehadiran = $kehadiranQuery->get();
        $rekodIsytihar = $isytiharQuery->get();

        $rekodPengguna = collect();

        // Use a helper function for consistent mapping
        $mapRecord = function ($item) {
            return [
                'id_pengguna' => $item->id_pengguna,
                'nama' => $item->nama,
                'jawatan' => $item->jawatan,
                'gred' => $item->gred,
                'kumpulan' => $item->kumpulan,
                'bahagian' => $item->bahagian,
                'id_bahagian' => $item->id_bahagian,
                'nama_kursus' => $item->nama_kursus,
                'tarikh_mula' => $item->tarikh_mula,
                'tarikh_tamat' => $item->tarikh_tamat,
                'tempat' => $item->tempat,
                'penganjur' => $item->penganjur,
                'bilangan_jam' => (float) $item->bilangan_jam,
                'bilangan_hari' => (float) $item->bilangan_hari,
            ];
        };

        $rekodKehadiran->each(fn($item) => $rekodPengguna->push($mapRecord($item)));
        $rekodIsytihar->each(fn($item) => $rekodPengguna->push($mapRecord($item)));

        // Add users who have no course records
        $presentUserIds = $rekodPengguna->pluck('id_pengguna')->unique()->toArray();
        $missingUsers = EproPengguna::join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->join('epro_bahagian', 'epro_pengguna.pen_idbahagian', '=', 'epro_bahagian.bah_id')
            ->whereNotIn('epro_pengguna.pen_idusers', $presentUserIds)
            ->select(
                'epro_pengguna.pen_idusers as id_pengguna',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_ketpenu as kumpulan',
                'epro_bahagian.bah_ketpenu as bahagian',
                'epro_pengguna.pen_idbahagian as id_bahagian',
                DB::raw('NULL as nama_kursus'),
                DB::raw('NULL as tarikh_mula'),
                DB::raw('NULL as tarikh_tamat'),
                DB::raw('NULL as tempat'),
                DB::raw('NULL as penganjur'),
                DB::raw('NULL as bilangan_jam'),
                DB::raw('NULL as bilangan_hari')
            )
            ->get();

        $missingUsers->each(fn($item) => $rekodPengguna->push($mapRecord($item)));

        return $rekodPengguna;
    }

    public static function jumlahPermohonanPengguna($carianId, $carianTahun)
    {
        $carianId = $carianId ?? Auth::id();
        $carianTahun = $carianTahun ?? Carbon::now()->year;

        $permohonanQuery = EproPermohonan::query()
            ->select('per_status as status')
            ->where('per_idusers', $carianId)
            ->whereYear('per_tkhmohon', $carianTahun);

        $isytiharQuery = EproIsytihar::query()
            ->select('isy_status as status')
            ->where('isy_idusers', $carianId)
            ->whereYear('isy_tkhmula', $carianTahun);

        // Combine both queries using unionAll and then perform aggregations
        $jumlahPermohonanPengguna = DB::query()
            ->fromSub($permohonanQuery->unionAll($isytiharQuery), 'gabungan')
            ->selectRaw('COUNT(*) as jumlah')
            ->selectRaw('SUM(CASE WHEN status IN (1, 2) THEN 1 ELSE 0 END) as dalam_proses')
            ->selectRaw('SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as berjaya')
            ->selectRaw('SUM(CASE WHEN status IN (3, 5) THEN 1 ELSE 0 END) as tidak_berjaya')
            ->first();

        return $jumlahPermohonanPengguna;
    }

    public static function rekodBulananPengguna($carianId, $carianTahun)
    {
        $carianId = $carianId ?? Auth::id();
        $carianTahun = $carianTahun ?? Carbon::now()->year;

        // Filter by user ID and year
        $rekodKeseluruhan = static::rekodPengguna()
            ->filter(
                fn($rekod) =>
                $rekod['id_pengguna'] == $carianId &&
                    Carbon::parse($rekod['tarikh_mula'])->year == $carianTahun
            );

        // Calculate monthly totals for statistics
        $rekodBulananPengguna = array_fill(0, 12, 0);
        foreach ($rekodKeseluruhan as $item) {
            $indeksBulan = Carbon::parse($item['tarikh_mula'])->month - 1;
            $bilangan_hari = (float) ($item['bilangan_hari'] ?? 0);
            $bilangan_jam = (float) ($item['bilangan_jam'] ?? 0);

            $rekodBulananPengguna[$indeksBulan] += static::kiraJumlah($bilangan_hari, $bilangan_jam);
        }

        return $rekodBulananPengguna;
    }

    public static function jumlahRekodPengguna($carianTahun, $carianBahagian)
    {
        $jumlahRekodPengguna = static::rekodPengguna()
            ->filter(function ($item) use ($carianTahun, $carianBahagian) {
                $pass = true;

                if (!is_null($carianTahun)) {
                    $pass = $pass && (
                        $item['tarikh_mula'] === null ||
                        Carbon::parse($item['tarikh_mula'])->year == $carianTahun
                    );
                }

                if (!is_null($carianBahagian)) {
                    $pass = $pass && ($item['id_bahagian'] == $carianBahagian);
                }

                return $pass;
            })
            ->groupBy('id_pengguna')
            ->map(function ($userData) {
                $jumlah_hari = 0;
                foreach ($userData as $record) {
                    $bilangan_hari = (float) ($record['bilangan_hari'] ?? 0);
                    $bilangan_jam = (float) ($record['bilangan_jam'] ?? 0);
                    $jumlah_hari += static::kiraJumlah($bilangan_hari, $bilangan_jam);
                }
                return [
                    'nama' => $userData->first()['nama'],
                    'jawatan' => $userData->first()['jawatan'],
                    'gred' => $userData->first()['gred'],
                    'kumpulan' => $userData->first()['kumpulan'],
                    'jumlah_hari' => $jumlah_hari
                ];
            })
            ->values()
            ->all();

        return $jumlahRekodPengguna;
    }

    public static function rekodBahagian($carianTahun)
    {
        return static::prosesRekod($carianTahun, 'bahagian');
    }

    public static function rekodKumpulan($carianTahun)
    {
        return static::prosesRekod($carianTahun, 'kumpulan');
    }

    private static function prosesRekod($carianTahun, $carianLajur)
    {
        return static::rekodPengguna()
            ->filter(fn($item) => Carbon::parse($item['tarikh_mula'])->year == $carianTahun)
            ->groupBy('id_pengguna')
            ->map(function ($userData) {
                $jumlah_hari = 0;
                foreach ($userData as $record) {
                    $bilangan_hari = (float) ($record['bilangan_hari'] ?? 0);
                    $bilangan_jam = (float) ($record['bilangan_jam'] ?? 0);
                    $jumlah_hari += static::kiraJumlah($bilangan_hari, $bilangan_jam);
                }

                return [
                    'id_pengguna' => $userData->first()['id_pengguna'],
                    'bahagian' => $userData->first()['bahagian'] ?? null,
                    'kumpulan' => $userData->first()['kumpulan'] ?? null,
                    'jumlah_hari' => $jumlah_hari,
                ];
            })
            ->groupBy($carianLajur)
            ->map(function ($userData) use ($carianLajur) {
                $bins = [
                    'pengisian' => 0,
                    'hari_0' => 0,
                    'hari_1' => 0,
                    'hari_2' => 0,
                    'hari_3' => 0,
                    'hari_4' => 0,
                    'hari_5' => 0,
                    'hari_6' => 0,
                    'hari_7' => 0,
                    'hari_8_keatas' => 0,
                ];

                foreach ($userData as $item) {
                    $jumlah = $item['jumlah_hari'];
                    $bins['pengisian']++;

                    if ($jumlah < 1) {
                        $bins['hari_0']++;
                    } elseif ($jumlah < 2) {
                        $bins['hari_1']++;
                    } elseif ($jumlah < 3) {
                        $bins['hari_2']++;
                    } elseif ($jumlah < 4) {
                        $bins['hari_3']++;
                    } elseif ($jumlah < 5) {
                        $bins['hari_4']++;
                    } elseif ($jumlah < 6) {
                        $bins['hari_5']++;
                    } elseif ($jumlah < 7) {
                        $bins['hari_6']++;
                    } elseif ($jumlah < 8) {
                        $bins['hari_7']++;
                    } else {
                        $bins['hari_8_keatas']++;
                    }
                }

                return array_merge([
                    $carianLajur => $userData->first()[$carianLajur],
                ], $bins);
            })
            ->values()
            ->all();
    }
}
