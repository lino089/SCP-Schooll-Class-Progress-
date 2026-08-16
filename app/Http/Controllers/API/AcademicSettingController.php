<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SystemConfiguration;
use Illuminate\Http\Request;

class AcademicSettingController extends Controller
{
    public function index(){
        $config =SystemConfiguration::first();

        return response()->json([
            'success' => true,
            'message' => 'Data pengaturan akademic berhasil diambil',
            'data' => $config
        ], 200);
    }
}
