<?php

namespace App\Http\Controllers;

use App\Models\EproKursus;
use App\Models\EproPermohonan;
use App\Models\EtraStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $permohonan = EproPermohonan::with(['eproKursus', 'etraStatus'])
            ->where('per_idusers', Auth::id())
            ->orderBy('per_tkhmohon', 'desc')
            ->get();

        $status = EtraStatus::get();

        // dd($permohonan->toArray());
        if ($request->ajax()) {
            return response()->json([
                'data' => $permohonan
            ]);
        }

        return view('pages.pengguna-permohonan', compact('status'));
    }

    public function show($id)
    {
        $kursus = EproKursus::with(['etraKategori', 'etraPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response()->json($kursus);
    }
}
