<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KuisionerController extends Controller
{
    public function index()
    {
        // Ambil semua pertanyaan
        $pertanyaan = DB::table('pertanyaan')->select('id', 'teks_pertanyaan')->get();

        // Ambil semua opsi, dikelompokkan berdasarkan id_pertanyaan
        $opsi = DB::table('opsi_pertanyaan')
            ->select('id', 'id_pertanyaan', 'teks_opsi')
            ->get()
            ->groupBy('id_pertanyaan');

        // Gabungkan pertanyaan dengan opsinya
        $result = $pertanyaan->map(function ($item) use ($opsi) {
            return [
                'id' => $item->id,
                'teks_pertanyaan' => $item->teks_pertanyaan,
                'opsi' => $opsi[$item->id] ?? []
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    public function simpanJawaban(\Illuminate\Http\Request $request)
{
    $request->validate([
        'user_id' => 'required|integer',
        'jawaban' => 'required|array',
        'jawaban.*.pertanyaan_id' => 'required|integer',
        'jawaban.*.opsi_id' => 'required|integer',
    ]);

    // Ambil jumlah pertanyaan di DB
    $jumlahPertanyaan = DB::table('pertanyaan')->count();

    // Cek apakah jumlah jawaban sesuai jumlah pertanyaan
    if (count($request->jawaban) < $jumlahPertanyaan) {
        return response()->json([
            'success' => false,
            'message' => 'Semua pertanyaan wajib dijawab.'
        ], 422);
    }

    // Persiapkan data untuk insert bulk
    $dataInsert = [];
    foreach ($request->jawaban as $item) {
        $dataInsert[] = [
            'user_id' => $request->user_id,
            'pertanyaan_id' => $item['pertanyaan_id'],
            'opsi_id' => $item['opsi_id'],
        ];
    }

    // Simpan ke database
    DB::table('jawaban_user')->insert($dataInsert);

    return response()->json([
        'success' => true,
        'message' => 'Jawaban berhasil disimpan.'
    ]);
}

}
