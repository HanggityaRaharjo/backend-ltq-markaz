<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\AlurKas;
use App\Models\Bendahara\KategoriTransaksi;
use Illuminate\Http\Request;

class BendaharaKategoriTransaksiController extends Controller
{

    public function index()
    {

        $data = KategoriTransaksi::latest()->get();
        return response()->json($data);
    }


    public function store(Request $request)
    {
        $data = KategoriTransaksi::create([
            "nama_kategori" => $request->nama_kategori,
        ]);
        return response()->json($data);
    }

    public function show($id)
    {
        $data = KategoriTransaksi::where('id', $id)->first();
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = KategoriTransaksi::where('id', $id)->first();
        $data->nama_kategori = $request->nama_kategori;
        $data->update();

        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = KategoriTransaksi::where('id', $id)->first();
        $data->delete();

        return response()->json($data);
    }
}
