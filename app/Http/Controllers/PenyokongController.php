<?php

namespace App\Http\Controllers;

use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PenyokongController extends Controller
{
    public function show($id)
    {
        // Fetch the permohonan with related kursus, tempat, pengguna, jabatan, bahagian & kumpulan
        $permohonan = EproPermohonan::with([
            'eproKursus.eproTempat',
            'eproPengguna.eproKumpulan',
            'eproPengguna.eproJabatan',
            'eproPengguna.eproBahagian',
        ])->findOrFail($id);

        // Get pengguna from the permohonan's user
        $pengguna = $permohonan->eproPengguna;

        // Return the view with data
        return view('pages.penyokong-kursus', compact('permohonan', 'pengguna'));
    }

    public function store(Request $request)
    {
        EproPermohonan::where('per_id', $request->per_id)
            ->update([
                'per_status' => $request->per_status,
                'per_tkhtindakan' => now()->toDateTimeString()
            ]);
    }
}
