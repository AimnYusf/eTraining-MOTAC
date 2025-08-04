<?php

namespace App\Http\Controllers;

use App\Helpers\Records;
use App\Models\EtraBahagian;
use App\Models\EtraKumpulan;
use App\Models\EtraPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    public function rekodKursus(Request $request)
    {
        $carianId = Auth::id();
        $carianTahun = $request->input('tahun') ?? Carbon::now()->year;

        $rekodPengguna = Records::rekodPengguna()
            ->filter(
                fn($item) =>
                $item['id_pengguna'] == $carianId &&
                !empty($item['tarikh_mula']) &&
                Carbon::parse($item['tarikh_mula'])->year == $carianTahun
            )
            ->sortBy('tarikh_mula');

        $rekodBulananPengguna = Records::rekodBulananPengguna($carianId, $carianTahun);
        $jumlahPermohonanPengguna = Records::jumlahPermohonanPengguna($carianId, $carianTahun);

        return view('pages.rekod-kursus', compact(
            'rekodPengguna',
            'rekodBulananPengguna',
            'jumlahPermohonanPengguna'
        ));
    }

    public function rekodKumpulan(Request $request)
    {
        $carianTahun = $request->input('tahun') ?? Carbon::now()->year;
        $kumpulan = EtraKumpulan::whereNotNull('kum_ketring')->get();
        $rekodKumpulan = Records::rekodKumpulan($carianTahun);

        return view('pages.laporan-kumpulan', compact('rekodKumpulan', 'kumpulan'));
    }

    public function rekodBahagian(Request $request)
    {
        $carianTahun = $request->input('tahun') ?? Carbon::now()->year;
        $bahagian = EtraBahagian::all();
        $rekodBahagian = Records::rekodBahagian($carianTahun);

        return view('pages.laporan-bahagian', compact('rekodBahagian', 'bahagian'));
    }

    public function rekodKeseluruhan(Request $request)
    {
        $pengguna = EtraPengguna::where('pen_idusers', Auth::id())->first();
        $bahagian = EtraBahagian::all();
        $carianBahagian = $request->input('bahagian') ?? $pengguna->pen_idbahagian;
        $carianTahun = $request->input('tahun') ?? Carbon::now()->year;
        $rekodKeseluruhan = Records::jumlahRekodPengguna($carianTahun, $carianBahagian);

        return view('pages.laporan-keseluruhan', compact(
            'rekodKeseluruhan',
            'bahagian',
            'pengguna'
        ));
    }

    public function rekodIndividu(Request $request)
    {
        $pengguna = EtraPengguna::where('pen_idusers', Auth::id())->first();
        $bahagian = EtraBahagian::all();
        $carianBahagian = $request->input('bahagian') ?? $pengguna->pen_idbahagian;
        $carianTahun = $request->input('tahun') ?? Carbon::now()->year;

        $rekodIndividu = Records::rekodPengguna()
            ->filter(
                fn($item) => (
                    $item['tarikh_mula'] === null ||
                    Carbon::parse($item['tarikh_mula'])->year == $carianTahun
                ) &&
                $item['id_bahagian'] == $carianBahagian
            )
            ->sortBy('tarikh_mula')
            ->groupBy('id_pengguna');

        return view('pages.laporan-individu', compact(
            'rekodIndividu',
            'bahagian',
            'pengguna'
        ));
    }
}
