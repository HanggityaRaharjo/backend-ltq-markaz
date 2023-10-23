<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\TagihanSpp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TataUsahaTagihanSPPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataTagihanSpp()
    {
        $TagihanSpp = TagihanSpp::with('spp')->get();
        return response()->json($TagihanSpp);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateDataTagihanSpp(Request $request)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $file_name = $request->gambar->getClientOriginalName();
        $namaGambar = str_replace(' ', '_', $file_name);
        $image = $request->gambar->storeAs('public/bukti_pembayaran_spp', $namaGambar);
        $TagihanSpp = TagihanSpp::create([
            'spp_id' => $request->spp_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'gambar' => 'bukti_pembayaran_spp/' . $namaGambar,
            'via_pembayaran' => $request->via_pembayaran,
            'status' => $request->status,
        ]);

        if ($TagihanSpp) {
            return response()->json(['message' => 'TagihanSpp Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'TagihanSpp Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataTagihanSpp($id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $TagihanSpp = TagihanSpp::with('spp')->where('id', $id)->first();
        return response()->json(['Data' => $TagihanSpp]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateDataTagihanSpp(Request $request, $id)
    {
        $TagihanSpp = TagihanSpp::find($id);
        if (Request()->hasFile('gambar')) {
            if (Storage::exists($TagihanSpp->gambar)) {
                Storage::delete($TagihanSpp->gambar);
            }
            $file_name = $request->gambar->getClientOriginalName();
            $namaGambar = str_replace(' ', '_', $file_name);
            $image = $request->gambar->storeAs('public/bukti_pembayaran_spp', $namaGambar);
            $TagihanSpp->update([
                'spp_id' => $request->spp_id,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'gambar' => 'gambar/' . $namaGambar,
                'via_pembayaran' => $request->via_pembayaran,
                'status' => $request->status,

            ]);
        } else {
            $TagihanSpp->update([
                'spp_id' => $request->spp_id,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'via_pembayaran' => $request->via_pembayaran,
                'status' => $request->status,

            ]);
        }
        if ($TagihanSpp) {
            return response()->json(['message' => 'TagihanSpp Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'TagihanSpp Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataTagihanSpp($id)
    {
        $data = TagihanSpp::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
