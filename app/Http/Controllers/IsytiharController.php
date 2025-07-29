<?php

namespace App\Http\Controllers;

use App\Models\EproIsytihar;
use App\Models\EtraStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsytiharController extends Controller
{
    public function index(Request $request)
    {
        $isytihar = EproIsytihar::with('eproPengguna', 'etraStatus')
            ->where('isy_idusers', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $status = EtraStatus::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $isytihar
            ]);
        }

        return view('pages.pengguna-isytihar', compact('status'));
    }

    public function show($id)
    {
        $isytihar = EproIsytihar::where('isy_id', $id)->first();
        return response($isytihar);
    }

    public function store(Request $request)
    {
        // format date
        $isy_tkhmula = Carbon::createFromFormat('d/m/Y', $request->isy_tkhmula)->format('Y-m-d');
        $isy_tkhtamat = Carbon::createFromFormat('d/m/Y', $request->isy_tkhtamat)->format('Y-m-d');

        EproIsytihar::updateOrCreate(
            ['isy_id' => $request->isy_id],
            [
                'isy_idusers' => Auth::id(),
                'isy_nama' => $request->isy_nama,
                'isy_tkhmula' => $isy_tkhmula,
                'isy_tkhtamat' => $isy_tkhtamat,
                'isy_jam' => $request->isy_jam,
                'isy_tempat' => $request->isy_tempat,
                'isy_anjuran' => $request->isy_anjuran,
                'isy_status' => $request->isy_status
            ]
        );
    }
}
