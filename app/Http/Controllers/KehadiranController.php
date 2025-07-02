<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EproKehadiran;
use App\Models\EproKursus;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $kid = $request->query('kid');

        if ($kid != null) {
            $kursus = EproKursus::where('kur_id', $kid)->first();
            $permohonan = EproPermohonan::with('user.eproPengguna.eproJabatan', 'eproStatus', 'eproKursus', 'user.eproKehadiran')
                ->where('per_idkursus', $kid)
                ->where('per_status', 4)
                ->get();
            // dd($permohonan->toArray());
            if ($request->ajax()) {
                return response()->json([
                    'data' => $permohonan
                ]);
            }
            return view('pages.urusetia-kehadiran-pegawai', compact('kursus', 'permohonan',));
        }

        return view('pages.urusetia-kehadiran');
    }

    // public function show($id)
    // {
    //     return response()->json($kursus);
    // }

    public function store(Request $request)
    {
        EproKehadiran::create([
            'keh_idusers' => $request->keh_idusers,
            'keh_idkursus' =>  $request->keh_idkursus,
            'keh_tkhmasuk' =>  $request->keh_tkhmasuk,
        ]);
    }
}
