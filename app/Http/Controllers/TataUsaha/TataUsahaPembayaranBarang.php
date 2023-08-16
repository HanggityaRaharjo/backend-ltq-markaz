<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Barang;
use App\Models\TataUsaha\DetailPembelian;
use App\Models\TataUsaha\PembayaranBarang;
use Illuminate\Http\Request;

class TataUsahaPembayaranBarang extends Controller
{
    public function CreateDataPembayranBarang(Request $request)
    {
        $totalAmount = 0;
        for ($i = 0; $i < count($request->barang_id); $i++) {
            $barang = Barang::where('id', $request->barang_id[$i])->first();
            $subtotal = $barang->harga * $request->jumlah_barang[$i];
            $totalAmount += $subtotal;
        }
        $pembayaran = PembayaranBarang::create([
            'tanggal_pembayaran' => now(),
            'jumlah_pembayaran' => $totalAmount, // Total dari detail pembelian
            'konsumen_id' => $request->konsumen_id,
        ]);

        // Simpan detail pembelian
        foreach ($request->barang_id as $index => $barangId) {
            $barang = Barang::find($barangId);

            // Simpan detail pembelian
            DetailPembelian::create([
                'pembayaran_id' => $pembayaran->id,
                'barang_id' => $barangId,
                'jumlah_barang' => $request->jumlah_barang[$index],
                'subtotal' => $barang->harga * $request->jumlah_barang[$index],
            ]);

            // Kurangi stok barang
            $barang->stok -= $request->jumlah_barang[$index];
            $barang->save();
        }

        return response()->json(['message' => 'Pembayaran Berhasil Ditambahkan']);
    }
}
