<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EtraKategori;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = EtraKategori::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $kategori
            ]);
        }

        return view('settings.tetapan-kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategori = EtraKategori::where('kat_id', $id)->firstOrFail();
        return response()->json($kategori);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'kat_id' => 'nullable|integer|exists:etra_kategori,kat_id',
                'kat_keterangan' => 'required|string',
            ]);

            $kategori = EtraKategori::updateOrCreate(
                ['kat_id' => $request->kat_id],
                [
                    'kat_keterangan' => $request->kat_keterangan,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully.',
                'data' => $kategori
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = EtraKategori::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $kategori->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
