<?php

namespace App\Http\Controllers;

use App\Models\EproIsytihar;
use Illuminate\Http\Request;

class IsytiharController extends Controller
{
    public function index(Request $request)
    {
        $isytihar = EproIsytihar::with('user')
            ->where('isy_idusers', \Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $isytihar
            ]);
        }

        return view('pages.isytihar-kursus');
    }

    public function show($id)
    {
        $isytihar = EproIsytihar::where('isy_id', $id)->first();
        return response($isytihar);
    }

    public function store(Request $request)
    {
        EproIsytihar::create([
            'isy_idusers' => \Auth::id(),
            'isy_nama' => $request->isy_nama,
            'isy_tkhmula' => $request->isy_tkhmula,
            'isy_tkhtamat' => $request->isy_tkhtamat,
            'isy_jam' => $request->isy_jam,
            'isy_tempat' => $request->isy_tempat,
            'isy_anjuran' => $request->isy_anjuran,
            'isy_kos' => $request->isy_kos,
            'isy_status' => 1
        ]);
    }
}
