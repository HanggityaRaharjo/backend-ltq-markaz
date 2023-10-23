<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\PetenjukPenganjar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuruPetunjukPengajarController extends Controller
{
    public function GetDataPetenjukPenganjar()
    {
        $PetenjukPenganjar = PetenjukPenganjar::get();
        return response()->json($PetenjukPenganjar);
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
    public function CreateDataPetenjukPenganjar(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $file_name = $request->file_PetenjukPenganjar->getClientOriginalName();
        $namaGambar = str_replace(' ', '_', $file_name);
        $image = $request->file_PetenjukPenganjar->storeAs('public/file_PetenjukPenganjar', $namaGambar);

        // $user = Auth::user()->id;
        // $user_id = User::where('uuid', $uuid)->first();
        $PetenjukPenganjar = PetenjukPenganjar::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'periode' => $request->periode,
            'file_PetenjukPenganjar' => 'file/' . $namaGambar,
        ]);

        if ($PetenjukPenganjar) {
            return response()->json(['message' => 'PetenjukPenganjar Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'PetenjukPenganjar Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataPetenjukPenganjar($id)
    {
        $PetenjukPenganjar = PetenjukPenganjar::where('id', $id)->first();
        return response()->json($PetenjukPenganjar);
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
    public function UpdateDataPetenjukPenganjar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $PetenjukPenganjar = PetenjukPenganjar::find($id);

        if (Request()->hasFile('file_PetenjukPenganjar')) {
            if (Storage::exists($PetenjukPenganjar->file_PetenjukPenganjar)) {
                Storage::delete($PetenjukPenganjar->file_PetenjukPenganjar);
            }

            $file_name = $request->file_PetenjukPenganjar->getClientOriginalName();
            $namaGambar = str_replace(' ', '_', $file_name);
            $image = $request->file_PetenjukPenganjar->storeAs('public/file_PetenjukPenganjar', $namaGambar);

            $PetenjukPenganjar->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'periode' => $request->periode,
                'file_PetenjukPenganjar' => 'file/' . $namaGambar,
            ]);
        } else {
            $PetenjukPenganjar->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'periode' => $request->periode,
            ]);
        }
        if ($PetenjukPenganjar) {
            return response()->json(['message' => 'PetenjukPenganjar Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'PetenjukPenganjar Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataPetenjukPenganjar($id)
    {
        $data = PetenjukPenganjar::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
