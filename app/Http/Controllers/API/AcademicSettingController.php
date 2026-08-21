<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademicSettingController extends Controller
{
    public function index(){
        $config =SystemConfiguration::firstOrCreate(
            ['id' => 1],
            ['active_cycle' => '1', 'is_schedule_locked' => false]
        );

        return response()->json([
            'success' => true,
            'message' => 'Data pengaturan akademic berhasil diambil',
            'data' => $config
        ], 200);
    }

    public function update(Request $request){
        if($request->user()->role_id !== 1){
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolakk'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'active_cycle' => 'required|in:1,2',
            'is_schedule_locked' => 'required|boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors() 
            ]);
        }

        $config = SystemConfiguration::first();

        if(!$config){
            $config = new SystemConfiguration();
        }

        $config->update([
            'active_cycle' => $request->active_cycle,
            'is_schedule_locked' => $request->is_schedule_locked,
            'updated_by' => $request->user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi sistem berhasil diperbarui.',
            'data' => $config
        ], 200);
    }
}