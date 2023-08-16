<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TataUsahaKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataKegiatan()
    {
        $Kegiatan = Kegiatan::latest()->get();
        return response()->json($Kegiatan);
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
    public function CreateDataKegiatan(Request $request,)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $Kegiatan = Kegiatan::create([
            'user_id' => $request->user_id,
            'nama_pembayaran' => $request->nama_pembayaran,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
        ]);

        if ($Kegiatan) {
            return response()->json(['message' => 'Kegiatan Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Kegiatan Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataKegiatan($id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Kegiatan = Kegiatan::where('id', $id)->first();
        return response()->json(['Data' => $Kegiatan]);
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
    public function UpdateDataKegiatan(Request $request, $id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Kegiatan = Kegiatan::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'nama_pembayaran' => $request->nama_pembayaran,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
        ]);
        if ($Kegiatan) {
            return response()->json(['message' => 'Kegiatan Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Kegiatan Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataKegiatan($id)
    {
        $data = Kegiatan::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
