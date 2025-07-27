<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationApprovedMail;
use App\Mail\ApplicationFailedMail;
use App\Models\EproKursus;
use App\Models\EproPermohonan;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $kid = $request->query('kid');

        if ($kid !== null) {
            $permohonan = EproPermohonan::with('eproPengguna.eproJabatan', 'etraStatus', 'eproPengguna.eproBahagian')
                ->where('per_idkursus', $kid)
                ->whereNotIn('per_status', [1, 3])
                ->get();

            $kursus = EproKursus::where('kur_id', $kid)->first();

            if ($request->ajax()) {
                return response()->json(['data' => $permohonan]);
            }

            return view('pages.urusetia-permohonan-edit', compact('kursus'));
        }

        $kursus = EproKursus::with('eproKategori', 'eproTempat')
            ->orderBy('kur_tkhmula', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json(['data' => $kursus]);
        }

        return view('pages.urusetia-permohonan', compact('kursus'));
    }

    public function show(Request $request, $id)
    {
        $permohonan = EproPermohonan::with([
            'eproPengguna.eproKumpulan',
            'eproPengguna.eproBahagian',
            'eproPengguna.eproJabatan',
            'eproKursus.eproTempat',
            'etraStatus'
        ])
            ->where('per_id', $id)
            ->whereNotIn('per_status', [1, 3])
            ->first();

        if (!$permohonan) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $pengguna = $permohonan->eproPengguna;
        $kursus = $permohonan->eproKursus;

        return response()->json([
            'permohonan' => $permohonan,
            'pengguna' => $pengguna,
            'kursus' => $kursus
        ]);
    }

    public function update(Request $request, $id)
    {
        $permohonan = EproPermohonan::with('eproPengguna')->find($id);
        $status = $request->per_status;

        if (!$permohonan) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $permohonan->update(['per_status' => $status]);

        $kursus = EproKursus::with(['eproTempat', 'eproPenganjur'])
            ->where('kur_id', $permohonan->per_idkursus)
            ->first();

        switch ($status) {
            case 4:
                return $this->generateQR($permohonan, $kursus);

            case 5:
                $userEmail = $permohonan->eproPengguna->pen_emel;
                Mail::to($userEmail)->queue(mailable: new ApplicationFailedMail($kursus, $status));
                break;
        }

        return response()->json(['message' => 'Application updated successfully']);
    }

    public function batchUpdate(Request $request)
    {
        $ids = $request->ids;
        $status = $request->per_status;

        foreach ($ids as $id) {
            $permohonan = EproPermohonan::with('eproPengguna')->find($id);

            if (!$permohonan) {
                // Optionally skip or create a new one based on your logic
                continue;
            }

            // Use updateOrCreate (based on per_id)
            EproPermohonan::updateOrCreate(
                ['per_id' => $id], // condition
                ['per_status' => $status] // values to update
            );

            $kursus = EproKursus::with(['eproTempat', 'eproPenganjur'])
                ->where('kur_id', $permohonan->per_idkursus)
                ->first();

            switch ($status) {
                case 4:
                    $this->generateQR($permohonan, $kursus);
                    break;

                case 5:
                    Mail::to($permohonan->eproPengguna->pen_emel)
                        ->queue(new ApplicationFailedMail($kursus, $status));
                    break;
            }
        }

        return response()->json(['message' => 'Batch updated successfully']);
    }


    public function generateQR($permohonan, $kursus)
    {
        $pengguna = $permohonan->eproPengguna;
        $userEmail = $permohonan->eproPengguna->pen_emel;
        $supervisorEmail = $pengguna->pen_ppemel;

        $qrCodeFileName = 'qrcode_' . uniqid() . '.png';
        $qrCodePathInStorage = 'public/qrcodes/' . $qrCodeFileName;
        $fullQrCodePath = Storage::path($qrCodePathInStorage);

        try {
            $options = new QROptions([
                'eccLevel' => QRCode::ECC_L,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'imageBase64' => false,
                'scale' => 10,
                'imageTransparent' => false,
            ]);

            $qrcode = new QRCode($options);
            $qrCodeImage = $qrcode->render($permohonan->per_idusers);

            Storage::put($qrCodePathInStorage, $qrCodeImage);

            Mail::to($userEmail)
                ->cc($supervisorEmail)
                ->queue(new ApplicationApprovedMail($fullQrCodePath, $kursus, $pengguna));

            return response()->json(['message' => 'QR code generated and email sent successfully.']);
        } catch (\Exception $e) {
            Log::error('QR Code Generation or Email Failed', [
                'error' => $e->getMessage(),
                'permohonan_id' => $permohonan->per_id,
                'user_email' => $userEmail,
            ]);

            if (Storage::exists($qrCodePathInStorage)) {
                Storage::delete($qrCodePathInStorage);
            }

            return response()->json([
                'message' => 'Failed to generate QR code or send email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
