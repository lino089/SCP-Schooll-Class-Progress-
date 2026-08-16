<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SystemConfiguration;
use App\Http\Controllers\Controller;

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


        return response()->json([
            'success' => true,
            'message' => 'Gerbang terbuka'
        ], 200);
    }
    
}
