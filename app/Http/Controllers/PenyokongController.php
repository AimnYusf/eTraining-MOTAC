<?php

namespace App\Http\Controllers;

use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PenyokongController extends Controller
{
    public function show($encryptedId)
    {
        // Decrypt the permohonan ID
        $id = Crypt::decrypt($encryptedId);

        // Fetch the permohonan with related kursus, tempat, pengguna, jabatan, bahagian & kumpulan
        $permohonan = EproPermohonan::with([
            'eproKursus.eproTempat',
            'user.eproPengguna.eproKumpulan',
            'user.eproPengguna.eproJabatan',
            'user.eproPengguna.eproBahagian',
        ])->findOrFail($id);

        // Get pengguna from the permohonan's user
        $pengguna = $permohonan->user->eproPengguna;

        // Return the view with data
        return view('pages.penyokong-kursus', compact('permohonan', 'pengguna'));
    }

    public function store(Request $request)
    {
        EproPermohonan::where('per_id', $request->per_id)
            ->update(['per_status' => $request->per_status]);
    }

}
