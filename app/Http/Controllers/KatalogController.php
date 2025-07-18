<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationNotificationMail;
use App\Mail\ApprovalRequestMail;
use App\Models\EproKumpulan;
use App\Models\EproKursus;
use App\Models\EproPengguna;
use App\Models\EproPermohonan;
use App\Models\EtraUrusetia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Get authenticated user's group and their applied course IDs
        $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
        $permohonan = EproPermohonan::where('per_idusers', Auth::id())->pluck('per_idkursus');
        $urusetia = EtraUrusetia::get();

        // Retrieve available courses for the user that they haven't applied for
        $kursus = EproKursus::with(['eproKategori', 'eproPenganjur', 'eproTempat', 'eproKumpulan'])
            ->get();


        // If viewing a specific course
        $kid = $request->query('kid');
        if ($kid) {
            if ($kursus->contains('kur_id', $kid)) {
                $kursus = $kursus->firstWhere('kur_id', $kid);
                // dd($kursus->toArray());
                return view('pages.pengguna-kursus-mohon', compact('kursus', 'urusetia'));
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
            DB::beginTransaction();

            // Create the application
            $permohonan = EproPermohonan::create([
                'per_idusers' => Auth::id(),
                'per_idkursus' => $request->kur_id,
                'per_tkhmohon' => now(),
                'per_status' => 1,
            ]);
            $permohonan->load('eproStatus');

            // Get user and course details
            $pengguna = EproPengguna::where('pen_idusers', Auth::id())->first();
            $kursus = EproKursus::with('eproTempat')->find($request->kur_id);

            // Prepare data for email
            $url = URL::temporarySignedRoute(
                'pengesahan.show',
                now()->addDays(7),
                ['id' => $permohonan->per_id]
            );

            $mailData = [
                'url' => $url,
                'nama' => $pengguna->pen_nama,
                'jawatan' => $pengguna->pen_jawatan,
                'gred' => $pengguna->pen_gred,
                'nama_kursus' => $kursus->kur_nama,
                'tarikh_mula' => $kursus->kur_tkhmula,
                'tarikh_tamat' => $kursus->kur_tkhtamat,
                'tempat' => $kursus->eproTempat->tem_keterangan,
                'status' => $permohonan->eproStatus->stp_ketpenu ?? 'N/A',
                'tarikh_mohon' => $permohonan->per_tkhmohon
            ];

            // Attempt to send email
            Mail::to($pengguna->pen_ppemel)->queue(new ApprovalRequestMail($mailData));
            Mail::to($pengguna->pen_emel)->queue(new ApplicationNotificationMail($pengguna, $kursus));

            DB::commit();

            return response()->json(['message' => 'Permohonan berjaya dihantar dan emel telah dihantar!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Permohonan Gagal: ' . $e->getMessage());

            return response()->json(['error' => 'Permohonan gagal: ' . $e->getMessage()], 500);
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
