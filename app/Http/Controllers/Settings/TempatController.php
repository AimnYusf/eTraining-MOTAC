<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EproTempat;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tempat = EproTempat::orderBy('tem_keterangan', 'asc')->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $tempat
            ]);
        }

        return view('settings.tetapan-tempat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tempat = EproTempat::where('tem_id', $id)->firstOrFail();
        return response()->json($tempat);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'tem_id' => 'nullable|integer|exists:epro_tempat,tem_id',
                'tem_keterangan' => 'required|string|max:255',
                'tem_alamat' => 'nullable|string',
                'tem_gmaps' => 'nullable|url'
            ]);

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
        $tempat = EproTempat::find($id);

        if (!$tempat) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $tempat->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
