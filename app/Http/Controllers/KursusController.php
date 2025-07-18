<?php

namespace App\Http\Controllers;

use App\Models\EproKategori;
use App\Models\EproKumpulan;
use App\Models\EproKursus;
use App\Models\EproPenganjur;
use App\Models\EproTempat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KursusController extends Controller
{
    public function index(Request $request)
    {
        $kid = $request->query('kid');

        // If adding or editing a record
        if ($kid !== null) {
            $sharedData = [
                'kategori' => EproKategori::all(),
                'penganjur' => EproPenganjur::all(),
                'tempat' => EproTempat::orderBy('tem_keterangan', 'asc')->get(),
                'kumpulan' => EproKumpulan::all()
            ];

            // Add new
            if ($kid === '?') {
                return view('pages.urusetia-kursus-tambah', [
                    'tajuk' => 'Tambah rekod baru',
                    ...$sharedData
                ]);
            }

            // Edit existing
            $kursus = EproKursus::where('kur_id', $kid)->first();
            return view('pages.urusetia-kursus-tambah', [
                'tajuk' => 'Kemaskini rekod',
                'kursus' => $kursus,
                ...$sharedData
            ]);
        }

        // Main list page
        $kursus = EproKursus::with('eproKategori')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json(['data' => $kursus]);
        }

        return view('pages.urusetia-kursus', compact('kursus'));
    }

    public function tambahKursus(Request $request)
    {
        $kursus = $request->query('kid') ? EproKursus::find($request->query('kid')) : null;
        $tajuk = $kursus ? 'Kemaskini Kursus' : 'Tambah Kursus';

        return view('pages.urusetia-kursus-tambah', [
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

        if ($request->hasFile('kur_poster')) {
            $image = $request->file('kur_poster');
            $customName = 'poster_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('poster'), $customName);

            $imagePath = 'poster/' . $customName;
        } else {
            // If no new file uploaded and existing record has no image, use default
            $existing = EproKursus::find($request->kur_id);

            $imagePath = $existing && $existing->kur_poster
                ? $existing->kur_poster
                : 'poster/no-image.jpg';
        }

        EproKursus::updateOrCreate(
            ['kur_id' => $request->kur_id],
            [
                'kur_nama' => $request->kur_nama,
                'kur_objektif' => $request->kur_objektif,
                'kur_idkategori' => $request->kur_idkategori,
                'kur_idpenganjur' => $request->kur_idpenganjur,
                'kur_tkhmula' => $request->kur_tkhmula,
                'kur_msamula' => Carbon::createFromFormat('g:ia', strtolower($request->kur_msamula))->format('H:i'),
                'kur_msatamat' => Carbon::createFromFormat('g:ia', strtolower($request->kur_msatamat))->format('H:i'),
                'kur_tkhtamat' => $request->kur_tkhtamat,
                'kur_bilhari' => $request->kur_bilhari,
                'kur_idtempat' => $request->kur_idtempat,
                'kur_tkhbuka' => $request->kur_tkhbuka,
                'kur_tkhtutup' => $request->kur_tkhtutup,
                'kur_bilpeserta' => $request->kur_bilpeserta,
                'kur_idkumpulan' => $request->kur_idkumpulan,
                'kur_poster' => $imagePath,
                'kur_status' => $request->kur_status,
            ]
        );
    }
}
