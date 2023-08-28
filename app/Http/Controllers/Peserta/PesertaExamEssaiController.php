<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ExamEssai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaExamEssaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataExamEssai()
    {
        $ExamEssai = ExamEssai::latest()->all();
        return response()->json(['Data' => $ExamEssai]);
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
    public function CreateDataExamEssai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'true_answer' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ExamEssai = ExamEssai::create([
            'jenis_ujian' => $request->jenis_exam,
            'question' => $request->question,
            'true_answer' => $request->true_answer,
            'code' => $request->code,
        ]);

        if ($ExamEssai) {
            return response()->json(['message' => 'ExamEssai Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ExamEssai Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataExamEssai($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $ExamEssai = ExamEssai::where('id', $user)->orWhere('user_id', $user->id)->first();
        return response()->json(['Data' => $ExamEssai]);
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
    public function UpdateDataExamEssai(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'true_answer' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $ExamEssai = ExamEssai::where('id', $id)->first()->update([
            'jenis_ujian' => $request->jenis_exam,
            'question' => $request->question,
            'true_answer' => $request->true_answer,
            'code' => $request->code,
        ]);
        if ($ExamEssai) {
            return response()->json(['message' => 'ExamEssai Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'ExamEssai Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataExamEssai($id)
    {
        $data = ExamEssai::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
