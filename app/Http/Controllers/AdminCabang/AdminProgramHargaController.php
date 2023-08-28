<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\ProgramHarga;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminProgramHargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataProgramHarga()
    {
        $ProgramHarga = ProgramHarga::with('program', 'cabang')->latest()->get();
        return response()->json(['data' => $ProgramHarga]);
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
    public function CreateDataProgramHarga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ProgramHarga = ProgramHarga::create([
            'program_id' => $request->program_id,
            'cabang_lembaga_id' => $request->cabang_lembaga_id,
            'harga' => $request->harga,
        ]);

        if ($ProgramHarga) {
            return response()->json(['message' => 'ProgramHarga Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ProgramHarga Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function UpdateDataProgramHarga(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $ProgramHarga = ProgramHarga::where('id', $id)->first()->update([
            'program_id' => $request->program_id,
            'cabang_lembaga_id' => $request->cabang_lembaga_id,
            'harga' => $request->harga,
        ]);

        if ($ProgramHarga) {
            return response()->json(['message' => 'ProgramHarga Berhasil Diupdate']);
        } else {
            return response()->json(['message' => 'ProgramHarga Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteGetDataProgramHarga($id)
    {
        $ProgramHarga = ProgramHarga::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Data Berhasil Dihapus']);
    }
}
