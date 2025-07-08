<?php

namespace App\Http\Controllers;

use App\Mail\ApprovalRequestMail;
use App\Models\EproKursus;
use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Get authenticated user's group and their applied course IDs
        $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
        $permohonan = EproPermohonan::where('per_idusers', Auth::id())->pluck('per_idkursus');

        // Retrieve available courses for the user that they haven't applied for
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_status', 1)
            ->where(function ($query) use ($pengguna) {
                $query->where('kur_idkumpulan', $pengguna->pen_idkumpulan)
                    ->orWhere('kur_idkumpulan', 4);
            })
            ->whereNotIn('kur_id', $permohonan)
            ->latest()
            ->get();

        // If viewing a specific course
        $kid = $request->query('kid');
        if ($kid) {
            if ($kursus->contains('kur_id', $kid)) {
                $kursus = $kursus->firstWhere('kur_id', $kid);
                // dd($kursus->toArray());
                return view('pages.pengguna-kursus-mohon', compact('kursus'));
            }
            abort(404);
        }

        // Return data for DataTables AJAX request
        if ($request->ajax()) {
            return response()->json(['data' => $kursus]);
        }

        // Return main view with course list
        return view('pages.pengguna-kursus', compact('kursus'));
    }

    public function show($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response()->json($kursus);
    }

    public function store(Request $request)
    {
        try {
            // Create the application
            $permohonan = EproPermohonan::create([
                'per_idusers' => Auth::id(),
                'per_idkursus' => $request->kur_id,
                'per_tkhmohon' => now(),
                'per_status' => 1,
            ]);

            // Get user and course details
            $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
            $kursus = EproKursus::with('eproTempat')
                ->find($request->kur_id);

            // Prepare data for email
            $mailData = [
                'encrypted_id' => Crypt::encrypt($permohonan->per_id),
                'nama' => $pengguna->pen_nama ?? '-',
                'jawatan' => $pengguna->pen_jawatan ?? '-',
                'gred' => $pengguna->pen_gred ?? '-',
                'nama_kursus' => $kursus->kur_nama ?? '-',
                'tarikh_mula' => $kursus->kur_tkhmula ?? '-',
                'tarikh_tamat' => $kursus->kur_tkhtamat ?? '-',
            ];

            // Send email
            Mail::to($pengguna->pen_ppemel)->queue(new ApprovalRequestMail($mailData));
            return response()->json(['message' => 'Email sent successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Email failed: ' . $e->getMessage()], 500);
        }
    }

    public function maklumatKursus($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response($kursus);
    }
}
