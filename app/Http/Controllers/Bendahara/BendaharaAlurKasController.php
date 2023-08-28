<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\AlurKas;
use Illuminate\Http\Request;

class BendaharaAlurKasController extends Controller
{
    public function index()
    {
        $datas = AlurKas::latest()->get();
        return response()->json($datas);
    }

    public function store(Request $request)
    {
        $total = $request->pemasukan - $request->pengeluaran;

        $datas = AlurKas::create([
            "nama_transaksi" => $request->nama_transaksi,
            "kategori_transaksi" => $request->kategori_transaksi,
            "tanggal" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "pemasukan" => $request->pemasukan,
            "pengeluaran" => $request->pengeluaran,
            // "nominal" => $request->nominal,
            // "jumlah" => $request->jumlah,
            "total" => $total,

        ]);
        return response()->json($datas);
    }
    public function show($id)
    {
        $data = AlurKas::where('id', $id)->first();
        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        $data = AlurKas::where('id', $id)->first();
        $total = $request->nominal * $request->jumlah;
        $data->update([
            "kategori_transaksi" => $request->kategori_transaksi,
            "tanggal" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "pemasukan" => $request->pemasukan,
            "pengeluaran" => $request->pengeluaran,
            "nominal" => $request->nominal,
            "jumlah" => $request->jumlah,
            "total" => $total,
        ]);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = AlurKas::where('id', $id)->first();
        $data->delete();
        return response()->json($data);
    }
}
