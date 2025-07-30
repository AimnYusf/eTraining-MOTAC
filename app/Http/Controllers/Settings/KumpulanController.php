<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EtraKumpulan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class KumpulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kumpulan = EtraKumpulan::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $kumpulan
            ]);
        }

        return view('settings.tetapan-kumpulan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kumpulan = EtraKumpulan::where('kum_id', $id)->firstOrFail();
        return response()->json($kumpulan);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'kum_id' => 'nullable|integer|exists:etra_kumpulan,kum_id',
                'kum_ketpenu' => 'required|string'
            ]);

            $kumpulan = EtraKumpulan::updateOrCreate(
                ['kum_id' => $request->kum_id],
                [
                    'kum_ketpenu' => $request->kum_ketpenu
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully.',
                'data' => $kumpulan
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
        $kumpulan = EtraKumpulan::find($id);

        if (!$kumpulan) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $kumpulan->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
