<?php

namespace App\Http\Controllers;

use App\Models\EproIsytihar;
use App\Models\EproPengguna;
use Illuminate\Http\Request;

class KelulusanController extends Controller
{
    public function index(Request $request)
    {
        $kelulusan = EproIsytihar::with('user.eproPengguna')
            ->where('isy_status', 1)
            ->whereHas('user.eproPengguna', function ($query) {
                $query->where('pen_ppemel', \Auth::user()->email);
            })
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $kelulusan
            ]);
        }

        return view('pages.menunggu-kelulusan');
    }

    public function show($id)
    {
        $isytihar = EproIsytihar::with('user.eproPengguna')
            ->where('isy_id', $id)->first();
        $pengguna = EproPengguna::where('pen_idusers', $isytihar->isy_idusers)->first();
        return response($pengguna);
    }


    public function store($id)
    {

    }

    public function update($id)
    {
        $isytihar = EproIsytihar::findOrFail($id);
        $isytihar->update([
            'isy_status' => 2
        ]);
    }
}
