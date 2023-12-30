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
    $validator = Validator::make($request->all(), [
        '*.jumlahSuara' => 'numeric|required_with:*.tpsId,*.kandidatId',
        '*.tpsId' => 'numeric|required_with:*.jumlahSuara,*.kandidatId',
        '*.kandidatId' => 'numeric|required_with:*.jumlahSuara,*.tpsId',
        '*.bukti_suara' => 'required_without:*.jumlahSuara,*.tpsId,*.kandidatId|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 400);
    }

    return response()->json(['requestData' => $request->all()], 200);
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
