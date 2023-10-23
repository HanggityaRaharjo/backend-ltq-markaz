<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\RabSubItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BendaharaRabSubItem extends Controller
{
    public function getAllSubItem()
    {

        $datas = RabSubItem::latest()->get();
        return response()->json($datas);
    }


    public function creatSubItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_item' => 'required',
            'quantity' => 'required',
            'harga' => 'required',
            'type_quantity' => 'required',
            'jumlah' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = RabSubItem::create([
            "nama_item" => $request->nama_item,
            "quantity" => $request->quantity,
            "harga" => $request->harga,
            "type_quantity" => $request->type_quantity,
            "jumlah" => $request->jumlah,
        ]);
        return response()->json(['message' => 'Data Berhasil Ditambahkan', 'data' => $data], 200);
    }

    public function getSubItemById($id)
    {
        $data = RabSubItem::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateSubItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_item' => 'required',
            'quantity' => 'required',
            'harga' => 'required',
            'type_quantity' => 'required',
            'jumlah' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = RabSubItem::where('id', $id)->first();
        $data->update([
            "nama_item" => $request->nama_item,
            "quantity" => $request->quantity,
            "harga" => $request->harga,
            "type_quantity" => $request->type_quantity,
            "jumlah" => $request->jumlah,
        ]);

        return response()->json(['message' => 'Data Berhasil Diupdate', 'data' => $data], 200);
    }

    public function destroySubItem($id)
    {
        $data = RabSubItem::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus'], 200);
    }
}
