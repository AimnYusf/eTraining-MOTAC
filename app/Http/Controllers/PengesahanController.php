<?php

namespace App\Http\Controllers;

use App\Models\EtraBahagian;
use App\Models\EtraIsytihar;
use App\Models\EtraPengguna;
use App\Models\EtraStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengesahanController extends Controller
{
    public function index(Request $request)
    {
        $bahagian = EtraBahagian::with('EtraPengguna')
            ->whereHas('EtraPengguna', function ($query) {
                $query->where('pen_idusers', Auth::id());
            })
            ->first();

        $pengesahan = collect();
        $status = EtraStatus::get();

        if ($bahagian) {
            $pengesahan = EtraIsytihar::with('etraPengguna', 'etraStatus')
                ->where('isy_status', '!=', 6)
                ->whereHas('etraPengguna', function ($query) use ($bahagian) {
                    $query->where('pen_idbahagian', $bahagian->bah_id);
                })
                ->latest()
                ->orderBy('isy_status')
                ->get();
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $pengesahan
            ]);
        }

        return view('pages.pentadbir-latihan-pengesahan', compact('status'));
    }

    public function show($id)
    {
        $isytihar = EtraIsytihar::with('etraPengguna')
            ->where('isy_id', $id)->first();
        $pengguna = EtraPengguna::with('etraJabatan', 'etraBahagian')
            ->where('pen_idusers', $isytihar->isy_idusers)->first();

        return response()->json([
            'isytihar' => $isytihar,
            'pengguna' => $pengguna
        ]);
    }

    public function update(Request $request, $id)
    {
        $isytihar = EtraIsytihar::findOrFail($id);
        if ($isytihar) {
            $isytihar->update(['isy_status' => $request->isy_status]);
        }
    }

    public function destroy($id)
    {
        $isytihar = EtraIsytihar::find($id);

        if (!$isytihar) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $isytihar->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
