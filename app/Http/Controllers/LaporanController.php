<?php

namespace App\Http\Controllers;

use App\Models\EproBahagian;
use App\Models\EproIsytihar;
use App\Models\EproKehadiran;
use App\Models\EproKursus;
use App\Models\EproPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    public function index(Request $request)
    {

    }

    public function getRecord()
    {
        $kehadiranQuery = EproKehadiran::join('epro_pengguna', 'epro_kehadiran.keh_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kursus', 'epro_kehadiran.keh_idkursus', '=', 'epro_kursus.kur_id')
            ->join('epro_tempat', 'epro_kursus.kur_idtempat', '=', 'epro_tempat.tem_id')
            ->join('epro_penganjur', 'epro_kursus.kur_idpenganjur', '=', 'epro_penganjur.pjr_id')
            ->join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->select(
                'epro_kehadiran.keh_idusers as user_id',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_keterangan as kumpulan',
                'epro_pengguna.pen_idbahagian as bahagian',
                'epro_kursus.kur_nama as kursus',
                'epro_kursus.kur_tkhmula as tkh_mula',
                'epro_kursus.kur_tkhtamat as tkh_tamat',
                'epro_tempat.tem_keterangan as tempat',
                'epro_penganjur.pjr_keterangan as penganjur',
                DB::raw('
            CASE 
                WHEN epro_kursus.kur_bilhari > 1
                THEN COUNT(epro_kehadiran.keh_tkhmasuk)
                ELSE NULL
            END as hari
        '),
                DB::raw('
            CASE
                WHEN epro_kursus.kur_bilhari = 1
                THEN (epro_kursus.kur_msatamat - epro_kursus.kur_msamula) / 10 
                ELSE NULL
            END as jam
        ')
            )
            ->groupBy(
                'epro_kehadiran.keh_idusers',
                'epro_pengguna.pen_nama',
                'epro_pengguna.pen_jawatan',
                'epro_pengguna.pen_gred',
                'epro_kumpulan.kum_keterangan',
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

        $kehadiran = $kehadiranQuery->get();


        $isytiharQuery = EproIsytihar::join('epro_pengguna', 'epro_isytihar.isy_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->select(
                'epro_isytihar.isy_idusers as user_id',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_keterangan as kumpulan',
                'epro_pengguna.pen_idbahagian as bahagian',
                'epro_isytihar.isy_nama as kursus',
                'epro_isytihar.isy_tkhmula as tkh_mula',
                'epro_isytihar.isy_tkhtamat as tkh_tamat',
                'epro_isytihar.isy_tempat as tempat',
                'epro_isytihar.isy_anjuran as penganjur',
                DB::raw('
                    CASE
                        WHEN epro_isytihar.isy_tkhmula = epro_isytihar.isy_tkhtamat 
                        THEN epro_isytihar.isy_jam / 10
                        ELSE NULL
                    END as jam
                '),
                DB::raw('
                    CASE
                        WHEN epro_isytihar.isy_tkhmula != epro_isytihar.isy_tkhtamat 
                        THEN TIMESTAMPDIFF(DAY, epro_isytihar.isy_tkhmula, epro_isytihar.isy_tkhtamat) + 1
                        ELSE NULL
                    END as hari
                ')
            )
            ->groupBy(
                'epro_isytihar.isy_idusers',
                'epro_pengguna.pen_nama',
                'epro_pengguna.pen_jawatan',
                'epro_pengguna.pen_gred',
                'epro_kumpulan.kum_keterangan',
                'epro_pengguna.pen_idbahagian',
                'epro_isytihar.isy_nama',
                'epro_isytihar.isy_tkhmula',
                'epro_isytihar.isy_tkhtamat',
                'epro_isytihar.isy_tempat',
                'epro_isytihar.isy_anjuran',
                'epro_isytihar.isy_jam'
            );

        $isytihar = $isytiharQuery->get();

        // Combine both datasets
        $allRecord = collect($kehadiran)
            ->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'nama' => $item->nama,
                    'jawatan' => $item->jawatan,
                    'gred' => $item->gred,
                    'kumpulan' => $item->kumpulan,
                    'bahagian' => $item->bahagian,
                    'kursus' => $item->kursus,
                    'tkh_mula' => $item->tkh_mula,
                    'tkh_tamat' => $item->tkh_tamat,
                    'tempat' => $item->tempat,
                    'penganjur' => $item->penganjur,
                    'jam' => $item->jam,
                    'hari' => $item->hari,
                ];
            });


        foreach ($isytihar as $item) {
            $allRecord->push([
                'user_id' => $item->user_id,
                'nama' => $item->nama,
                'jawatan' => $item->jawatan,
                'gred' => $item->gred,
                'kumpulan' => $item->kumpulan,
                'bahagian' => $item->bahagian,
                'kursus' => $item->kursus,
                'tkh_mula' => $item->tkh_mula,
                'tkh_tamat' => $item->tkh_tamat,
                'tempat' => $item->tempat,
                'penganjur' => $item->penganjur,
                'jam' => $item->jam,
                'hari' => $item->hari,
            ]);
        }

        $allRecord = $allRecord->groupBy('user_id');
        return $allRecord;
    }

    public function rekodKursus(Request $request)
    {
        $userId = Auth::id();
        $cariTahun = $request->input('tahun') ?? now()->year; // Default to current year

        $myRecord = $this->getRecord()->flatMap(function ($records) {
            return $records;
        });

        // Show only data of current user
        $myRecord = $myRecord->filter(function ($records) use ($userId) {
            return $records['user_id'] == $userId;
        });

        // Filter by year
        $myRecord = $myRecord->filter(function ($records) use ($cariTahun) {
            return \Carbon\Carbon::parse($records['tkh_mula'])->format('Y') == $cariTahun;
        });

        // Get statistic data
        $monthlyTotals = array_fill(0, 12, 0);
        foreach ($myRecord as $item) {
            $monthIndex = \Carbon\Carbon::parse($item['tkh_mula'])->month - 1;
            $hari = (float) ($item['hari'] ?? 0);
            $jam = (float) ($item['jam'] ?? 0);

            $monthlyTotals[$monthIndex - 1] += $hari + $jam;
            $decimal = $monthlyTotals[$monthIndex - 1] - floor($monthlyTotals[$monthIndex - 1]);
            if ($decimal >= 0.6) {
                $monthlyTotals[$monthIndex - 1] += 0.4;
            }
        }

        Log::info($myRecord->toArray());
        return view('pages.rekod-kursus', compact('myRecord', 'monthlyTotals'));
    }


    public function rekodIndividu(Request $request)
    {
        $cariBahagian = $request->input('bahagian');
        $cariTahun = $request->input('tahun') ?? now()->year; // default to current year

        $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
        $bahagian = EproBahagian::get();

        $allRecord = $this->getRecord()->flatMap(function ($records) {
            return $records;
        });

        // Filter by year (default is current year)
        $allRecord = $allRecord->filter(function ($item) use ($cariTahun) {
            return \Carbon\Carbon::parse($item['tkh_mula'])->format('Y') == $cariTahun;
        });

        // Filter by bahagian
        if ($cariBahagian) {
            $allRecord = $allRecord->filter(function ($item) use ($cariBahagian) {
                return $item['bahagian'] == $cariBahagian;
            });
        }

        // Group by user_id if needed
        $allRecord = $allRecord->groupBy('user_id');

        return view('pages.laporan-individu', compact('allRecord', 'bahagian', 'pengguna'));
    }
}
