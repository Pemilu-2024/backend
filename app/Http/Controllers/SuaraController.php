<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suara;
use App\Models\Tps;
use Illuminate\Support\Facades\DB;

class SuaraController extends Controller
{

public function listSuara()
{
    try {
        // Hitung jumlah suara berdasarkan kandidatId
        $jumlahSuaraPerKandidat = DB::table('suaras')
            ->select('kandidatId', DB::raw('SUM(jumlahSuara) as total_suara'))
            ->groupBy('kandidatId')
            ->get();

        // Format hasil sesuai kebutuhan Anda
        $result = [];
        foreach ($jumlahSuaraPerKandidat as $data) {
            $result[] = [
                'kandidatId' => $data->kandidatId,
                'totalSuara' => $data->total_suara,
            ];
        }

        return response()->json(['message' => 'Berhasil mendapatkan jumlah suara', 'data' => $result], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan saat mengambil data suara', 'error' => $e->getMessage()], 500);
    }
}


    public function inputSuara(Request $request)
    {
        $validateData = $request->validate([
            '*.jumlahSuara' => 'required',
            '*.tpsId' => 'required',
            '*.kandidatId' => 'required'
        ]);

        try {
            $idTps='0';
            foreach ($request->all() as $input) {
                if (!isset($input['jumlahSuara'], $input['tpsId'], $input['kandidatId'])) {
                    return response()->json(['message' => 'Input tidak valid. Setiap objek harus memiliki jumlahSuara, tpsId, dan kandidatId.'], 400);
                }
                
                $jumlahSuara = $input['jumlahSuara'];
                $tpsId = $input['tpsId'];
                $idTps = $tpsId;
                $kandidatId = $input['kandidatId'];

                // cek apakah tps sudah di isi
                $status = TPS::where('id', $idTps)->value('status');
                if ($status == '0') {
                    Suara::create(['jumlahSuara' => $jumlahSuara, 'tpsId' => $tpsId, 'kandidatId' => $kandidatId]);
                }else{
                    return response()->json(['message' => 'Pengisian suara gagal, Suara di tps ini sudah diisi sebelumnya'], 400);
                }
            }
            
            TPS::where('id', $idTps)->update(['status' => '1']);
            // update data tps berdasarkan tpsId
            // ubah statusnya menjadi '1'
            // $tpsIds = array_unique(array_column($request->validated(), 'tpsId')); // Ambil tpsId yang unik

            return response()->json(['message' => 'Suara berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function formatApiResponse($data, $message, $statusCode)
    {
        if ($data) {
            return FormatApi::ApiCreate($statusCode, $message, $data);
        } else {
            return FormatApi::ApiCreate($statusCode, $message);
        }
    }
}
