<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\PaketPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataPaket()
    {
        $Paket = PaketPeserta::latest()->all();
        return response()->json(['Data' => $Paket]);
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
    public function CreateDataPaket(Request $request)
    {
        try {
            $request->validate([
                'paket_name' => 'required',
                'code' => 'required',
                'price' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $Paket = PaketPeserta::create([
            'paket_name' => $request->paket_name,
            'code' => $request->code,
            'price' => $request->price,
        ]);

        if ($Paket) {
            return response()->json(['message' => 'Paket Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Paket Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataPaketPeserta($id)
    {
        $user = Auth::user()->id;
        $PaketPeserta = PaketPeserta::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $PaketPeserta]);
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
    public function UpdateDataPaket(Request $request, $id)
    {
        $Paket = PaketPeserta::where('id', $id)->first()->update([
            'paket_name' => $request->paket_name,
            'code' => $request->code,
            'price' => $request->price,
        ]);
        if ($Paket) {
            return response()->json(['message' => 'Paket Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Paket Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataPaket($id)
    {
        $data = PaketPeserta::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
