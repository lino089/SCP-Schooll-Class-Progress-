<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // ============================================================
        // 1. VALIDASI INPUT
        // ============================================================
        // Memastikan data yang dikirim oleh client memenuhi syarat.
        //
        // username    -> wajib diisi
        // password    -> wajib diisi
        // device_name -> wajib diisi
        //
        // Jika salah satu field tidak dikirim, proses login
        // tidak akan dilanjutkan.
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        // ============================================================
        // 2. CEK HASIL VALIDASI
        // ============================================================
        // Jika validasi gagal, API akan mengembalikan response
        // dengan status HTTP 422 (Unprocessable Entity).
        //
        // $validator->errors()
        // berisi informasi field mana saja yang mengalami error.
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => [
                    'field' => $validator->errors()
                ]
            ], 422);
        }

        // ============================================================
        // 3. MENCARI USER BERDASARKAN USERNAME
        // ============================================================
        // Mencari satu user di database berdasarkan username
        // yang dikirim oleh client.
        //
        // first() akan mengambil data user pertama yang ditemukan.
        // Jika user tidak ditemukan, nilainya akan menjadi null.
        $user = User::where('username', $request->username)->first();

        // ============================================================
        // 4. MEMERIKSA USERNAME DAN PASSWORD
        // ============================================================
        // Ada dua kondisi yang menyebabkan login gagal:
        //
        // a. User tidak ditemukan
        // b. Password yang dikirim tidak cocok dengan password
        //    yang tersimpan di database.
        //
        // Hash::check() digunakan untuk membandingkan password
        // plaintext dari request dengan password yang sudah
        // di-hash di database.
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah',
                'errors' => [
                    'field' => ['']
                ]
            ], 401);
        }


        // ============================================================
        // 5. MEMBUAT TOKEN AUTENTIKASI
        // ============================================================
        // Jika username dan password benar, Laravel Sanctum
        // membuat Personal Access Token untuk user tersebut.
        //
        // $request->device\_name
        // digunakan sebagai nama token/perangkat agar token
        // dapat dibedakan berdasarkan device yang digunakan.
        //
        // plainTextToken
        // mengambil token dalam bentuk plaintext yang akan
        // dikirimkan kembali kepada client.
        $token = $user->createToken($request->device_name)->plainTextToken;

        // ============================================================
        // 6. MENGEMBALIKAN RESPONSE LOGIN BERHASIL
        // ============================================================
        // Jika seluruh proses berhasil, API mengembalikan:
        //
        // success -> menandakan login berhasil
        // message -> pesan informasi
        // data    -> berisi token dan informasi user
        //
        // HTTP status 200 berarti request berhasil diproses.
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ], 200);
    }
}
