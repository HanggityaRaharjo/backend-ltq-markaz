<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Barang;
use App\Models\TataUsaha\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TataUsahaBarangMasukController extends Controller
{
    public function GetDataBarangMasuk()
    {
        $barangMasuk = BarangMasuk::with('barang')->get();
        return response()->json($barangMasuk);
    }

    public function CreateDataBarangMasuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_masuk' => 'required',
            'jumlah_barang_masuk' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Ambil informasi barang
        $barang = Barang::findOrFail($request->barang_id);

        // Merekam barang masuk
        $barangMasuk = BarangMasuk::create([
            'barang_id' => $barang->id,
            'tanggal_masuk' => now(),
            'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
            'deskripsi' => $request->deskripsi,
        ]);

        // Update stok barang
        $barang->stok += $request->jumlah_barang_masuk;
        $barang->save();

        return response()->json(['message' => 'Barang masuk berhasil dicatat']);
    }

    public function ShowDataBarangMasuk($id)
    {
        $barangMasuk = Barang::where('id', $id)->first();
        return response()->json($barangMasuk);
    }

    public function UpdateDataBarangMasuk(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_masuk' => 'required',
            'jumlah_barang_masuk' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $barang = Barang::findOrFail($request->barang_id);
        $barangMasuk = BarangMasuk::where('id', $id)->first()->update([
            'barang_id' => $barang->id,
            'tanggal_masuk' => now(),
            'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
            'deskripsi' => $request->deskripsi,
        ]);
        // Update stok barang
        $barang->stok += $request->jumlah_barang_masuk;
        $barang->save();
        return response()->json(['message' => 'Barang masuk berhasil diupdate']);
    }

    public function DeleteDataBarangMasuk($id)
    {
        $barangMasuk = BarangMasuk::where('id', $id)->first();

        // Ambil informasi barang terkait
        $barang = Barang::findOrFail($barangMasuk->barang_id);

        // Memulihkan jumlah stok
        $barang->stok -= $barangMasuk->jumlah_barang_masuk;
        $barang->save();

        //// Hapus data barang masuk
        $barangMasuk->delete();

        return response()->json(['massage' => 'Barang masunk berhasil dihapus']);
    }
}
