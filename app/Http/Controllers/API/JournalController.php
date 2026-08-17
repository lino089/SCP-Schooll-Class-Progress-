<?php

namespace App\Http\Controllers\APi;

use App\Models\Attendance;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class JournalController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'notes' => 'required|string',

            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,sakit,izin,alfa'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 422);
        }

        // DB Transaction
        try {
            DB::beginTransaction();

            $journal = Journal::create([
                'schedule_id' => $request->schedule_id,
                'teacher_id' => $request->user()->id,
                'date' => $request->date,
                'topic' => $request->topic,
                'notes' => $request->notes
            ]);

            foreach ($request->attendances as $attendance){
                Attendance::create([
                    'journal_id' => $journal->id,
                    'student_id' => $attendance['student_id'],
                    'status' => $attendance['status']  
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jurnal dan Absensi berhasil disimpan.'
            ], 201);
        } catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
