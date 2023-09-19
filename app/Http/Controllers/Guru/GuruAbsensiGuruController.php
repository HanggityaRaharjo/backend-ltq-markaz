<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\AbsensiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuruAbsensiGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataAbsensiGuru()
    {
        $AbsensiGuru = AbsensiGuru::latest()->get();
        return response()->json(['data' => $AbsensiGuru]);
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
    public function CreateDataAbsensiGuru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = Auth::user()->id;
        $AbsensiGuru = AbsensiGuru::create([
            'user_id' => $user_id,
            'kelas_id' => $request->kelas_id,
            'nomor_id' => $request->nomor_id,
            'keterangan' => $request->keterangan,
        ]);

        if ($AbsensiGuru) {
            return response()->json(['message' => 'AbsensiGuru Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'AbsensiGuru Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataAbsensiGuru($id)
    {
        $AbsensiGuru = AbsensiGuru::where('id', $id)->first();
        return response()->json(['data' => $AbsensiGuru]);
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
    public function UpdateDataAbsensiGuru(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user_id = User::where('uuid', $uuid)->first();
        $AbsensiGuru = AbsensiGuru::where('user_id', $user_id->id)->first()->update([
            'user_id' => $user_id->id,
            'kelas_id' => $request->kelas_id,
            'nomor_id' => $request->nomor_id,
            'keterangan' => $request->keterangan,
        ]);

        if ($AbsensiGuru) {
            return response()->json(['message' => 'AbsensiGuru Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'AbsensiGuru Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataAbsensiGuru($id)
    {
        $AbsensiPeserta = AbsensiGuru::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Data Berhasil Di Hapus']);
    }
}
