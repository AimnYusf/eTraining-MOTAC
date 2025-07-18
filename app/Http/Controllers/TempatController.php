<?php

namespace App\Http\Controllers;

use App\Models\EproTempat;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    public function index(Request $request)
    {
        $tempat = EproTempat::orderBy('tem_keterangan', 'asc')->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $tempat
            ]);
        }

        return view('pages.urusetia-tempat');
    }

    public function show($id)
    {
        $tempat = EproTempat::where('tem_id', $id)->first();
        return response()->json($tempat);
    }

    public function store(Request $request)
    {
        $tempat = EproTempat::updateOrCreate(
            ['tem_id' => $request->tem_id],
            [
                'tem_keterangan' => $request->tem_keterangan,
                'tem_alamat' => $request->tem_alamat,
                'tem_gmaps' => $request->tem_gmaps
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully.',
            'data' => $tempat
        ]);
    }
}
