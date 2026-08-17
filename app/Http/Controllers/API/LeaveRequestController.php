<?php

namespace App\Http\Controllers\API;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class LeaveRequestController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'reason' => 'required|in:sakit,izin',
            'start_date' => 'required|date',
            'end_date' => 'required|after_or_equal:start_date',
            'proof_image' => 'nullable|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal! cek kembali data anda.',
                'error' => $validator->errors()
            ], 422);
        }

        $leaveRequest = LeaveRequest::create([
            'student_id' => $request->user()->id,
            'reason' => $request->reason,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'proof_image' => $request->proof_image
        ]);

        $leaveRequest->refresh();

        return response()->json([
            'success' => 'true',
            'message' => 'Pengajuan izin berhasil dikirim. Menunggu konfirmasi',
            'data' => $leaveRequest 
        ], 201);
    }
}
