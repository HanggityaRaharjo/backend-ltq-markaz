<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\InputNilatSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuruInputNilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataNilaiSiswa()
    {
        $nilai = InputNilatSiswa::latest()->get();
        return response()->json($nilai);
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
    public function CreateDataNilaiSiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program' => 'required',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $user = Auth::user()->id;
        // $user_id = User::where('uuid', $uuid)->first();
        $nilai = InputNilatSiswa::create([
            'user_id' => $request->user_id,
            'program' => $request->program,
            'nilai' => $request->nilai,
        ]);

        if ($nilai) {
            return response()->json(['message' => 'nilai Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'nilai Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataNilaiSiswa($id)
    {
        $nilai = InputNilatSiswa::where('id', $id)->first();
        return response()->json($nilai);
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
    public function UpdateDataNilaiSiswa(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'program' => 'required',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // $user_id = User::where('uuid', $uuid)->first();
        $nilai = InputNilatSiswa::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'program' => $request->program,
            'nilai' => $request->nilai,
        ]);
        if ($nilai) {
            return response()->json(['message' => 'nilai Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'nilai Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataNilaiSiswa($id)
    {
        $data = InputNilatSiswa::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
