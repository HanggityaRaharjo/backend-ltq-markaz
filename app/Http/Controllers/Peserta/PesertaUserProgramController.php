<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\UserProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaUserProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataUserProgram(Request $request)
    {
        $user_program = UserProgram::with('program_harga', 'program', 'users')->latest()->get();
        return response()->json($user_program);
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
    public function CreateDataUserProgram(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // $user = Auth::user()->uuid;
        $user_id = User::where('uuid', $request->uuid)->first();
        $UserProgram = UserProgram::create([
            'user_id' => $user_id->id,
            'program_id' => $request->program_id,
            'program_harga_id' => $request->program_harga_id,
        ]);

        if ($UserProgram) {
            return response()->json(['message' => 'UserProgram Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'UserProgram Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataByUuidUserProgram($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $User_programs = UserProgram::with('program', 'program_harga', 'users')->where('user_id', $user->id)->first();
        return response()->json($User_programs);

        // $response_data = [];

        // foreach ($User_programs as $user_program) {
        //     $response_data[] = [
        //         "id" => $user_program->id,
        //         "name" => $user_program->users->name,
        //         "user_id" => $user_program->user_id,
        //         "program" => $user_program->program,
        //         "harga" => $user_program->program_harga,
        //     ];
        // }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataUserProgram($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $User_programs = UserProgram::with('program', 'program_harga', 'users')->where('user_id', $user->id)->first();
        return response()->json($User_programs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateDataUserProgram(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = Auth::user()->id;
        $user_id = User::where('uuid', $request->uuid);
        $UserProgram = UserProgram::where('id', $id)->first()->update([
            'user_id' => $user_id->id,
            'program_id' => $request->program_id,
            'program_harga_id' => $request->program_harga_id
        ]);
        if ($UserProgram) {
            return response()->json(['message' => 'UserProgram Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'UserProgram Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataUserProgram($id)
    {
        $data = UserProgram::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
