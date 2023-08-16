<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TataUsahaKonsumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataKonsumen()
    {
        $Konsumen = Konsumen::with('users')->get();
        return response()->json($Konsumen);
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
    public function CreateDataKonsumen(Request $request,)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $Konsumen = Konsumen::create([
            'user_id' => $request->user_id,
        ]);

        if ($Konsumen) {
            return response()->json(['message' => 'Konsumen Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Konsumen Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataKonsumen($id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Konsumen = Konsumen::where('id', $id)->first();
        return response()->json(['Data' => $Konsumen]);
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
    public function UpdateDataKonsumen(Request $request, $id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Konsumen = Konsumen::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
        ]);
        if ($Konsumen) {
            return response()->json(['message' => 'Konsumen Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Konsumen Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataKonsumen($id)
    {
        $data = Konsumen::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
