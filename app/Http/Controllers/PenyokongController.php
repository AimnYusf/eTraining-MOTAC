<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationFailedMail;
use App\Mail\ApplicationNotificationMail;
use App\Models\EtraKursus;
use App\Models\EtraPengguna;
use App\Models\EtraPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PenyokongController extends Controller
{
    public function show($id)
    {
        // Fetch the permohonan with related kursus, tempat, pengguna, jabatan, bahagian & kumpulan
        $permohonan = EtraPermohonan::with([
            'etraKursus.etraTempat',
            'etraPengguna.etraKumpulan',
            'etraPengguna.etraJabatan',
            'etraPengguna.etraBahagian',
            'etraStatus'
        ])->findOrFail($id);

        Log::info($permohonan->toArray());

        // Get pengguna from the permohonan's user
        $pengguna = $permohonan->etraPengguna;

        // Return the view with data
        return view('pages.penyokong-kursus', compact('permohonan', 'pengguna'));
    }

    public function store(Request $request)
    {
        try {
            // Update application status and action date
            EtraPermohonan::where('per_id', $request->per_id)->update([
                'per_status' => $request->per_status,
                'per_tkhtindakan' => now()->toDateTimeString(),
            ]);

            // Retrieve user and course data
            $pengguna = EtraPengguna::where('pen_idusers', $request->pen_id)->first();
            $kursus = EtraKursus::with('etraTempat')->find($request->kur_id);
            $status = $request->per_status;

            // Ensure the user exists before proceeding
            if ($status == 2) {
                Mail::to($pengguna->pen_emel)->queue(
                    new ApplicationNotificationMail($pengguna, $kursus, $status)
                );
            }
            if ($status == 3) {
                Mail::to($pengguna->pen_emel)
                    ->queue(new ApplicationFailedMail($kursus, $status));
            }

        } catch (\Exception $e) {
            Log::error('Gagal mengemaskini permohonan: ' . $e->getMessage());
        }
    }
}
