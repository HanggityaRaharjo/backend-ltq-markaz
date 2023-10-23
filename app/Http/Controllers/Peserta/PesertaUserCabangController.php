<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserCabang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaUserCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataUserCabang()
    {
        $UserCabang = UserCabang::with('cabang.kota', 'user')->get();
        return response()->json($UserCabang);
    }

    public function GetDataCabangByUser($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $dataCabangByUser = UserCabang::with('cabang.kota', 'user')->where('user_id', $user->id)->first();
        return response()->json($dataCabangByUser);
    }
    public function GetCabangByUser($user_id)
    {
        $dataCabangByUser = UserCabang::with('cabang.kota', 'user')->where('user_id', $user_id)->first();
        return response()->json($dataCabangByUser);
    }

    public function GetDataCabangByCabang($cabang_id)
    {
        $dataCabangByUser = UserCabang::with('cabang.kota', 'user')->where('cabang_lembaga_id', $cabang_id)->get();
        return response()->json($dataCabangByUser);
    }

    public function GetAllUserCabang()
    {
        $datas = UserCabang::with('cabang.kota', 'user')->get();
        return response()->json($datas);
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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = User::where('uuid', $request->uuid)->first();
        $UserCabang = UserCabang::create([
            'user_id' => $user_id->id,
            'cabang_lembaga_id' => $request->cabang_lembaga_id,
        ]);

        if ($UserCabang) {
            return response()->json(['message' => 'UserCabang Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'UserCabang Gagal Ditambahkan']);
        }
    }


    public function CreateUserCabang(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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
        $UserCabang = UserCabang::with('cabang')->where('id', $id)->first();
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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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
