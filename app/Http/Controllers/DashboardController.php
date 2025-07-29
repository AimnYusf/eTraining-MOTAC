<?php

namespace App\Http\Controllers;

use App\Helpers\Records;
use App\Http\Controllers\Controller;
use App\Models\EproIsytihar;
use App\Models\EproKehadiran;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $carianId = Auth::id();

        $jumlahPermohonanPengguna = Records::jumlahPermohonanPengguna($carianId, now()->year);
        $rekodBulananPengguna = Records::rekodBulananPengguna($carianId, now()->year);

        return view('pages.dashboard', compact('jumlahPermohonanPengguna', 'rekodBulananPengguna'));
    }

    private function getUserApplication($userId)
    {
        // Subquery for epro_permohonan table
        $permohonanSubquery = DB::table('epro_permohonan')
            ->selectRaw("
                COUNT(*) AS jumlah,
                SUM(CASE WHEN per_status IN (1, 2, 6, 7) THEN 1 ELSE 0 END) AS baru,
                SUM(CASE WHEN per_status IN (4, 8) THEN 1 ELSE 0 END) AS berjaya,
                SUM(CASE WHEN per_status IN (3, 5, 9) THEN 1 ELSE 0 END) AS tidak_berjaya
            ")
            ->where('per_idusers', $userId);

        // Subquery for epro_isytihar table
        $isytiharSubquery = DB::table('epro_isytihar')
            ->selectRaw("
                COUNT(*) AS jumlah,
                SUM(CASE WHEN isy_status IN (1, 2, 6, 7) THEN 1 ELSE 0 END) AS baru,
                SUM(CASE WHEN isy_status IN (4, 8) THEN 1 ELSE 0 END) AS berjaya,
                SUM(CASE WHEN isy_status IN (3, 5, 9) THEN 1 ELSE 0 END) AS tidak_berjaya
            ")
            ->where('isy_idusers', $userId);

        // Combine the two subqueries using UNION ALL and sum their results
        $combined = DB::query()
            ->selectRaw('
                SUM(jumlah) AS jumlah,
                SUM(baru) AS baru,
                SUM(berjaya) AS berjaya,
                SUM(tidak_berjaya) AS tidak_berjaya
            ')
            ->fromSub($permohonanSubquery->unionAll($isytiharSubquery), 'combined_table')
            ->first();

        return $combined;
    }

    private function getUserAttendance($userId)
    {
        // Query for attendance data ($kehadiran)
        $kehadiran = DB::table('epro_kehadiran')
            ->join('epro_kursus', 'epro_kursus.kur_id', '=', 'epro_kehadiran.keh_idkursus')
            ->selectRaw("
                epro_kursus.kur_tkhmula as tarikh,
                CASE
                    WHEN epro_kursus.kur_bilhari > 1
                    THEN epro_kursus.kur_bilhari
                    ELSE NULL
                END as bilangan_hari,
                CASE
                    WHEN epro_kursus.kur_bilhari = 1
                    THEN (epro_kursus.kur_msatamat - epro_kursus.kur_msamula) / 10
                    ELSE NULL
                END as bilangan_jam
            ")
            ->groupBy(
                'epro_kursus.kur_tkhmula',
                'epro_kursus.kur_bilhari',
                'epro_kursus.kur_msatamat',
                'epro_kursus.kur_msamula'
            );

        // Query for declaration data ($isytihar)
        $isytihar = DB::table('epro_isytihar')
            ->where('isy_status', 8)
            ->selectRaw("
                epro_isytihar.isy_tkhmula as tarikh,
                CASE
                    WHEN epro_isytihar.isy_tkhmula != epro_isytihar.isy_tkhtamat
                    THEN TIMESTAMPDIFF(DAY, epro_isytihar.isy_tkhmula, epro_isytihar.isy_tkhtamat) + 1
                    ELSE NULL
                END as bilangan_hari,
                CASE
                    WHEN epro_isytihar.isy_tkhmula = epro_isytihar.isy_tkhtamat
                    THEN epro_isytihar.isy_jam / 10
                    ELSE NULL
                END as bilangan_jam
            ")
            ->groupBy(
                'epro_isytihar.isy_tkhmula',
                'epro_isytihar.isy_tkhtamat',
                'epro_isytihar.isy_jam'
            );

        $kehadiran = $kehadiran->unionAll($isytihar)
            ->get()
            ->filter(fn($item) => Carbon::parse($item->tarikh)->year == Carbon::now()->year);

        $jumlahKehadiran = array_fill(0, 12, 0);
        foreach ($kehadiran as $item) {
            $indeksBulan = Carbon::parse($item->tarikh)->month - 1;
            $bilanganHari = (float) ($item->bilangan_hari ?? 0);
            $bilanganJam = (float) ($item->bilangan_jam ?? 0);

            $calculatedValue = ($bilanganHari ?? 0) + ($bilanganJam ?? 0);
            $decimal = $calculatedValue - floor($calculatedValue);

            if ($decimal >= 0.6) {
                $calculatedValue += 0.4;
            }

            $jumlahKehadiran[$indeksBulan] += $calculatedValue;
        }

        return $jumlahKehadiran;
    }
}
