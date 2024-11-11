<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    // Menampilkan semua absensi
    public function index()
    {
        $absensi = Absensi::all();
        return response()->json($absensi);
    }

    // Menambah absensi (Check-in)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',  // Validasi user_id harus ada di tabel users
            'check_in' => 'required|date',            // Validasi format check_in
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Membuat absensi baru
        $absensi = Absensi::create([
            'user_id' => $request->user_id,
            'check_in' => $request->check_in,
        ]);

        return response()->json($absensi, 201);
    }

    // Mengupdate absensi untuk check-out
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'check_out' => 'required|date',  // Validasi check_out harus ada
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Mencari absensi berdasarkan ID
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['message' => 'Absensi tidak ditemukan'], 404);
        }

        // Update check-out
        $absensi->check_out = $request->check_out;
        $absensi->save();

        return response()->json($absensi);
    }

    // Menghapus absensi
    public function destroy($id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['message' => 'Absensi tidak ditemukan'], 404);
        }

        // Menghapus absensi
        $absensi->delete();

        return response()->json(['message' => 'Absensi berhasil dihapus']);
    }
}
