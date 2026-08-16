<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;


class SchoolClassController extends Controller
{
    public function index()
    {
        $data = SchoolClass::all();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kelas',
            'data' => $data
        ], 200);
    }
}
