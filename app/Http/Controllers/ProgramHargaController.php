<?php

namespace App\Http\Controllers;

use App\Models\ProgramHarga;
use App\Models\SuperAdmin\ProgramHarga as SuperAdminProgramHarga;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProgramHargaController extends Controller
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
        try {
            $request->validate([
                'harga' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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
