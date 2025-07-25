<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EproPenganjur;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class PenganjurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $penganjur = EproPenganjur::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $penganjur
            ]);
        }

        return view('settings.tetapan-penganjur');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penganjur = EproPenganjur::where('pjr_id', $id)->firstOrFail();
        return response()->json($penganjur);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'pjr_id' => 'nullable|integer|exists:epro_penganjur,pjr_id',
                'pjr_keterangan' => 'required|string',
            ]);

            $penganjur = EproPenganjur::updateOrCreate(
                ['pjr_id' => $request->pjr_id],
                [
                    'pjr_keterangan' => $request->pjr_keterangan,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully.',
                'data' => $penganjur
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
        $penganjur = EproPenganjur::find($id);

        if (!$penganjur) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $penganjur->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
