<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Barang;
use App\Models\TataUsaha\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TataUsahaBarangKeluarController extends Controller
{
    public function GetDataBarangKeluar()
    {
        $BarangKeluar = BarangKeluar::with('barang')->get();
        return response()->json($BarangKeluar);
    }

    public function CreateDataBarangKeluar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_keluar' => 'required',
            'jumlah_barang_keluar' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Ambil informasi barang
        $barang = Barang::findOrFail($request->barang_id);

        // Merekam barang masuk
        $BarangKeluar = BarangKeluar::create([
            'barang_id' => $barang->id,
            'tanggal_keluar' => now(),
            'jumlah_barang_keluar' => $request->jumlah_barang_keluar,
            'deskripsi' => $request->deskripsi,
        ]);

        // Update stok barang
        $barang->stok -= $request->jumlah_barang_keluar;
        $barang->save();

        return response()->json(['message' => 'Barang masuk berhasil dicatat']);
    }

    public function ShowDataBarangKeluar($id)
    {
        $BarangKeluar = Barang::where('id', $id)->first();
        return response()->json($BarangKeluar);
    }

    public function UpdateDataBarangKeluar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_keluar' => 'required',
            'jumlah_barang_keluar' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $barang = Barang::findOrFail($request->barang_id);
        $BarangKeluar = BarangKeluar::where('id', $id)->first()->update([
            'barang_id' => $barang->id,
            'tanggal_keluar' => now(),
            'jumlah_barang_keluar' => $request->jumlah_barang_keluar,
            'deskripsi' => $request->deskripsi,
        ]);
        // Update stok barang
        $barang->stok += $request->jumlah_barang_keluar;
        $barang->save();
        return response()->json(['message' => 'Barang masuk berhasil diupdate']);
    }

    public function DeleteDataBarangKeluar($id)
    {
        $BarangKeluar = BarangKeluar::where('id', $id)->first();

        // Ambil informasi barang terkait
        $barang = Barang::findOrFail($BarangKeluar->barang_id);

        // Memulihkan jumlah stok
        $barang->stok += $BarangKeluar->jumlah_barang_keluar;
        $barang->save();

        //// Hapus data barang masuk
        $BarangKeluar->delete();

        return response()->json(['massage' => 'Barang masunk berhasil dihapus']);
    }
}
