<?php

namespace App\Helpers;

use App\Models\EproIsytihar;
use App\Models\EproKehadiran;
use App\Models\EproPengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Calculations
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
                'epro_kumpulan.kum_keterangan as kumpulan',
                'epro_bahagian.bah_ketpenu as bahagian',
                'epro_pengguna.pen_idbahagian as id_bahagian',
                'epro_kursus.kur_nama as nama_kursus',
                'epro_kursus.kur_tkhmula as tarikh_mula',
                'epro_kursus.kur_tkhtamat as tarikh_tamat',
                'epro_tempat.tem_keterangan as tempat',
                'epro_penganjur.pjr_keterangan as penganjur',
                DB::raw('CASE WHEN epro_kursus.kur_bilhari > 1 THEN COUNT(epro_kehadiran.keh_idusers) ELSE NULL END as bilangan_hari'),
                DB::raw('CASE WHEN epro_kursus.kur_bilhari = 1 THEN (epro_kursus.kur_msatamat - epro_kursus.kur_msamula) / 10 ELSE NULL END as bilangan_jam')
            )
            ->groupBy(
                'epro_kehadiran.keh_idusers',
                'epro_pengguna.pen_nama',
                'epro_pengguna.pen_jawatan',
                'epro_pengguna.pen_gred',
                'epro_kumpulan.kum_keterangan',
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
                'epro_kumpulan.kum_keterangan as kumpulan',
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
                'epro_kumpulan.kum_keterangan',
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
                'epro_kumpulan.kum_keterangan as kumpulan',
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

    public static function jumlahRekodPengguna($carianTahun, $carianBahagian)
    {
        $jumlahRekodPengguna = static::rekodPengguna()
            ->filter(function ($item) use ($carianTahun, $carianBahagian) {
                $pass = true;

                if (!is_null($carianTahun)) {
                    $pass = $pass && (Carbon::parse($item['tarikh_mula'])->year == $carianTahun);
                }

                if (!is_null($carianBahagian)) {
                    $pass = $pass && ($item['id_bahagian'] ==  $carianBahagian);
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
}
