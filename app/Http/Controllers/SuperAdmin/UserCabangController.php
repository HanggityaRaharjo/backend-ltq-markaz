<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserCabang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataUserCabang()
    {
        $UserCabang = UserCabang::get();
        return response()->json(['data' => $UserCabang]);
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
    public function CreateDataUserCabang(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'cabang_lembaga_id' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $UserCabang = UserCabang::create([
            'user_id' => $request->user_id,
            'cabang_lembaga_id' => $request->cabang_lembaga_id,
        ]);

        if ($UserCabang) {
            return response()->json(['message' => 'UserCabang Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'UserCabang Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataUserCabang($id)
    {
        $UserCabang = UserCabang::where('id', $id)->first();
        return response()->json(['data' => $UserCabang]);
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
    public function UpdateDataUserCabang(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'cabang_lembaga_id' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $UserCabang = UserCabang::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'cabang_lembaga_id' => $request->cabang_lembaga_id,
        ]);

        if ($UserCabang) {
            return response()->json(['message' => 'UserCabang Berhasil Diupdate']);
        } else {
            return response()->json(['message' => 'UserCabang Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataUserCabang($id)
    {
        $UserCabang = UserCabang::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Data Berhasil Didelete']);
    }
}
