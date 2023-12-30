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
    // $request->validate([
    //     '*.jumlahSuara' => 'numeric|required_with:*.tpsId,*.kandidatId',
    //     '*.tpsId' => 'numeric|required_with:*.jumlahSuara,*.kandidatId',
    //     '*.kandidatId' => 'numeric|required_with:*.jumlahSuara,*.tpsId',
    //     '*.bukti_suara' => 'required_without:*.jumlahSuara,*.tpsId,*.kandidatId|image|mimes:jpeg,png,jpg,gif|max:2048'
    // ]);

    // try {
    //     $idTps = '0';
    //     foreach ($request->input('data') as $input) {

    //         // Periksa apakah objek memiliki bukti_suara
    //         if (isset($input['bukti_suara'])) {
    //             $buktiSuaraBase64 = $input['bukti_suara'];
                
    //             // Decode Base64 dan simpan sebagai file
    //             $buktiSuaraBinary = base64_decode($buktiSuaraBase64);
    //             $imageName = uniqid() . '.jpg'; // Nama file unik
    //             $path = storage_path('app/public/bukti_suara/' . $imageName);
                
    //             file_put_contents($path, $buktiSuaraBinary);

    //             // Update kolom bukti_suara pada TPS
    //             $tps = TPS::find($idTps);
    //             $tps->bukti_suara = $imageName;
    //             $tps->save();
    //         } else {
    //             if (!isset($input['jumlahSuara'], $input['tpsId'], $input['kandidatId'])) {
    //                 return response()->json(['message' => 'Input tidak valid. Setiap objek harus memiliki jumlahSuara, tpsId, dan kandidatId.'], 400);
    //             }

    //             $jumlahSuara = $input['jumlahSuara'];
    //             $tpsId = $input['tpsId'];
    //             $idTps = $tpsId;
    //             $kandidatId = $input['kandidatId'];

    //             // cek apakah tps sudah diisi
    //             $status = TPS::where('id', $idTps)->value('status');
    //             if ($status == '0') {
    //                 Suara::create(['jumlahSuara' => $jumlahSuara, 'tpsId' => $tpsId, 'kandidatId' => $kandidatId]);
    //             } else {
    //                 return response()->json(['message' => 'Pengisian suara gagal, Suara di tps ini sudah diisi sebelumnya'], 400);
    //             }
    //         }
    //     }

    //     TPS::where('id', $idTps)->update(['status' => '1']);
        
    //     return response()->json(['message' => 'Suara berhasil disimpan'], 200);
    // } catch (\Exception $e) {
    //     return response()->json(['message' => $e->getMessage()], 500);
    // }
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
