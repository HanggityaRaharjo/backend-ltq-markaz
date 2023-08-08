<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta\BiodataPeserta;
use App\Models\Peserta\VerifikasiPembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class VerifikasiPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataVerifikasiPembayaran()
    {
        $VerifikasiPembayaran = VerifikasiPembayaran::latest()->get();
        return response()->json(['Data' => $VerifikasiPembayaran]);
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
    public function CreateDataVerifikasiPembayaran(Request $request)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = User::where('uuid', $request->uuid)->first();

        $file_name = $request->bukti_pembayaran->getClientOriginalName();
        $image = $request->bukti_pembayaran->storeAs('public/bukti_pembayaran', $file_name);

        $VerifikasiPembayaran = VerifikasiPembayaran::create([
            'user_id' => $user->id,
            'bukti_pembayaran' => 'bukti_pembayaran/' . $file_name,
            'status' => 'Unpaid',
        ]);

        if ($VerifikasiPembayaran) {
            return response()->json(['message' => 'VerifikasiPembayaran Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'VerifikasiPembayaran Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataVerifikasiPembayaran($id)
    {
        $user = Auth::user()->id;
        $VerifikasiPembayaran = VerifikasiPembayaran::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $VerifikasiPembayaran]);
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
    public function UpdateDataVerifikasiPembayaran(Request $request, $id)
    {
        $user = User::where('uuid', $request->uuid)->first();
        $VerifikasiPembayaran = VerifikasiPembayaran::find($id);
        if (Request()->hasFile('bukti_pembayaran')) {
            if (Storage::exists($VerifikasiPembayaran->bukti_pembayaran)) {
                Storage::delete($VerifikasiPembayaran->bukti_pembayaran);
            }

            $file_name = $request->bukti_pembayaran->getClientOriginalName();
            $image = $request->bukti_pembayaran->storeAs('public/bukti_pembayaran', $file_name);

            $VerifikasiPembayaran->update([
                'user_id' => $user->id,
                'bukti_pembayaran' => 'bukti_pembayaran/' . $file_name,
                'status' => $request->status,
            ]);
        } else {
            $VerifikasiPembayaran->update([
                'user_id' => $user,
                'status' => $request->status,
            ]);
        }
        if ($VerifikasiPembayaran) {
            return response()->json(['message' => 'VerifikasiPembayaran Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'VerifikasiPembayaran Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataVerifikasiPembayaran($id)
    {
        $VerifikasiPembayaran = VerifikasiPembayaran::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Bukti Pembayaran Berhasil Dihapus']);
    }
}