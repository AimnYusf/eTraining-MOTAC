<?php

namespace App\Http\Controllers;

use App\Models\EproBahagian;
use App\Models\EproIsytihar;
use App\Models\EproPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Post;

class PegawaiLatihanController extends Controller
{
    public function index(Request $request) {}

    public function rekodBaru(Request $request)
    {
        if ($request->isMethod('post')) {
            EproIsytihar::create(
                [
                    'isy_idusers' => $request->isy_idusers,
                    'isy_nama' => $request->isy_nama,
                    'isy_tkhmula' => $request->isy_tkhmula,
                    'isy_tkhtamat' => $request->isy_tkhtamat,
                    'isy_jam' => $request->isy_jam,
                    'isy_tempat' => $request->isy_tempat,
                    'isy_anjuran' => $request->isy_anjuran,
                    'isy_status' => '4',
                ]
            );
        }

        $pengguna = EproPengguna::where('pen_idbahagian', function ($query) {
            $query->select('pen_idbahagian')
                ->from('epro_pengguna')
                ->where('pen_idusers', Auth::id())
                ->first();
        })->get();

        Log::info($pengguna->toArray());

        return view('pages.pegawai-latihan-tambah', compact('pengguna'));
    }
}
