<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\TataUsaha\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TataUsahaSPPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataSpp()
    {
        $Spp = Spp::with('users.UserProgram.program', 'tagihan')->get();
        return response()->json($Spp);
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
    public function CreateDataSpp(Request $request,)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $Spp = Spp::create([
            'user_id' => $request->user_id,
            'nominal' => $request->nominal,
            'status' => $request->status,
        ]);

        if ($Spp) {
            return response()->json(['message' => 'Spp Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Spp Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataSpp($id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Spp = Spp::with('users.UserProgram.program', 'tagihan')->where('id', $id)->first();
        return response()->json(['Data' => $Spp]);
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
    public function UpdateDataSpp(Request $request, $id)
    {
        // $user = User::where('uuid', $uuid)->first();
        $Spp = Spp::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'nominal' => $request->nominal,
            'status' => $request->status,
        ]);
        if ($Spp) {
            return response()->json(['message' => 'Spp Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Spp Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataSpp($id)
    {
        $data = Spp::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
