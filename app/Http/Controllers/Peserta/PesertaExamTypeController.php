<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PesertaExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataExamType()
    {
        $ExamType = ExamType::with('users')->latest()->get();
        return response()->json(['Data' => $ExamType]);
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
    public function CreateDataExamType(Request $request)
    {
        try {
            $request->validate([
                'type_name' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        $user = Auth::user()->id;
        $ExamType = ExamType::create([
            'user_id' => $user,
            'type_name' => $request->type_name,
            'code' => $request->code,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($ExamType) {
            return response()->json(['message' => 'ExamType Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ExamType Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataExamType($id)
    {
        $ExamType = ExamType::with('users')->where('id', $id)->latest()->get();
        return response()->json(['Data' => $ExamType]);
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
    public function UpdateDataExamType(Request $request, $id)
    {
        $user = Auth::user()->id;
        $ExamType = ExamType::where('id', $id)->first()->update([
            'type_name' => $request->type_name,
            'code' => $request->code,
            'deskripsi' => $request->deskripsi,
        ]);
        if ($ExamType) {
            return response()->json(['message' => 'ExamType Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'ExamType Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataExamType($id)
    {
        $data = ExamType::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
