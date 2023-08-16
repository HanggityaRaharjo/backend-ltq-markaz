<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Dpp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TataUsahaDPPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataDpp()
    {
        $Dpp = Dpp::latest()->get();
        return response()->json($Dpp);
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
    public function CreateDataDpp(Request $request,)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $Dpp = Dpp::create([
            'user_id' => $request->user_id,
            'nama_pembayaran' => $request->nama_pembayaran,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
        ]);

        if ($Dpp) {
            return response()->json(['message' => 'Dpp Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Dpp Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataDpp($id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Dpp = Dpp::where('id', $id)->first();
        return response()->json(['Data' => $Dpp]);
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
    public function UpdateDataDpp(Request $request, $id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Dpp = Dpp::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'nama_pembayaran' => $request->nama_pembayaran,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
        ]);
        if ($Dpp) {
            return response()->json(['message' => 'Dpp Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Dpp Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataDpp($id)
    {
        $data = Dpp::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
