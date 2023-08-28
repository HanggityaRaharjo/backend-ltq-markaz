<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataCuti()
    {
        $Cuti = Cuti::with('users')->get();
        return response()->json($Cuti);
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
    public function CreateDataCuti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'date_end' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $user = Auth::user()->id;
        // $user_id = User::where('uuid', $uuid)->first();
        $Cuti = Cuti::create([
            'user_id' => $request->user_id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'reason' => $request->reason,
        ]);

        if ($Cuti) {
            return response()->json(['message' => 'Cuti Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Cuti Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataCuti($id, $uuid)
    {
        $user = Auth::user()->id;
        $user_id = User::where('uuid', $uuid)->first();
        $Cuti = Cuti::where('user_id', $user_id->id)->orWhere('id', $id)->first();
        return response()->json(['Data' => $Cuti]);
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
    public function UpdateDataCuti(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'date_end' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = User::where('uuid', $uuid)->first();
        $Cuti = Cuti::where('user_id', $user_id->id)->first()->update([
            'user_id' => $user_id->id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'reason' => $request->reason,
        ]);
        if ($Cuti) {
            return response()->json(['message' => 'Cuti Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Cuti Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataCuti($id, $uuid)
    {
        $user_id = User::where('uuid', $uuid)->first();
        $data = Cuti::where('user_id', $user_id->id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
