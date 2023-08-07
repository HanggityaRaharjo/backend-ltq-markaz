<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataKelas()
    {
        $kelas = kelas::latest()->get();
        return response()->json(['data' => $kelas]);
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
    public function CreateDataKelas(Request $request)
    {
        try {
            $request->validate([
                'nama_pengajar' => 'required',
                'jumlah_peserta' => 'required',
                'nama_kelas' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user_id = Auth::user()->id;
        $Kelas = Kelas::create([
            'user_id' => $user_id,
            'nama_pengajar' => $request->nama_pengajar,
            'jumlah_peserta' => $request->jumlah_peserta,
            'nama_kelas' => $request->nama_kelas,
        ]);

        if ($Kelas) {
            return response()->json(['message' => 'Kelas Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Kelas Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataKelas($id)
    {
        $user = Auth::user()->id;
        $kelas = kelas::where('id', $id)->where('id', $user)->first();
        return response()->json(['data' => $kelas]);
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
    public function UpdateDataKelas(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $Kelas = Kelas::where('id', $id)->first()->update([
            'user_id' => $user_id,
            'nama_pengajar' => $request->nama_pengajar,
            'jumlah_peserta' => $request->jumlah_peserta,
            'nama_kelas' => $request->nama_kelas,
        ]);

        if ($Kelas) {
            return response()->json(['message' => 'Kelas Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Kelas Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataKelas($id)
    {
        $kelas = kelas::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Data berhasil Dihapus']);
    }
}
