<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\ProgramPembayaran;
use App\Models\Peserta\VerifikasiPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PesertaProgramPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataProgramPembayaran()
    {
        $ProgramPembayaran = ProgramPembayaran::with('program', 'cabang', 'pembayaran')->get();
        return response()->json($ProgramPembayaran);
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
    public function CreateDataProgramPembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $user_id = Auth::user()->id;
        // $data = ProgramPembayaran::where('user_id', $user_id)->get();

        // $total = $request->harga;

        // foreach ($data as $item) {
        //     $total += $item->harga;
        // }

        $total = $request->total;

        $user_id = User::where('uuid', $request->uuid)->first();
        $ProgramPembayaran = ProgramPembayaran::create([
            'user_id' => $user_id->id,
            'pembayaran_id' => $request->pembayaran_id,
            'total' => $total,

        ]);

        if ($ProgramPembayaran) {
            return response()->json(['message' => 'ProgramPembayaran Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'ProgramPembayaran Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataProgramPembayaran($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $ProgramPembayaran = ProgramPembayaran::with('program', 'pembayaran', 'cabang')->where('user_id', $user->id)->first();
        return response()->json($ProgramPembayaran);
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
    public function UpdateDataProgramPembayaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $ProgramPembayaran = ProgramPembayaran::create([
            'program_id' => $request->program_id,
            'cabang_lembaga_id' => $request->cabang_lembaga_id,
            'harga' => $request->harga,
        ]);

        if ($ProgramPembayaran) {
            return response()->json(['message' => 'Progra$ProgramPembayaran Berhasil Diupdate']);
        } else {
            return response()->json(['message' => 'Progra$ProgramPembayaran Gagal Diupdate']);
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
        $ProgramPembayaran = ProgramPembayaran::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Data Berhasil Dihapus']);
    }
}
