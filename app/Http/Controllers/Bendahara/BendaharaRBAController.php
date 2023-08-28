<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\RabBendahara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BendaharaRBAController extends Controller
{
    public function index()
    {
        $datas = RabBendahara::latest()->get();
        return response()->json($datas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kebutuhan' => 'required',
            'qty' => 'required',
            'biaya' => 'required',
            'tanggal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total = 0;
        $jumlah = $request->qty * $request->biaya;
        $total += $jumlah;
        $data = RabBendahara::create([
            'nama_kebutuhan' => $request->nama_kebutuhan,
            'qty' => $request->qty,
            'biaya' => $request->biaya,
            'jumlah' => $jumlah,
            'total' => $total,
            'tanggal' => $request->tanggal,
        ]);


        return response()->json(['massage' => 'Data Berhasih Dibuat', 'data' => $data]);
    }

    public function show($id)
    {
        $datas = RabBendahara::where('id', $id)->first();
        return response()->json($datas);
    }

    public function update(Request $request, $id)
    {
        $datas = RabBendahara::where('id', $id)->first();
        $datas->update([
            'nama_kebutuhan' => $request->nama_kebutuhan,
            'qty' => $request->qty,
            'biaya' => $request->biaya,
            'tanggal' => $request->tanggal,
        ]);
        return response()->json(['massage' => 'Data Berhasil Diubah', 'data' => $datas]);
    }

    public function destroy($id)
    {
        $datas = RabBendahara::where('id', $id)->first();
        $datas->delete();
        return response()->json(['massage' => 'Data Berhasil Didelete']);
    }
}
