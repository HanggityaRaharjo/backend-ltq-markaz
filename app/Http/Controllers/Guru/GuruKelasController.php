<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\kelas;
use App\Models\Peserta\UserKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuruKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllKelas()
    {
        $kelas = kelas::with('program.cabang')->get();
        return response()->json($kelas);
    }

    // public function getByNamaKelas($nama_kelas)
    // {
    //     $kelas = kelas::with('program.cabang')->where('nama_kelas', $nama_kelas)->first();
    //     return response()->json($kelas);
    // }
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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $nama_pengajar = $request->nama_pengajar;
        $nama_kelas = $request->nama_kelas;
        $jumlah_peserta = $request->jumlah_peserta;

        $Kelas = Kelas::create([
            'user_id' => $request->user_id,
            'program_id' => $request->program_id,
            'nama_pengajar' => $nama_pengajar,
            'nama_kelas' => $nama_kelas,
            'jumlah_peserta' => $jumlah_peserta,
        ]);
        foreach ($request['peserta'] as $peserta) {
            $data = UserKelas::create([
                'user_id' => $peserta['user_id'],
                'name' => $peserta['name'],
                'kelas_id' => $Kelas->id,
            ]);
        }

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
        $kelas = kelas::with('program.cabang')->where('id', $id)->first();
        return response()->json($kelas);
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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $Kelas = Kelas::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'program_id' => $request->program_id,
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
