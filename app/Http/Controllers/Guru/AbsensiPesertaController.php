<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\AbsensiPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AbsensiPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataAbsensiPeserta()
    {
        $AbsensiPeserta = AbsensiPeserta::latest()->get();
        return response()->json(['data' => $AbsensiPeserta]);
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
    public function CreateDataAbsensiPeserta(Request $request)
    {
        try {
            $request->validate([
                'keterangan' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $AbsensiPeserta = AbsensiPeserta::create([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
            'nomor_id' => $request->nomor_id,
            'keterangan' => $request->keterangan,
        ]);

        if ($AbsensiPeserta) {
            return response()->json(['message' => 'AbsensiPeserta Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'AbsensiPeserta Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataAbsensiPeserta($id)
    {
        $AbsensiPeserta = AbsensiPeserta::where('id', $id)->first();
        return response()->json(['data' => $AbsensiPeserta]);
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
    public function UpdateDataAbsensiPeserta(Request $request, $id)
    {
        $AbsensiPeserta = AbsensiPeserta::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
            'nomor_id' => $request->nomor_id,
            'keterangan' => $request->keterangan,
        ]);

        if ($AbsensiPeserta) {
            return response()->json(['message' => 'AbsensiPeserta Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'AbsensiPeserta Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataAbsensiPeserta($id)
    {
        $AbsensiPeserta = AbsensiPeserta::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Data Berhasil Di Hapus']);
    }
}
