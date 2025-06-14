<?php

namespace App\Http\Controllers;

use App\Models\EproKursus;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $permohonan = EproKursus::with('eproTempat')->get();

        // dd($permohonan->toArray());
        if ($request->ajax()) {
            return response()->json([
                'data' => $permohonan
            ]);
        }

        return view('pages.senarai-permohonan');
    }

    public function show(Request $request, $id)
    {
        $permohonan = EproPermohonan::with('user.eproPengguna.eproJabatan', 'eproStatus')
            ->where('per_idkursus', $id)
            ->whereNotIn('per_status', [1, 3])
            ->get();

        $kursus = EproKursus::where('kur_id', $id)->first();

        // dd($permohonan->toArray());
        if ($request->ajax()) {
            return response()->json([
                'data' => $permohonan
            ]);
        }

        return view('pages.urus-permohonan', compact('kursus'));
    }

    public function edit($id)
    {
        $permohonan = EproPermohonan::with([
            'eproKursus.eproTempat',
            'user.eproPengguna.eproKumpulan',
            'user.eproPengguna.eproJabatan',
            'user.eproPengguna.eproBahagian',
        ])->findOrFail($id);

        $pengguna = $permohonan->user->eproPengguna;

        // Return both in one JSON response
        return response()->json([
            'permohonan' => $permohonan,
            'pengguna' => $pengguna,
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
