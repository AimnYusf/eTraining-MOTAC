<?php

namespace App\Http\Controllers;

use App\Models\EproKursus;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $permohonan = EproPermohonan::with(['user', 'eproKursus', 'eproStatus'])
            ->where('per_idusers', \Auth::id())
            ->orderBy('per_tkhmohon', 'desc')
            ->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $permohonan
            ]);
        }

        return view('pages.status-permohonan');
    }

    public function show($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response()->json($kursus);
    }
}
