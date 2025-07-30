<?php

namespace App\Http\Controllers;

use App\Helpers\Records;
use App\Models\EtraBahagian;
use App\Models\EtraIsytihar;
use App\Models\EtraPengguna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Post;

class PegawaiLatihanController extends Controller
{
    public function index(Request $request)
    {
    }

    public function rekodBaru(Request $request)
    {
        if ($request->isMethod('post')) {
            EtraIsytihar::create(
                [
                    'isy_idusers' => $request->isy_idusers,
                    'isy_nama' => $request->isy_nama,
                    'isy_tkhmula' => $request->isy_tkhmula,
                    'isy_tkhtamat' => $request->isy_tkhtamat,
                    'isy_jam' => $request->isy_jam,
                    'isy_tempat' => $request->isy_tempat,
                    'isy_anjuran' => $request->isy_anjuran,
                    'isy_status' => 8,
                ]
            );
        }

        $pengguna = EtraPengguna::where('pen_idbahagian', function ($query) {
            $query->select('pen_idbahagian')
                ->from('etra_pengguna')
                ->where('pen_idusers', Auth::id())
                ->first();
        })->get();

        return view('pages.pentadbir-latihan-tambah', compact('pengguna'));
    }

    public function rekodPegawai(Request $request)
    {
        $carianTahun = $request->input('tahun') ?? Carbon::now()->year;
        $carianBahagian = EtraPengguna::where('pen_idusers', Auth::id())->first();

        $jumlahRekodPengguna = Records::jumlahRekodPengguna(now()->year, $carianBahagian['pen_idbahagian']);
        if ($request->ajax()) {
            return response()->json([
                'data' => $jumlahRekodPengguna
            ]);
        }

        // If viewing a specific course
        $pid = $request->query('pid');

        if ($pid) {
            $carianTahun = $request->input('tahun') ?? Carbon::now()->year;

            $rekodPengguna = Records::rekodPengguna()
                ->filter(
                    fn($item) =>
                    $item['id_pengguna'] == $pid &&
                    !empty($item['tarikh_mula']) &&
                    Carbon::parse($item['tarikh_mula'])->year == $carianTahun
                );

            $rekodBulananPengguna = Records::rekodBulananPengguna($pid, $carianTahun);
            $jumlahPermohonanPengguna = Records::jumlahPermohonanPengguna($pid, $carianTahun);
            $pengguna = EtraPengguna::with('etraKumpulan')
                ->where('pen_idusers', $pid)->first();

            return view('pages.pentadbir-latihan-maklumat', compact(
                'rekodPengguna',
                'rekodBulananPengguna',
                'jumlahPermohonanPengguna',
                'pengguna'
            ));
        }

        return view('pages.pentadbir-latihan-rekod');
    }
}
