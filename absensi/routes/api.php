use App\Http\Controllers\Api\AbsensiController;

Route::get('absensi', [AbsensiController::class, 'index']);
Route::post('absensi', [AbsensiController::class, 'store']);
Route::put('absensi/{id}', [AbsensiController::class, 'update']);
Route::delete('absensi/{id}', [AbsensiController::class, 'destroy']);
