<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ExamPg;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ExamPGController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataExamPG()
    {
        $ExamPg = ExamPg::latest()->all();
        return response()->json(['Data' => $ExamPg]);
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
    public function CreateDataExamPG(Request $request)
    {
        try {
            $request->validate([
                'question' => 'required',
                'option_a' => 'required',
                'option_b' => 'required',
                'option_c' => 'required',
                'option_d' => 'required',
                'option_e' => 'required',
                'true_answer' => 'required',
                'code' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $ExamPg = ExamPg::create([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'true_answer' => $request->true_answer,
            'code' => $request->code,
        ]);

        if ($ExamPg) {
            return response()->json(['message' => 'ExamPg Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ExamPg Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataExamPG($id)
    {
        $user = Auth::user()->id;
        $ExamPg = ExamPg::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $ExamPg]);
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
    public function UpdateDataExamPG(Request $request, $id)
    {
        $ExamPg = ExamPg::where('id', $id)->first()->update([
            'jenis_ujian' => $request->jenis_exam,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'true_answer' => $request->true_answer,
            'code' => $request->code,
        ]);
        if ($ExamPg) {
            return response()->json(['message' => 'ExamPg Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'ExamPg Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataExamPG($id)
    {
        $data = ExamPg::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
