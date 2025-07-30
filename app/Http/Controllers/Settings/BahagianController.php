<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EtraBahagian;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class BahagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bahagian = EtraBahagian::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $bahagian
            ]);
        }

        return view('settings.tetapan-bahagian');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bahagian = EtraBahagian::where('bah_id', $id)->firstOrFail();
        return response()->json($bahagian);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'bah_id' => 'nullable|integer|exists:etra_bahagian,bah_id',
                'bah_ketring' => 'required|string',
                'bah_ketpenu' => 'required|string'
            ]);

            $bahagian = EtraBahagian::updateOrCreate(
                ['bah_id' => $request->bah_id],
                [
                    'bah_ketring' => $request->bah_ketring,
                    'bah_ketpenu' => $request->bah_ketpenu
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully.',
                'data' => $bahagian
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
        $bahagian = EtraBahagian::find($id);

        if (!$bahagian) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $bahagian->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
