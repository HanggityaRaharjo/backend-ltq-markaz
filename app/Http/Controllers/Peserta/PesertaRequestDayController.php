<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\RequestDay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaRequestDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataRequestDay()
    {
        $RequestDay = RequestDay::latest()->all();
        return response()->json(['Data' => $RequestDay]);
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
    public function CreateDataRequestDay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user()->id;
        $RequestDay = RequestDay::create([
            'user_id' => $user,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);

        if ($RequestDay) {
            return response()->json(['message' => 'RequestDay Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'RequestDay Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataRequestDay($id)
    {
        $user = Auth::user()->id;
        $RequestDay = RequestDay::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $RequestDay]);
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
    public function UpdateDataRequestDay(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = Auth::user()->id;
        $RequestDay = RequestDay::where('id', $id)->first()->update([
            'user_id' => $user,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);
        if ($RequestDay) {
            return response()->json(['message' => 'RequestDay Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'RequestDay Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataRequestDay($id)
    {
        $data = RequestDay::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
