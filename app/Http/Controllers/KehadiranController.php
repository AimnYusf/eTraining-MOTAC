<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EproKehadiran;
use App\Models\EproKursus;
use App\Models\EproPermohonan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $kid = $request->query('kid');

        if ($kid != null) {
            $kursus = EproKursus::where('kur_id', $kid)->first();
            $permohonan = EproPermohonan::with([
                'eproPengguna.eproJabatan',
                'eproPengguna.eproKumpulan',
                'etraStatus',
                'eproKursus',
                'eproPengguna.eproKehadiran' => function ($query) use ($kid) {
                    $query->where('keh_idkursus', $kid);
                }
            ])
                ->where('per_idkursus', $kid)
                ->where('per_status', 4)
                ->get();

            // dd($permohonan->toArray());
            if ($request->ajax()) {
                return response()->json([
                    'data' => $permohonan
                ]);
            }
            return view('pages.urusetia-kehadiran-pegawai', compact('kursus', 'permohonan', ));
        }

        return view('pages.urusetia-kehadiran');
    }

    // public function show($id)
    // {
    //     return response()->json($kursus);
    // }

    public function store(Request $request)
    {
        $keh_tkhmasuk = $request->keh_tkhmasuk
            ? Carbon::createFromFormat('d/m/Y', $request->keh_tkhmasuk)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        EproKehadiran::create([
            'keh_idusers' => $request->keh_idusers,
            'keh_idkursus' => $request->keh_idkursus,
            'keh_tkhmasuk' => $keh_tkhmasuk,
        ]);
    }
}
