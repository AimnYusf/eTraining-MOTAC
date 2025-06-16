<?php

namespace App\Http\Controllers;

use App\Mail\VerifyMail;
use App\Models\EproKursus;
use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
        $permohonan = EproPermohonan::where('per_idusers', Auth::id())->pluck('per_idkursus');

        $kursus = EproKursus::with('eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan')
            ->where('kur_status', 1)
            ->where(function ($query) use ($pengguna) {
                $query->where('kur_idkumpulan', $pengguna->pen_idkumpulan)
                    ->orWhere('kur_idkumpulan', 4);
            })
            ->whereNotIn('kur_id', $permohonan)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $kursus
            ]);
        }

        return view('pages.pengguna-kursus', compact('kursus'));
    }

    // public function show($id)
    // {
    //     $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
    //         ->where('kur_id', $id)
    //         ->first();

    //     $pengguna = EproPengguna::with('eproBahagian')
    //         ->where('pen_idusers', Auth::id())->first();

    //     return view('pages.maklumat-kursus', [
    //         'kursus' => $kursus,
    //         'pengguna' => $pengguna
    //     ]);
    // }

    public function show($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response()->json($kursus);
    }

    public function store(Request $request)
    {
        // Create the application
        $permohonan = EproPermohonan::create([
            'per_idusers' => Auth::id(),
            'per_idkursus' => $request->kur_id,
            'per_tkhmohon' => now(),
            'per_status' => 1,
        ]);

        // Get user and course details
        $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
        $kursus = EproKursus::find($request->kur_id);

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
        Mail::to($pengguna->pen_ppemel)->queue(new VerifyMail($mailData));
    }

    public function maklumatKursus($id)
    {
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->where('kur_id', $id)
            ->first();

        return response($kursus);
    }
}
