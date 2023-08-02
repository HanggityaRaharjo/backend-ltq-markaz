<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\AdminCabang\ProfileCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfileCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataProfileCabang()
    {
        $profilecabang = ProfileCabang::get();
        return response()->json(['data' => $profilecabang]);
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
    public function CreateDataProfileCabang(Request $request)
    {
        try {
            $request->validate([
                'nama_cabang' => 'required',
                'logo' => 'required',
                'alamat' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = Auth::user()->id;
        $file_name = $request->logo->getClientOriginalName();
        $image = $request->logo->storeAs('public/logo', $file_name);
        $profilecabang = ProfileCabang::create([
            'nama_cabang' => $request->nama_cabang,
            'logo' => $image,
            'alamat' => $request->alamat,
        ]);

        if ($profilecabang) {
            return response()->json(['message' => 'Profile Cabang Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Profile Cabang Gagal Ditambahkan']);
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
    public function UpdateDataProfileCabang(Request $request, $id)
    {
        $profilecabang = ProfileCabang::find($id);
        if (Request()->hasFile('logo')) {
            if (Storage::exists($profilecabang->logo)) {
                Storage::delete($profilecabang->logo);
            }
            $file_name = $request->logo->getClientOriginalName();
            $image = $request->logo->storeAs('public/logo', $file_name);
            // $image = $request->poto->store('thumbnail');
            $profilecabang->update([
                'nama_cabang' => $request->nama_cabang,
                'logo' => $image,
                'alamat' => $request->alamat,
            ]);
        } else {
            $profilecabang->update([
                'nama_cabang' => $request->nama_cabang,
                'alamat' => $request->alamat,
            ]);
        }
        if ($profilecabang) {
            return response()->json(['message' => 'cabang Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'cabang Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profilecabang = ProfileCabang::where('id', $id)->first();
        $profilecabang->delete();
        if ($profilecabang) {
            return response()->json(['message' => 'Profile Cabang Berhasil Dihapus']);
        } else {
            return response()->json(['message' => 'Profile Cabang Gagal Dihapus']);
        }
    }
}
