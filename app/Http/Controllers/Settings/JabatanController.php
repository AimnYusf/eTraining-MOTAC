<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EproJabatan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jabatan = EproJabatan::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $jabatan
            ]);
        }

        return view('settings.tetapan-jabatan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jabatan = EproJabatan::where('jab_id', $id)->firstOrFail();
        return response()->json($jabatan);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'jab_id' => 'nullable|integer|exists:epro_jabatan,jab_id',
                'jab_ketring' => 'required|string',
                'jab_ketpenu' => 'nullable|string'
            ]);

            $jabatan = EproJabatan::updateOrCreate(
                ['jab_id' => $request->jab_id],
                [
                    'jab_ketring' => $request->jab_ketring,
                    'jab_ketpenu' => $request->jab_ketpenu
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully.',
                'data' => $jabatan
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
        $jabatan = EproJabatan::find($id);

        if (!$jabatan) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $jabatan->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
