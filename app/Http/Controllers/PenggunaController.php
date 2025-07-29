<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EproPengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $authRole = Auth::user()->role;

        $pengguna = EproPengguna::with(['user.etraPeranan', 'eproBahagian'])
            ->whereHas('user', function ($query) use ($authRole) {
                $query->where('id', '!=', Auth::id())
                    ->where('role', '<=', $authRole); // or any condition you want
            })
            ->get();


        if ($request->ajax()) {
            return response()->json([
                'data' => $pengguna
            ]);
        }

        Log::info($pengguna->toArray());
        return view('pages.urusetia-pengguna');
    }

    public function show($id)
    {
        $pengguna = EproPengguna::with('user', 'eproKumpulan', 'eproBahagian', 'eproJabatan')
            ->where('pen_id', $id)
            ->first();
        return response()->json($pengguna);
    }

    public function update(Request $request, $id)
    {
        $pengguna = EproPengguna::where('pen_id', $id)->first();
        if ($pengguna) {
            // Update user's role
            $pengguna->user->role = $request->role;
            $pengguna->user->save();
        }
    }
}
