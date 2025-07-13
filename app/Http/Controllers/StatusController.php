<?php

namespace App\Http\Controllers;

use App\Models\EproKursus;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $permohonan = EproPermohonan::with(['eproKursus', 'eproStatus'])
            ->where('per_idusers', Auth::id())
            ->orderBy('per_tkhmohon', 'desc')
            ->get();

        // dd($permohonan->toArray());
        if ($request->ajax()) {
            return response()->json([
                'data' => $permohonan
            ]);
        }

        return view('pages.pengguna-permohonan');
    }

    public function show($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response()->json($kursus);
    }
}
