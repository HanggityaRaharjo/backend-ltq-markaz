<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ExamPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ExamPraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataExamPraktikum()
    {
        //
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
    public function CreateDataExamPraktikum(Request $request)
    {
        try {
            $request->validate([
                'media' => 'required',
                'grade' => 'required',
                'code' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $ExamPraktikum = ExamPraktikum::create([
            'media' => $request->media,
            'grade' => $request->grade,
        ]);

        if ($ExamPraktikum) {
            return response()->json(['message' => 'ExamPraktikum Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ExamPraktikum Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function UpdateDataExamPraktikum(Request $request, $id)
    {
        $ExamPraktikum = ExamPraktikum::where('id', $id)->first()->update([
            'media' => $request->media,
            'grade' => $request->grade,
        ]);
        if ($ExamPraktikum) {
            return response()->json(['message' => 'ExamPraktikum Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'ExamPraktikum Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataExamPraktikum($id)
    {
        $data = ExamPraktikum::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
