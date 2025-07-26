<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\EtraUrusetia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class UrusetiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $urusetia = EtraUrusetia::get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $urusetia
            ]);
        }

        return view('settings.tetapan-urusetia');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $urusetia = EtraUrusetia::where('pic_id', $id)->firstOrFail();
        return response()->json($urusetia);
    }

    /**
     * Store a newly created resource in storage or update an existing one.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'pic_id' => 'nullable|integer|exists:etra_urusetia,pic_id',
                'pic_nama' => 'required|string',
                'pic_emel' => 'required|email',
                'pic_notel' => 'required|string',
            ]);

            $urusetia = EtraUrusetia::updateOrCreate(
                ['pic_id' => $request->pic_id],
                [
                    'pic_nama' => $request->pic_nama,
                    'pic_emel' => $request->pic_emel,
                    'pic_notel' => $request->pic_notel
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully.',
                'data' => $urusetia
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
        $urusetia = EtraUrusetia::find($id);

        if (!$urusetia) {
            return response()->json(['message' => 'Rekod tidak dijumpai.'], 404);
        }

        $urusetia->delete();

        return response()->json(['message' => 'Rekod berjaya dipadam.']);
    }
}
