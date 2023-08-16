<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\CutiGuru;
use App\Models\Peserta\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GuruCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataCuti()
    {
        $Cuti = CutiGuru::latest()->get();
        return response()->json($Cuti);
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
    public function CreateDataCuti(Request $request, $uuid)
    {
        try {
            $request->validate([
                'date_start' => 'required',
                'date_end' => 'required',
                'reason' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = User::where('uuid', $uuid)->first();
        $Cuti = CutiGuru::create([
            'user_id' => $user->id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'reason' => $request->reason,
        ]);

        if ($Cuti) {
            return response()->json(['message' => 'Cuti Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Cuti Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataCuti($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $Cuti = CutiGuru::where('user_id', $user->id)->first();
        return response()->json(['Data' => $Cuti]);
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
    public function UpdateDataCuti(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $Cuti = CutiGuru::where('user_id', $user->id)->first()->update([
            'user_id' => $user->id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'reason' => $request->reason,
        ]);
        if ($Cuti) {
            return response()->json(['message' => 'Cuti Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Cuti Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataCuti($id)
    {
        $data = CutiGuru::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
