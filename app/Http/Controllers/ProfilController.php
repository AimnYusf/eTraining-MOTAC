<?php

namespace App\Http\Controllers;

use App\Models\EtraBahagian;
use App\Models\EtraJabatan;
use App\Models\EtraKumpulan;
use App\Models\EproPengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.profil', [
            'pengguna' => EproPengguna::where('pen_idusers', Auth::id())->first(),
            'bahagian' => EtraBahagian::all(),
            'jabatan' => EtraJabatan::all(),
            'kumpulan' => EtraKumpulan::whereNotNull('kum_ketring')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pen_nama' => 'required|string|max:255',
            'pen_nokp' => 'required|string|max:20',
            'pen_emel' => 'nullable|email',
            'pen_notel' => 'nullable|string|max:20',
            'pen_nohp' => 'nullable|string|max:20',
            // Add other validations as necessary
        ]);

        // Update role if guest
        if (Auth::user()->role === '1') {
            User::updateOrCreate(
                ['id' => Auth::id()],
                ['role' => '2']
            );
        }

        // Store user profile
        EproPengguna::updateOrCreate(
            ['pen_idusers' => Auth::id()],
            [
                'pen_nama' => strtoupper($request->pen_nama),
                'pen_nokp' => $request->pen_nokp,
                'pen_jantina' => $request->pen_jantina,
                'pen_jawatan' => $request->pen_jawatan,
                'pen_gred' => $request->pen_gred,
                'pen_idkumpulan' => $request->pen_idkumpulan,
                'pen_idjabatan' => $request->pen_idjabatan,
                'pen_idbahagian' => $request->pen_idbahagian,
                'pen_bahagianlain' => $request->pen_bahagianlain,
                'pen_emel' => $request->pen_emel,
                'pen_notel' => $request->pen_notel,
                'pen_nohp' => $request->pen_nohp,
                'pen_kjnama' => strtoupper($request->pen_kjnama),
                'pen_kjgelaran' => strtoupper($request->pen_kjgelaran),
                'pen_kjemel' => $request->pen_kjemel,
                'pen_ppnama' => strtoupper($request->pen_ppnama),
                'pen_ppemel' => $request->pen_ppemel,
                'pen_ppgred' => $request->pen_ppgred,
            ]
        );

        // Update user name
        User::updateOrCreate(
            ['id' => Auth::id()],
            ['name' => strtoupper($request->pen_nama)]
        );

        return redirect()->back()->with('success', 'Maklumat pengguna berjaya disimpan.');
    }


    //Delete Later
    public function update(Request $request)
    {
        User::where('id', Auth::id())->update(['role' => $request->role]);
    }
}
