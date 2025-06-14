<?php

namespace App\Http\Controllers;

use App\Models\EproKategori;
use App\Models\EproKumpulan;
use App\Models\EproKursus;
use App\Models\EproPenganjur;
use App\Models\EproTempat;
use Illuminate\Http\Request;

class KursusController extends Controller
{
    public function index(Request $request)
    {
        $kursus = EproKursus::orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $kursus
            ]);
        }

        return view('pages.senarai-kursus', compact('kursus'));
    }

    public function urusKursus(Request $request)
    {
        $kursus = $request->query('kid') ? EproKursus::find($request->query('kid')) : null;
        $tajuk = $kursus ? 'Kemaskini Kursus' : 'Tambah Kursus';

        return view('pages.urus-kursus', [
            'tajuk' => $tajuk,
            'kursus' => $kursus,
            'kategori' => EproKategori::get(),
            'penganjur' => EproPenganjur::get(),
            'tempat' => EproTempat::get(),
            'kumpulan' => EproKumpulan::get()
        ]);
    }

    public function show($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response()->json($kursus);
    }

    public function store(Request $request)
    {
        EproKursus::updateOrCreate(
            ['kur_id' => $request->kur_id],
            [
                'kur_nama' => $request->kur_nama,
                'kur_objektif' => $request->kur_objektif,
                'kur_idkategori' => $request->kur_idkategori,
                'kur_idpenganjur' => $request->kur_idpenganjur,
                'kur_tkhmula' => $request->kur_tkhmula,
                'kur_msamula' => $request->kur_msamula,
                'kur_msatamat' => $request->kur_msatamat,
                'kur_tkhtamat' => $request->kur_tkhtamat,
                'kur_bilhari' => $request->kur_bilhari,
                'kur_idtempat' => $request->kur_idtempat,
                'kur_tkhbuka' => $request->kur_tkhbuka,
                'kur_tkhtutup' => $request->kur_tkhtutup,
                'kur_tkhmbalas' => $request->kur_tkhmbalas,
                'kur_bilpeserta' => $request->kur_bilpeserta,
                'kur_idkumpulan' => $request->kur_idkumpulan,
                'kur_status' => $request->kur_status,
            ]
        );
    }
}
