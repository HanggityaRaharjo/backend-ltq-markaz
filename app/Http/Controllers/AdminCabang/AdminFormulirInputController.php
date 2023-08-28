<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\AdminCabang\FormulirInput;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminFormulirInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataFormulirInput()
    {
        $FormulirInput = FormulirInput::latest()->get();
        return response()->json(['data' => $FormulirInput]);
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
    public function CreateDataFormulirInput(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formulir_id' => 'required',
            'type' => 'required',
            'label' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $FormulirInput = FormulirInput::create([
            'formulir_id' => $request->formulir_id,
            'type' => $request->type,
            'label' => $request->label,
        ]);

        if ($FormulirInput) {
            return response()->json(['message' => 'FormulirInput Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'FormulirInput Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataFormulirInput($id)
    {
        $user = Auth::user()->id;
        $role = FormulirInput::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['data' => $role]);
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
    public function UpdateDataFormulirInput(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'formulir_id' => 'required',
            'type' => 'required',
            'label' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $FormulirInput = FormulirInput::where('id', $id)->first()->update([
            'formulir_id' => $request->formulir_id,
            'type' => $request->type,
            'label' => $request->label,
        ]);

        if ($FormulirInput) {
            return response()->json(['message' => 'FormulirInput Berhasil Diupdate']);
        } else {
            return response()->json(['message' => 'FormulirInput Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataFormulirInput($id)
    {
        $data = FormulirInput::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
