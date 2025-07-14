<?php

namespace App\Http\Controllers;

use App\Models\EproBahagian;
use App\Models\EproIsytihar;
use App\Models\EproKehadiran;
use App\Models\EproKursus;
use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Retrieves all course records from both 'kehadiran' and 'isytihar' tables.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllRecord()
    {
        $kehadiranQuery = EproKehadiran::query()
            ->join('epro_pengguna', 'epro_kehadiran.keh_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kursus', 'epro_kehadiran.keh_idkursus', '=', 'epro_kursus.kur_id')
            ->join('epro_tempat', 'epro_kursus.kur_idtempat', '=', 'epro_tempat.tem_id')
            ->join('epro_penganjur', 'epro_kursus.kur_idpenganjur', '=', 'epro_penganjur.pjr_id')
            ->join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->select(
                'epro_kehadiran.keh_idusers as id_pengguna',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_keterangan as kumpulan',
                'epro_pengguna.pen_idbahagian as id_bahagian',
                'epro_kursus.kur_nama as nama_kursus',
                'epro_kursus.kur_tkhmula as tarikh_mula',
                'epro_kursus.kur_tkhtamat as tarikh_tamat',
                'epro_tempat.tem_keterangan as tempat',
                'epro_penganjur.pjr_keterangan as penganjur',
                DB::raw('CASE WHEN epro_kursus.kur_bilhari > 1 THEN COUNT(epro_kehadiran.keh_tkhmasuk) ELSE NULL END as bilangan_hari'),
                DB::raw('CASE WHEN epro_kursus.kur_bilhari = 1 THEN (epro_kursus.kur_msatamat - epro_kursus.kur_msamula) / 10 ELSE NULL END as bilangan_jam')
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

        $isytiharQuery = EproIsytihar::query()
            ->join('epro_pengguna', 'epro_isytihar.isy_idusers', '=', 'epro_pengguna.pen_idusers')
            ->join('epro_kumpulan', 'epro_pengguna.pen_idkumpulan', '=', 'epro_kumpulan.kum_id')
            ->select(
                'epro_isytihar.isy_idusers as id_pengguna',
                'epro_pengguna.pen_nama as nama',
                'epro_pengguna.pen_jawatan as jawatan',
                'epro_pengguna.pen_gred as gred',
                'epro_kumpulan.kum_keterangan as kumpulan',
                'epro_pengguna.pen_idbahagian as id_bahagian',
                'epro_isytihar.isy_nama as nama_kursus',
                'epro_isytihar.isy_tkhmula as tarikh_mula',
                'epro_isytihar.isy_tkhtamat as tarikh_tamat',
                'epro_isytihar.isy_tempat as tempat',
                'epro_isytihar.isy_anjuran as penganjur',
                DB::raw('CASE WHEN epro_isytihar.isy_tkhmula = epro_isytihar.isy_tkhtamat THEN epro_isytihar.isy_jam / 10 ELSE NULL END as bilangan_jam'),
                DB::raw('CASE WHEN epro_isytihar.isy_tkhmula != epro_isytihar.isy_tkhtamat THEN TIMESTAMPDIFF(DAY, epro_isytihar.isy_tkhmula, epro_isytihar.isy_tkhtamat) + 1 ELSE NULL END as bilangan_hari')
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

        $rekodKehadiran = $kehadiranQuery->get();
        $rekodIsytihar = $isytiharQuery->get();

        // Combine and standardize the data structure
        $rekodKeseluruhan = collect();

        $rekodKehadiran->map(function ($item) use ($rekodKeseluruhan) {
            $rekodKeseluruhan->push([
                'id_pengguna' => $item->id_pengguna,
                'nama' => $item->nama,
                'jawatan' => $item->jawatan,
                'gred' => $item->gred,
                'kumpulan' => $item->kumpulan,
                'id_bahagian' => $item->id_bahagian,
                'nama_kursus' => $item->nama_kursus,
                'tarikh_mula' => $item->tarikh_mula,
                'tarikh_tamat' => $item->tarikh_tamat,
                'tempat' => $item->tempat,
                'penganjur' => $item->penganjur,
                'bilangan_jam' => (float) $item->bilangan_jam,
                'bilangan_hari' => (float) $item->bilangan_hari,
            ]);
        });

        $rekodIsytihar->map(function ($item) use ($rekodKeseluruhan) {
            $rekodKeseluruhan->push([
                'id_pengguna' => $item->id_pengguna,
                'nama' => $item->nama,
                'jawatan' => $item->jawatan,
                'gred' => $item->gred,
                'kumpulan' => $item->kumpulan,
                'id_bahagian' => $item->id_bahagian,
                'nama_kursus' => $item->nama_kursus,
                'tarikh_mula' => $item->tarikh_mula,
                'tarikh_tamat' => $item->tarikh_tamat,
                'tempat' => $item->tempat,
                'penganjur' => $item->penganjur,
                'bilangan_jam' => (float) $item->bilangan_jam,
                'bilangan_hari' => (float) $item->bilangan_hari,
            ]);
        });

        return $rekodKeseluruhan->groupBy('id_pengguna');
    }

    /**
     * Calculates the total number of applications and their statuses for the authenticated user.
     *
     * @return object
     */
    private function getAllApplication($tahunCarian)
    {
        $idPengguna = Auth::id();
        $tahun = $tahunCarian ?? Carbon::now()->year;

        $permohonanUnion = EproPermohonan::query()
            ->select('per_status as status')
            ->where('per_idusers', $idPengguna)
            ->whereYear('per_tkhmohon', $tahun);

        $isytiharUnion = EproIsytihar::query()
            ->select('isy_status as status')
            ->where('isy_idusers', $idPengguna)
            ->whereYear('isy_tkhmula', $tahun);

        // Combine both queries using unionAll and then perform aggregations
        $jumlahPermohonan = DB::query()
            ->fromSub($permohonanUnion->unionAll($isytiharUnion), 'gabungan')
            ->selectRaw('COUNT(*) as jumlah')
            ->selectRaw('SUM(CASE WHEN status IN (1, 2) THEN 1 ELSE 0 END) as dalam_proses')
            ->selectRaw('SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as berjaya')
            ->selectRaw('SUM(CASE WHEN status IN (3, 5) THEN 1 ELSE 0 END) as tidak_berjaya')
            ->first();

        return $jumlahPermohonan;
    }

    /**
     * Displays the course records for the current user, filtered by year.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function rekodKursus(Request $request)
    {
        $idPengguna = Auth::id();
        $tahunCarian = $request->input('tahun') ?? Carbon::now()->year; // Default to current year

        // Flatten the collection and filter by user ID and year
        $rekodKeseluruhan = $this->getAllRecord()
            ->flatMap(fn($records) => $records) // Flatten the grouped collection
            ->filter(fn($rekod) => $rekod['id_pengguna'] == $idPengguna && Carbon::parse($rekod['tarikh_mula'])->year == $tahunCarian);

        // Calculate monthly totals for statistics
        $jumlahKursus = array_fill(0, 12, 0);
        foreach ($rekodKeseluruhan as $item) {
            $indeksBulan = Carbon::parse($item['tarikh_mula'])->month - 1; // Month is 1-indexed, array is 0-indexed
            $hari = (float) ($item['bilangan_hari'] ?? 0);
            $jam = (float) ($item['bilangan_jam'] ?? 0);

            $jumlahKursus[$indeksBulan] += $hari + $jam;

            // Adjust for decimal if it's 0.6 or more, effectively rounding up for display if needed
            $perpuluhan = $jumlahKursus[$indeksBulan] - floor($jumlahKursus[$indeksBulan]);
            if ($perpuluhan >= 0.6) {
                $jumlahKursus[$indeksBulan] += 0.4;
            }
        }

        $jumlahPermohonan = $this->getAllApplication($tahunCarian);

        return view('pages.rekod-kursus', compact('rekodKeseluruhan', 'jumlahKursus', 'jumlahPermohonan'));
    }

    /**
     * Displays individual records, filterable by division and year.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function rekodIndividu(Request $request)
    {
        $idBahagianCarian = $request->input('bahagian');
        $tahunCarian = $request->input('tahun') ?? Carbon::now()->year; // Default to current year

        $dataPengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
        $bahagian = EproBahagian::all(); // Use all() to get all records

        $rekodKeseluruhan = $this->getAllRecord()
            ->flatMap(fn($records) => $records) // Flatten the grouped collection
            ->filter(fn($item) => Carbon::parse($item['tarikh_mula'])->year == $tahunCarian); // Filter by year first

        // Filter by division if a division is selected
        if ($idBahagianCarian) {
            $rekodKeseluruhan = $rekodKeseluruhan->filter(fn($item) => $item['id_bahagian'] == $idBahagianCarian);
        }

        // Re-group by user_id after filtering for display if needed
        $rekodKeseluruhan = $rekodKeseluruhan->groupBy('id_pengguna');

        return view('pages.laporan-individu', compact('rekodKeseluruhan', 'bahagian', 'dataPengguna'));
    }
}
