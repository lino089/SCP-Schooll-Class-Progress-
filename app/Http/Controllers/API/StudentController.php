<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

class StudentController extends Controller
{
    public function index(){
        $students = User::where('role_id', 4)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data siswa',
            'data' => $students
        ], 200);
    }
}
