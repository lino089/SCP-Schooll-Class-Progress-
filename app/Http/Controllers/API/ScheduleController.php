<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SystemConfiguration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function store(Request $request){
        $config = SystemConfiguration::first();

        if($config && $config->is_schedule_locked === true){
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Jadwal sedang dikunci oleh waka kurikulum.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'room_id' => 'required|integer',
            'day_of_week' => 'required|string',

            //validasi format waktu
            'start_time' => 'required|date_format:H:i',

            'end_time' => 'required|date_format:H:i|after:start_time',

            'cycle_type' => 'required|integer|in:1,2'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, silahkan cek kembali data Anda.',
                'error' => $validator->errors()
            ], 422);
        }

        $isConflict = Schedule::where('cycle_type', $request->cycle_type)
            ->where('day_of_week', $request->day_of_week)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->where(function ($query) use ($request){
                $query->where('room_id',$request->room_id)
                    ->orWhere('class_id', $request->class_id)
                    ->orWhere('teacher_id', $request->user()->id);
            })
            ->exists();

        if($isConflict){
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Bentrok! Ruangan, Kelas, atau Guru sudah memiliki jadwal pada rentang waktu tersebut.'
            ], 422);
        }

        $schedule = Schedule::create([
            'teacher_id' => $request->user()->id,
            'class_id' => $request->class_id,
            'room_id' => $request->room_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'cycle_type' => $request->cycle_type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Berhasil dibuat',
            'data' => $schedule
        ], 201);
    }
    

    public function index(Request $request){
        $user = $request->user();

        $query = Schedule::query();

        if($user->role_id === 2){
            $query->where('teacher_id', $user->id);
        }

        if ($request->has('cycle')){
            $query->where('cycle_type', $request->query('cycle'));
        }

        $schedules = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil diambil.',
            'data' => $schedules
        ], 200);
    }
}
