<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\AlurKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BendaharaAlurKasController extends Controller
{
    public function index()
    {
        $datas = AlurKas::with('kategoriTransaksi')->get();
        return response()->json($datas);
    }

    public function getByKategori($kategori_transaksi)
    {
        $data = AlurKas::with('kategoriTransaksi')->where('kategori_transaksi', $kategori_transaksi)->get();
        return response()->json($data);
    }

    public function getByTanggal(Request $request)
    {
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;

        $data = AlurKas::with('kategoriTransaksi')->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        return response()->json($data);
    }

    public function getByTanggalKategori(Request $request)
    {

        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        $kategori = $request->kategori;

        $data = AlurKas::with('kategoriTransaksi')->whereBetween('tanggal', [$tglawal, $tglakhir])->where('kategori_transaksi', $kategori)->get();
        return response()->json($data);
    }

    public function countPendapatanPerhari()
    {
        $pendapatanPerHari = AlurKas::where('jenis_transaksi', 'pemasukan')
            ->groupBy('tanggal')
            ->selectRaw('tanggal, SUM(nominal) as total')
            ->get();
        return response()->json($pendapatanPerHari);
    }

    public function countPendapatanPerbulan()
    {
        $pendapatanPerBulan = AlurKas::where('jenis_transaksi', 'pemasukan')
            ->select(DB::raw('YEAR(tanggal) as tahun, MONTH(tanggal) as bulan, SUM(nominal) as total'))
            ->groupBy(DB::raw('YEAR(tanggal), MONTH(tanggal)'))
            ->get();
        return response()->json($pendapatanPerBulan);
    }

    public function countPendapatanPertahun()
    {
        $pendapatanPerTahun = AlurKas::where('jenis_transaksi', 'pemasukan')
            ->select(DB::raw('YEAR(tanggal) as tahun, SUM(nominal) as total'))
            ->groupBy(DB::raw('YEAR(tanggal)'))
            ->get();
        return response()->json($pendapatanPerTahun);
    }

    public function countPengeluaranPerhari()
    {
        $PengeluaranPerHari = AlurKas::where('jenis_transaksi', 'pemasukan')
            ->groupBy('tanggal')
            ->selectRaw('tanggal, SUM(nominal) as total')
            ->get();
        return response()->json($PengeluaranPerHari);
    }

    public function countPengeluaranPerbulan()
    {
        $PengeluaranPerBulan = AlurKas::where('jenis_transaksi', 'pemasukan')
            ->select(DB::raw('YEAR(tanggal) as tahun, MONTH(tanggal) as bulan, SUM(nominal) as total'))
            ->groupBy(DB::raw('YEAR(tanggal), MONTH(tanggal)'))
            ->get();
        return response()->json($PengeluaranPerBulan);
    }

    public function countPengeluaranPertahun()
    {
        $PengeluaranPerTahun = AlurKas::where('jenis_transaksi', 'pemasukan')
            ->select(DB::raw('YEAR(tanggal) as tahun, SUM(nominal) as total'))
            ->groupBy(DB::raw('YEAR(tanggal)'))
            ->get();
        return response()->json($PengeluaranPerTahun);
    }

    public function countLaba()
    {
        $totalPendapatan = AlurKas::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaran = AlurKas::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $laba = $totalPendapatan - $totalPengeluaran;

        return response()->json(['Laba' => $laba]);
    }


    public function store(Request $request)
    {
        // $total = $request->pemasukan - $request->pengeluaran;
        $validator = Validator::make($request->all(), [
            'kategori_transaksi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datas = AlurKas::create([
            "kategori_transaksi" => $request->kategori_transaksi,
            "nama_transaksi" => $request->nama_transaksi,
            "tanggal" => $request->tanggal,
            "keterangan" => $request->keterangan,
            // "pemasukan" => $request->pemasukan,
            // "pengeluaran" => $request->pengeluaran,
            "nominal" => $request->nominal,
            "jenis_transaksi" => $request->jenis_transaksi,
            // "total" => $total,

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
            "nama_transaksi" => $request->nama_transaksi,
            "tanggal" => $request->tanggal,
            "keterangan" => $request->keterangan,
            // "pemasukan" => $request->pemasukan,
            // "pengeluaran" => $request->pengeluaran,
            "nominal" => $request->nominal,
            "jenis_transaksi" => $request->jenis_transaksi,
            // "total" => $total,
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
