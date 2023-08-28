<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Program;
use App\Models\SuperAdmin\CabangLembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataProgram()
    {
        $Program = Program::with('ProgramDay', 'programharga')->latest()->get();
        return response()->json($Program);
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
    public function CreateDataProgram(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_name' => 'required',
            'description' => 'required',
            'program_day_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $Program = Program::create([
            'program_name' => $request->program_name,
            'description' => $request->description,
            'program_day_id' => $request->program_day_id,
        ]);

        if ($Program) {
            return response()->json(['message' => 'Program Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Program Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataProgram($id)
    {
        $Program = Program::with('ProgramDay', 'program_harga')->where('id', $id)->first();
        return response()->json($Program);
    }

    public function ShowDataProgramByCabang($id)
    {
        $cabang = CabangLembaga::where('id', $id)->first();
        $Program = Program::with('ProgramDay', 'program_harga')->where('cabang_lembaga_id', $cabang)->first();
        return response()->json($Program);
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
    public function UpdateDataProgram(Request $request, $id)
    {
        $Program = Program::where('id', $id)->first()->update([
            'program_name' => $request->program_name,
            'description' => $request->description,
            'program_day_id' => $request->program_day_id,
        ]);
        if ($Program) {
            return response()->json(['message' => 'Program Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Program Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataProgram($id)
    {
        $data = Program::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
