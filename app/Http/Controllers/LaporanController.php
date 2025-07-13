<?php

namespace App\Http\Controllers;

use App\Models\EproIsytihar;
use App\Models\EproKehadiran;
use App\Models\EproKursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kehadiranQuery = EproKehadiran::join('epro_pengguna', 'epro_kehadiran.keh_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kursus', 'epro_kehadiran.keh_idkursus', '=', 'epro_kursus.kur_id')
            ->select(
                'epro_kehadiran.keh_idusers as user_id',
                'epro_pengguna.pen_nama',
                'epro_kursus.kur_nama',
                DB::raw('
                CASE 
                    WHEN epro_kursus.kur_tkhmula = epro_kursus.kur_tkhtamat 
                    THEN (epro_kursus.kur_msatamat - epro_kursus.kur_msamula) / 10 
                    ELSE COUNT(epro_kehadiran.keh_tkhmasuk)
                END as total_kehadiran
            ')
            )
            ->groupBy(
                'epro_kehadiran.keh_idusers',
                'epro_pengguna.pen_nama',
                'epro_kursus.kur_nama',
                'epro_kursus.kur_tkhmula',
                'epro_kursus.kur_tkhtamat',
                'epro_kursus.kur_msatamat',
                'epro_kursus.kur_msamula'
            );

        if ($search) {
            $kehadiranQuery->where('epro_pengguna.pen_nama', 'like', '%' . $search . '%');
        }

        $kehadiran = $kehadiranQuery->get();

        $isytiharQuery = EproIsytihar::join('epro_pengguna', 'epro_isytihar.isy_idusers', '=', 'epro_pengguna.pen_idusers')
            ->select(
                'epro_isytihar.isy_idusers as user_id',
                'epro_pengguna.pen_nama',
                DB::raw('
                CASE
                    WHEN epro_isytihar.isy_tkhmula = epro_isytihar.isy_tkhtamat 
                    THEN epro_isytihar.isy_jam / 10
                    ELSE TIMESTAMPDIFF(DAY, epro_isytihar.isy_tkhmula, epro_isytihar.isy_tkhtamat) + 1
                END as isytihar
            ')
            )
            ->groupBy(
                'epro_isytihar.isy_idusers',
                'epro_pengguna.pen_nama',
                'epro_isytihar.isy_tkhmula',
                'epro_isytihar.isy_tkhtamat',
                'epro_isytihar.isy_jam'
            );

        if ($search) {
            $isytiharQuery->where('epro_pengguna.pen_nama', 'like', '%' . $search . '%');
        }

        $isytihar = $isytiharQuery->get();

        // Combine both datasets
        $allAttendance = collect($kehadiran)
            ->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'pen_nama' => $item->pen_nama,
                    'kursus' => $item->kur_nama,
                    'total_kehadiran' => $item->total_kehadiran,
                    'isytihar' => null,
                ];
            });

        foreach ($isytihar as $item) {
            $allAttendance->push([
                'user_id' => $item->user_id,
                'pen_nama' => $item->pen_nama,
                'kursus' => null,
                'total_kehadiran' => null,
                'isytihar' => $item->isytihar,
            ]);
        }

        $groupedAttendance = $allAttendance->groupBy('user_id');

        return view('pages.laporan-individu', compact('groupedAttendance', 'search'));
    }


    public function show($id)
    {
        $kursus = EproKursus::where('kur_id', $id)->first();
        return response()->json($kursus);
    }
}
