<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\SuaraController;
use App\Http\Controllers\FeedbackController;

Route::group([
    'prefix' => 'auth'
  ], function () {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::group([
      'middleware' => 'auth:api'
    ], function(){
      Route::get('list-users', [AuthController::class,'listAllUser']);
      Route::get('list-user-notverify', [AuthController::class,'listUserVerify']);
      Route::delete('delete-user/{id}', [AuthController::class,'delete']);
      
      Route::post('verify-access/{id}', [AuthController::class,'verifyAccess']);
      Route::post('logout', [AuthController::class,'logout']);
      Route::post('refresh', [AuthController::class, 'refresh']);
      Route::get('me', [AuthController::class,'me']);
      
      Route::group([
        'middleware' => 'auth:api'
      ], function () {
        // main route
        Route::get('list-tps', [TpsController::class,'listTps']);
        Route::get('detail-tps/{id}', [TpsController::class,'detailTps']);
        Route::post('create-tps', [TpsController::class,'createTps']);
        Route::post('update-tps/{id}', [TpsController::class,'updateTps']);
        Route::delete('delete-tps/{id}', [TpsController::class,'deleteTps']);
        
        Route::get('list-konten', [KontenController::class,'listKonten']);
        Route::get('detail-konten/{id}', [KontenController::class,'detailKonten']);
        Route::post('reaksi-konten/{id}', [KontenController::class,'reaksiKonten']);
        Route::post('reaksi-konten', [KontenController::class,'reaksiKonten']);
        Route::post('komen-konten/{id}', [KontenController::class,'komenKonten']);
        Route::post('create-konten', [KontenController::class,'createKonten']);
        Route::get('list-komen-konten/{id}', [KontenController::class,'listKomenbyIdKonten']);
        Route::post('islike', [KontenController::class,'isLike']);
      
        Route::get('list-suara', [SuaraController::class,'listSuara']);
        Route::post('/input-suara', [SuaraController::class,'inputSuara']);

        Route::get('list-kandidat', [KandidatController::class,'listKandidat']);
        Route::get('detail-kandidat/{id}', [KandidatController::class,'detailKandidat']);
        Route::post('create-kandidat', [KandidatController::class,'createKandidat']);
        Route::post('update-kandidat/{id}', [KandidatController::class,'updateKandidat']);
        Route::delete('delete-kandidat/{id}', [KandidatController::class,'deleteKandidat']);

        Route::post('create-feedback', [FeedbackController::class,'createFeedback']);
        Route::get('list-feedback', [FeedbackController::class,'listFeedback']);
      });
      
    });
  });
  

