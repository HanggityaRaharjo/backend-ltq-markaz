<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ExamPg;
use App\Models\Peserta\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaExamPGController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataExamPG()
    {
        $ExamPg = ExamPg::with('ExamTypePG')->get();
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
        // $test = "";
        // foreach ($request->soal as $data) {
        //     $test = $test . $data['option_a'];
        // }
        // return response()->json($test);
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $type = $request->type_exam;
        $code = $request->code;

        $ExamType = ExamType::create([
            'type_exam' => $type,
            'code' => $code,
        ]);
        // return response()->json($request->soal);

        foreach ($request->soal as $data) {
            $ExamPg = ExamPg::create([
                'exam_id' => $ExamType->id,
                'jenis_exam' => 'pg',
                'question' => $data['question'],
                'option_a' => $data['option_a'],
                'option_b' => $data['option_b'],
                'option_c' => $data['option_c'],
                'option_d' => $data['option_d'],
                'option_e' => $data['option_e'],
                'true_answer' => $data['true_answer'],
                'code' => $ExamType->code,
            ]);
        }
        return response()->json(['message' => 'ExamPg Berhasil Ditambahkan']);

        // if ($ExamPg) {
        //     return response()->json(['message' => 'ExamPg Berhasil Ditambahkan']);
        // } else {
        //     return response()->json(['message' => 'ExamPg Gagal Ditambahkan']);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataExamPG($id)
    {

        $ExamPg = ExamPg::with('ExamTypePG')->where('id', $id)->first();
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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ExamPg = ExamPg::where('id', $id)->first()->update([
            'user_level_id' => $request->user_level_id,
            'jenis_exam' => $request->jenis_exam,
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
