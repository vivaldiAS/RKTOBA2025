<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KuisionerController extends Controller
{
    public function index()
    {
        $pertanyaan = DB::table('pertanyaan')->select('id', 'teks_pertanyaan')->get();

        $opsi = DB::table('opsi_pertanyaan')
            ->select('id', 'id_pertanyaan', 'teks_opsi')
            ->get()
            ->groupBy('id_pertanyaan');

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

    public function simpanJawaban(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'jawaban' => 'required|array',
            'jawaban.*.pertanyaan_id' => 'required|integer',
            'jawaban.*.opsi_id' => 'required|array|min:1',
            'jawaban.*.opsi_id.*' => 'integer',
        ]);

        $jumlahPertanyaan = DB::table('pertanyaan')->count();

        if (count($request->jawaban) < $jumlahPertanyaan) {
            return response()->json([
                'success' => false,
                'message' => 'Semua pertanyaan wajib dijawab.'
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($request->jawaban as $item) {
                // Simpan jawaban_user
                $jawabanUserId = DB::table('jawaban_user')->insertGetId([
                    'user_id' => $request->user_id,
                    'pertanyaan_id' => $item['pertanyaan_id'],
                ]);

                // Siapkan opsi
                $opsiInsert = [];
                foreach ($item['opsi_id'] as $opsiId) {
                    $opsiInsert[] = [
                        'jawaban_user_id' => $jawabanUserId,
                        'opsi_id' => $opsiId,
                    ];
                }

                // Simpan ke jawaban_user_opsi
                DB::table('jawaban_user_opsi')->insert($opsiInsert);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan jawaban.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
