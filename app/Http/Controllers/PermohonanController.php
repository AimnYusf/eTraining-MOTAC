<?php

namespace App\Http\Controllers;

use App\Models\EproKategori;
use App\Models\EproKumpulan;
use App\Models\EproKursus;
use App\Models\EproPenganjur;
use App\Models\EproPermohonan;
use App\Models\EproTempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $kid = $request->query('kid');

        // If adding or editing a record
        if ($kid !== null) {
            $permohonan = EproPermohonan::with('user.eproPengguna.eproJabatan', 'eproStatus')
                ->where('per_idkursus', $kid)
                ->whereNotIn('per_status', [1, 3])
                ->get();

            $kursus = EproKursus::where('kur_id', $kid)->first();
            if ($request->ajax()) {
                return response()->json([
                    'data' => $permohonan
                ]);
            }
            return view('pages.urusetia-permohonan-edit', compact('kursus'));
        }

        // Main list page
        $kursus = EproKursus::with('eproKategori', 'eproTempat')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json(['data' => $kursus]);
        }

        return view('pages.urusetia-permohonan', compact('kursus'));
    }

    public function show(Request $request, $id)
    {
        // Get permohonan list with user → eproPengguna → kumpulan, bahagian, jabatan
        $permohonan = EproPermohonan::with([
            'user.eproPengguna.eproKumpulan',
            'user.eproPengguna.eproBahagian',
            'user.eproPengguna.eproJabatan',
            'eproKursus.eproTempat',
        ])
            ->where('per_id', $id)
            ->whereNotIn('per_status', [1, 3])
            ->first();

        $pengguna = $permohonan->user?->eproPengguna;
        $kursus = $permohonan->eproKursus;

        return response()->json([
            'permohonan' => $permohonan,
            'pengguna' => $pengguna,
            'kursus' => $kursus
        ]);
    }

    public function update(Request $request, $id)
    {
        $permohonan = EproPermohonan::find($id);
        if ($permohonan) {
            $permohonan->update(['per_status' => $request->per_status]);
        }
    }
}
