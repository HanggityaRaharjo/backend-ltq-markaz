<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\RaportSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuruRaportSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataRaport()
    {
        $raport = RaportSiswa::with('user')->get();
        return response()->json($raport);
    }

    public function getNilaiRapotyByUser($user_id)
    {
        $raport = RaportSiswa::with('user')->where('user_id', $user_id)->first();
        return response()->json($raport);
    }

    public function getNilaiRapotyBySemester($semester)
    {
        $raport = RaportSiswa::with('user')->where('semester', $semester)->get();
        return response()->json($raport);
    }

    public function getNilaiRapotyByUserSemester($user_id, $semester)
    {
        $raport = RaportSiswa::with('user')->where('user_id', $user_id)->where('semester', $semester)->first();
        return response()->json($raport);
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
    public function CreateDataRaport(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $user = Auth::user()->id;
        // $user_id = User::where('uuid', $uuid)->first();
        $raport = RaportSiswa::create([
            'user_id' => $request->user_id,
            'rata_rata' => $request->rata_rata,
            'semester' => $request->semester,
        ]);

        if ($raport) {
            return response()->json(['message' => 'raport Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'raport Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataRaport($id)
    {
        $raport = RaportSiswa::where('id', $id)->first();
        return response()->json($raport);
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
    public function UpdateDataRaport(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $raport = RaportSiswa::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'rata_rata' => $request->rata_rata,
            'semester' => $request->semester,
        ]);
        if ($raport) {
            return response()->json(['message' => 'raport Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'raport Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataRaport($id)
    {
        $data = RaportSiswa::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted']]);
    }
}
