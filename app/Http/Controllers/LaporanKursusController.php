<?php

namespace App\Http\Controllers;

use App\Models\EproKursus;
use Illuminate\Http\Request;

class LaporanKursusController extends Controller
{
    public function index(Request $request)
    {
        $kursus = EproKursus::where('kur_status', '1')
            ->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $kursus
            ]);
        }

        return view('pages.laporan-keseluruhan', compact('kursus'));
    }

    public function show($id)
    {
        $kursus = EproKursus::where('kur_id', $id)->first();
        return response()->json($kursus);
    }
}
