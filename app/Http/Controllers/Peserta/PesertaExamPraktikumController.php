<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ExamPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaExamPraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataExamPraktikum()
    {
        $ExamPraktikum = ExamPraktikum::latest()->all();
        return response()->json(['Data' => $ExamPraktikum]);
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
        $validator = Validator::make($request->all(), [
            'media' => 'required',
            'grade' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ExamPraktikum = ExamPraktikum::create([
            'jenis_ujian' => $request->jenis_exam,
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
    public function ShowDataExamPraktikum($id)
    {
        $user = Auth::user()->id;
        $ExamPraktikum = ExamPraktikum::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $ExamPraktikum]);
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
        $validator = Validator::make($request->all(), [
            'media' => 'required',
            'grade' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $ExamPraktikum = ExamPraktikum::where('id', $id)->first()->update([
            'jenis_ujian' => $request->jenis_exam,
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
