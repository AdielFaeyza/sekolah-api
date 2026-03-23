<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\JadwalController;

// ================= AUTH =================
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ================= PUBLIC (GET ONLY) =================
Route::get('guru', [GuruController::class, 'index']);
Route::get('guru/{id}', [GuruController::class, 'show']);

Route::get('mapel', [MapelController::class, 'index']);
Route::get('mapel/{id}', [MapelController::class, 'show']);

Route::get('kelas', [KelasController::class, 'index']);
Route::get('kelas/{id}', [KelasController::class, 'show']);

Route::get('siswa', [SiswaController::class, 'index']);
Route::get('siswa/{id}', [SiswaController::class, 'show']);

Route::get('jadwal', [JadwalController::class, 'index']);
Route::get('jadwal/{id}', [JadwalController::class, 'show']);


// ================= PROTECTED =================
Route::middleware(['jwt.verify'])->group(function () {

    // auth user
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    // GURU
    Route::post('guru', [GuruController::class, 'store']);
    Route::put('guru/{id}', [GuruController::class, 'update']);
    Route::delete('guru/{id}', [GuruController::class, 'destroy']);

    // MAPEL
    Route::post('mapel', [MapelController::class, 'store']);
    Route::put('mapel/{id}', [MapelController::class, 'update']);
    Route::delete('mapel/{id}', [MapelController::class, 'destroy']);

    // KELAS
    Route::post('kelas', [KelasController::class, 'store']);
    Route::put('kelas/{id}', [KelasController::class, 'update']);
    Route::delete('kelas/{id}', [KelasController::class, 'destroy']);

    // SISWA
    Route::post('siswa', [SiswaController::class, 'store']);
    Route::put('siswa/{id}', [SiswaController::class, 'update']);
    Route::delete('siswa/{id}', [SiswaController::class, 'destroy']);

    // JADWAL
    Route::post('jadwal', [JadwalController::class, 'store']);
    Route::put('jadwal/{id}', [JadwalController::class, 'update']);
    Route::delete('jadwal/{id}', [JadwalController::class, 'destroy']);
});