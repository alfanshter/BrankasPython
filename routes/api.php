<?php

use App\Http\Controllers\FacePrintController;
use App\Http\Controllers\FingerprintController;
use App\Http\Controllers\PenggunaControler;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SelenoidController;
use App\Http\Controllers\StatusAlatController;
use App\Http\Controllers\VoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/adduser', [PenggunaControler::class, 'adduser']);
Route::post('/deleteuser', [PenggunaControler::class, 'deleteuser']);
Route::get('/readuser', [PenggunaControler::class, 'readuser']);

Route::post('/status', [StatusAlatController::class, 'store']);
Route::get('/status', [StatusAlatController::class, 'index']);

Route::post('/register_finger', [FingerprintController::class, 'register_finger']);
Route::post('/check_finger', [FingerprintController::class, 'check_finger']);
Route::get('/read_finger', [FingerprintController::class, 'read_finger']);

Route::post('/check_voice', [VoiceController::class, 'check_voice']);
Route::post('/register_voice', [VoiceController::class, 'register_voice']);
Route::get('/read_voice', [VoiceController::class, 'read_voice']);

Route::post('/register_face', [FacePrintController::class, 'register_face']);
Route::post('/check_face', [FacePrintController::class, 'check_face']);
Route::get('/read_face', [FacePrintController::class, 'read_face']);

Route::post('/security', [SecurityController::class, 'security']);
Route::get('/read_security', [SecurityController::class, 'read_security']);

Route::post('/selenoid', [SelenoidController::class, 'store']);
Route::get('/selenoid', [SelenoidController::class, 'index']);