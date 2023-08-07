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
use Illuminate\Validation\ValidationException;

class ProgramPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataProgramPembayaran()
    {
        $ProgramPembayaran = ProgramPembayaran::with('program', 'cabang')->get();
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
        try {
            $request->validate([
                'total' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // $user_id = Auth::user()->id;
        // $data = ProgramPembayaran::where('user_id', $user_id)->get();

        // $total = $request->harga;

        // foreach ($data as $item) {
        //     $total += $item->harga;
        // }

        $total = $request->total;

        $file_name = $request->bukti_pembayaran->getClientOriginalName();
        $image = $request->bukti_pembayaran->storeAs('public/bukti_pembayaran', $file_name);
        $user_id = User::where('uuid', $request->uuid)->first();
        $ProgramPembayaran = ProgramPembayaran::create([
            'user_id' => $user_id->id,
            'bukti_pembayaran' => 'bukti_pembayaran/' . $file_name,
            'total' => $total,

        ]);

        $user_id = User::where('uuid', $request->uuid)->first();
        $verif = VerifikasiPembayaran::create([
            'user_id' => $user_id->id,
            'status' => 'unpaid',
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
    public function ShowDataProgramPembayaran($id)
    {
        $ProgramPembayaran = ProgramPembayaran::with('program', 'cabang')->where('id', $id)->get();
        return response()->json(['data' => $ProgramPembayaran]);
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
