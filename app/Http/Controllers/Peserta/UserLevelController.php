<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataUserLevel()
    {
        $userlevel = UserLevel::latest()->all();
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
        try {
            $request->validate([
                'level' => 'required',
                'file' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = Auth::user()->id;
        $file_name = $request->file->getClientOriginalName();
        $image = $request->file->storeAs('public/file', $file_name);
        $userlevel = UserLevel::create([
            'user_id' => $user,
            'level' => $request->level,
            'exam_id' => $request->exam_id,
            'file' => $image,
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
    public function ShowDataUserLevel($id)
    {
        $user = Auth::user()->id;
        $userlevel = UserLevel::where('id', $user)->orWhere('id', $id)->all();
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
        $userlevel = UserLevel::find($id);
        $user = Auth::user()->id;
        if (Request()->hasFile('file')) {
            if (Storage::exists($userlevel->file)) {
                Storage::delete($userlevel->file);
            }
            $file_name = $request->file->getClientOriginalName();
            $image = $request->file->storeAs('public/file', $file_name);
            // $image = $request->poto->store('thumbnail');
            $userlevel->update([
                'user_id' => $user,
                'level' => $request->level,
                'file' => $image,
            ]);
        } else {
            $userlevel->update([
                'user_id' => $user,
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
