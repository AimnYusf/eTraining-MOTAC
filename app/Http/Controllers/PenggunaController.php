<?php

namespace App\Http\Controllers;

use App\Models\EproBahagian;
use App\Models\EproJabatan;
use App\Models\EproKumpulan;
use App\Models\EproPengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function index()
    {
        return view('pages.profil', [
            'pengguna' => EproPengguna::where('pen_idusers', Auth::id())->first(),
            'bahagian' => EproBahagian::all(),
            'jabatan' => EproJabatan::all(),
            'kumpulan' => EproKumpulan::all(),
        ]);
    }

    public function store(Request $request)
    {
        //update role
        if (Auth::user()->role == 'guest') {
            User::updateOrCreate(
                ['id' => Auth::id()],
                ['role' => 'user']
            );
        }

        EproPengguna::updateOrCreate(
            ['pen_idusers' => Auth::id()],
            [
                'pen_nama' => $request->pen_nama,
                'pen_nokp' => $request->pen_nokp,
                'pen_jantina' => $request->pen_jantina,
                'pen_jawatan' => $request->pen_jawatan,
                'pen_gred' => $request->pen_gred,
                'pen_idkumpulan' => $request->pen_idkumpulan,
                'pen_idjabatan' => $request->pen_idjabatan,
                'pen_idbahagian' => $request->pen_idbahagian,
                'pen_jabatanlain' => $request->pen_jabatanlain,
                'pen_emel' => $request->pen_emel,
                'pen_notel' => $request->pen_notel,
                'pen_nofaks' => $request->pen_nofaks,
                'pen_nohp' => $request->pen_nohp,
                'pen_kjnama' => $request->pen_kjnama,
                'pen_kjgelaran' => $request->pen_kjgelaran,
                'pen_kjemel' => $request->pen_kjemel,
                'pen_ppnama' => $request->pen_ppnama,
                'pen_ppemel' => $request->pen_ppemel,
            ]
        );
    }

    //Delete Later
    public function update(Request $request)
    {
        User::where('id', Auth::id())->update(['role' => $request->role]);
    }
}
