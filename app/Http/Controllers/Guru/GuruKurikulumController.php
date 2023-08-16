<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GuruKurikulumController extends Controller
{
    public function GetDataKurikulum()
    {
        $Kurikulum = Kurikulum::get();
        return response()->json($Kurikulum);
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
    public function CreateDataKurikulum(Request $request)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // $user = Auth::user()->id;
        // $user_id = User::where('uuid', $uuid)->first();
        $Kurikulum = Kurikulum::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'periode' => $request->periode,
        ]);

        if ($Kurikulum) {
            return response()->json(['message' => 'Kurikulum Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Kurikulum Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataKurikulum($id)
    {
        $Kurikulum = Kurikulum::where('id', $id)->first();
        return response()->json($Kurikulum);
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
    public function UpdateDataKurikulum(Request $request, $id)
    {
        $Kurikulum = Kurikulum::where('id', $id)->first()->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'periode' => $request->periode,
        ]);
        if ($Kurikulum) {
            return response()->json(['message' => 'Kurikulum Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Kurikulum Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataKurikulum($id)
    {
        $data = Kurikulum::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
