<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\RabSubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BendaharaRabSubKegiatan extends Controller
{
    public function getAllSubKegiatan()
    {
        $datas = RabSubKegiatan::with('subItem')->get();
        return response()->json($datas);
    }


    public function creatSubKegiatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nama_item' => 'required',
            'jumlah' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = RabSubKegiatan::create([
            "nama" => $request->nama,
            "jumlah" => $request->jumlah,
            "nama_item" => $request->nama_item,
        ]);
        return response()->json(['message' => 'Data Berhasil Ditambahkan', 'data' => $data], 200);
    }

    public function getSubKegiatanById($id)
    {
        $data = RabSubKegiatan::with('subItem')->where('id', $id)->first();
        return response()->json($data);
    }

    public function updateSubKegiatan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nama_item' => 'required',
            'jumlah' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = RabSubKegiatan::where('id', $id)->first();
        $data->update([
            "nama" => $request->nama,
            "jumlah" => $request->jumlah,
            "nama_item" => $request->nama_item,
        ]);

        return response()->json(['message' => 'Data Berhasil Diupdate', 'data' => $data], 200);
    }

    public function destroySubKegiatan($id)
    {
        $data = RabSubKegiatan::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus'], 200);
    }
}
