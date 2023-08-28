<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaUserLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataUserLevel()
    {
        $userlevel = UserLevel::with('users')->latest()->get();
        return response()->json(['Data' => $userlevel]);
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
    public function CreateDataUserLevel(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total_nilai = 0;
        $predikat = "";
        foreach ($request->soal as $soal) {
            if ($soal['true_answer'] === $soal['select']) {
                $total_nilai += 10;
            }
        }
        if ($total_nilai >= 90) {
            $predikat = "A";
        } elseif ($total_nilai >= 80 && $total_nilai < 90) {
            $predikat = "B";
        } elseif ($total_nilai >= 70 && $total_nilai < 80) {
            $predikat = "C";
        } elseif ($total_nilai >= 60 && $total_nilai < 70) {
            $predikat = "D";
        } elseif ($total_nilai <= 59) {
            $predikat = "E";
        }

        // return response()->json(["data" => $request->uuid, 'massage' => 'sampe sini']);
        $user_id = User::where('uuid', $request->uuid)->first();
        $userlevel = UserLevel::create([
            'user_id' => $user_id->id,
            'predikat' => $predikat,
        ]);

        if ($userlevel) {
            return response()->json(['message' => 'UserLevel Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'UserLevel Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataUserLevel($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $userlevel = UserLevel::with('users')->where('user_id', $user->id)->first();
        return response()->json(['Data' => $userlevel]);
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
    public function UpdateDataUserLevel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $userlevel = UserLevel::find($id);
        $user = Auth::user()->id;
        if (Request()->hasFile('file')) {
            if (Storage::exists($userlevel->file)) {
                Storage::delete($userlevel->file);
            }
            $file_name = $request->file->getClientOriginalName();
            $image = $request->file->storeAs('public/file', $file_name);
            $userlevel->update([
                'level' => $request->level,
                'file' => 'photo/' . $file_name,
            ]);
        } else {
            $userlevel->update([
                'level' => $request->level,
            ]);
        }
        if ($userlevel) {
            return response()->json(['message' => 'userlevel Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'userlevel Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataUserLevel($id)
    {
        $data = UserLevel::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
