<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EproKehadiran;
use App\Models\EproKursus;
use App\Models\EproPermohonan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $kid = $request->query('kid');

        if ($kid != null) {
            $kursus = EproKursus::where('kur_id', $kid)->first();
            $permohonan = EproPermohonan::with([
                'eproPengguna.eproJabatan',
                'eproPengguna.etraKumpulan',
                'etraStatus',
                'eproKursus',
                'eproPengguna.eproKehadiran' => function ($query) use ($kid) {
                    $query->where('keh_idkursus', $kid);
                }
            ])
                ->where('per_idkursus', $kid)
                ->where('per_status', 4)
                ->get();

            // dd($permohonan->toArray());
            if ($request->ajax()) {
                return response()->json([
                    'data' => $permohonan
                ]);
            }
            return view('pages.urusetia-kehadiran-pegawai', compact('kursus', 'permohonan', ));
        }

        return view('pages.urusetia-kehadiran');
    }

    // public function show($id)
    // {
    //     return response()->json($kursus);
    // }

    public function store(Request $request)
    {
        $keh_tkhmasuk = $request->keh_tkhmasuk
            ? Carbon::createFromFormat('d/m/Y', $request->keh_tkhmasuk)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        EproKehadiran::create([
            'keh_idusers' => $request->keh_idusers,
            'keh_idkursus' => $request->keh_idkursus,
            'keh_tkhmasuk' => $keh_tkhmasuk,
        ]);
    }

    public function update(Request $request)
    {
        $kursusId = $request->input('kursus_id');
        $attendanceData = $request->input('attendance');

        if (!$kursusId || !is_array($attendanceData)) {
            return redirect()->back()->with('error', 'Invalid attendance data provided.');
        }

        DB::beginTransaction();

        try {
            foreach ($attendanceData as $userId => $dates) {
                foreach ($dates as $date => $attended) {
                    $date = Carbon::parse($date)->format('Y-m-d');

                    if ($attended) {
                        EproKehadiran::firstOrCreate([
                            'keh_idusers' => $userId,
                            'keh_idkursus' => $kursusId,
                            'keh_tkhmasuk' => $date,
                        ]);
                    } else {
                        EproKehadiran::where('keh_idusers', $userId)
                            ->where('keh_idkursus', $kursusId)
                            ->where('keh_tkhmasuk', $date)
                            ->delete();
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Attendance updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update attendance.');
        }
    }
}
