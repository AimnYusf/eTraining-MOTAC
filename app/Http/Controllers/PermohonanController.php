<?php

namespace App\Http\Controllers;

use App\Mail\QrAttendance;
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
            $permohonan = EproPermohonan::with('user.eproPengguna.eproJabatan', 'eproStatus')
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
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json(['data' => $kursus]);
        }

        return view('pages.urusetia-permohonan', compact('kursus'));
    }

    public function show(Request $request, $id)
    {
        $permohonan = EproPermohonan::with([
            'user.eproPengguna.eproKumpulan',
            'user.eproPengguna.eproBahagian',
            'user.eproPengguna.eproJabatan',
            'eproKursus.eproTempat',
            'eproStatus'
        ])
            ->where('per_id', $id)
            ->whereNotIn('per_status', [1, 3])
            ->first();

        if (!$permohonan) {
            return response()->json(['message' => 'Application not found'], 404);
        }

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
        $permohonan = EproPermohonan::with('user')->find($id);

        if (!$permohonan) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $permohonan->update(['per_status' => $request->per_status]);

        if ($request->per_status == 4) {
            return $this->generateQR($permohonan);
        }

        return response()->json(['message' => 'Application updated successfully']);
    }

    public function generateQR($permohonan)
    {
        $textContent = $permohonan->per_idusers;
        $recipientEmail = $permohonan->user->email;
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
            $qrCodeImage = $qrcode->render($textContent);

            Storage::put($qrCodePathInStorage, $qrCodeImage);

            Mail::to($recipientEmail)->queue(new QrAttendance($fullQrCodePath));

            return response()->json(['message' => 'QR code generated and email sent successfully.']);
        } catch (\Exception $e) {
            Log::error("Failed to generate QR or queue email: " . $e->getMessage(), ['permohonan_id' => $permohonan->per_id, 'email' => $recipientEmail]);
            if (Storage::exists($qrCodePathInStorage)) {
                Storage::delete($qrCodePathInStorage);
            }
            return response()->json(['message' => 'Failed to generate QR code or queue email.', 'error' => $e->getMessage()], 500);
        }
    }
}