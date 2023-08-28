<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\AdminCabang\Formulir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminFormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataFormulir()
    {
        $formulir = Formulir::get();
        return response()->json(['data' => $formulir]);
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
    public function CreateDataFormulir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_formulir' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $formulir = Formulir::create([
            'nama_formulir' => $request->nama_formulir,
        ]);

        if ($formulir) {
            return response()->json(['message' => 'Formulir Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Formulir Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataFormulir($id)
    {
        $user = Auth::user()->id;
        $Formulir = Formulir::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['data' => $Formulir]);
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
    public function UpdateDataFormulir(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_formulir' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $formulir = Formulir::where('id', $id)->first()->update([
            'nama_formulir' => $request->nama_formulir,
        ]);
        if ($formulir) {
            return response()->json(['message' => 'formulir Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'formulir Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataFormulir($id)
    {
        $data = Formulir::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
