<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\Rab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BendaharaRab extends Controller
{
    public function getAllRab()
    {

        $datas = Rab::with('subKegiatan.subItem')->get();
        return response()->json($datas);
    }


    public function creatRab(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required',
            'waktu_pelaksanaan' => 'required',
            'tahun' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = Rab::create([
            "nama_kegiatan" => $request->nama_kegiatan,
            "waktu_pelaksanaan" => $request->waktu_pelaksanaan,
            "tahun" => $request->tahun,
            "jumlah" => $request->jumlah,
        ]);
        return response()->json(['message' => 'Data Berhasil Ditambahkan', 'data' => $data], 200);
    }

    public function getRabById($id)
    {
        $data = Rab::with('subKegiatan.subItem')->where('id', $id)->first();
        return response()->json($data);
    }

    public function updateRab(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required',
            'waktu_pelaksanaan' => 'required',
            'tahun' => 'required',
            'jumlah' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = Rab::where('id', $id)->first();
        $data->update([
            "nama_kegiatan" => $request->nama_kegiatan,
            "waktu_pelaksanaan" => $request->waktu_pelaksanaan,
            "tahun" => $request->tahun,
            "jumlah" => $request->jumlah,
        ]);

        return response()->json(['message' => 'Data Berhasil Diupdate', 'data' => $data], 200);
    }

    public function destroyRab($id)
    {
        $data = Rab::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus'], 200);
    }
}
