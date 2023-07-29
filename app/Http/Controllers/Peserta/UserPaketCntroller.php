<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\UserPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserPaketCntroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataUserPaket()
    {
        $UserPaket = UserPaket::all();
        return response()->json(['Data' => $UserPaket]);
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
    public function CreateDataUserPaket(Request $request)
    {
        try {
            $request->validate([
                'status' => 'required',
                'upload_file' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = Auth::user()->id;
        $file_name = $request->upload_file->getClientOriginalName();
        $image = $request->upload_file->storeAs('public/upload_file', $file_name);
        $userlevel = UserPaket::create([
            'user_id' => $user,
            'paket_id' => $request->paket_id,
            'status' => $request->status,
            'upload_file' => $image,
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
    public function UpdateDataUserPaket(Request $request, $id)
    {
        $UserPaket = UserPaket::find($id);
        $user = Auth::user()->id;
        if (Request()->hasFile('upload_file')) {
            if (Storage::exists($UserPaket->upload_file)) {
                Storage::delete($UserPaket->upload_file);
            }
            $file_name = $request->upload_file->getClientOriginalName();
            $image = $request->upload_file->storeAs('public/upload_file', $file_name);
            // $image = $request->poto->store('thumbnail');
            $UserPaket->update([
                'user_id' => $user,
                'paket_id' => $request->paket_id,
                'status' => $request->status,
                'upload_file' => $image,
            ]);
        } else {
            $UserPaket->update([
                'user_id' => $user,
                'paket_id' => $request->paket_id,
                'status' => $request->status,
            ]);
        }
        if ($UserPaket) {
            return response()->json(['message' => 'UserPaket Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'UserPaket Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataUserPaket($id)
    {
        $data = UserPaket::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
