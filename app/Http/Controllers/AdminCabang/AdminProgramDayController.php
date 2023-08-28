<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ProgramDay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminProgramDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataProgramDay()
    {
        $ProgramDay = ProgramDay::latest()->all();
        return response()->json(['Data' => $ProgramDay]);
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
    public function CreateDataProgramDay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ProgramDay = ProgramDay::create([
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'jam' => $request->jam,
        ]);

        if ($ProgramDay) {
            return response()->json(['message' => 'ProgramDay Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ProgramDay Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataProgramDay($id)
    {
        $user = Auth::user()->id;
        $ProgramDay = ProgramDay::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $ProgramDay]);
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
    public function UpdateDataProgramDay(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $ProgramDay = ProgramDay::where('id', $id)->first()->update([
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'jam' => $request->jam,
        ]);
        if ($ProgramDay) {
            return response()->json(['message' => 'ProgramDay Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'ProgramDay Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataProgramDay($id)
    {
        $data = ProgramDay::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
