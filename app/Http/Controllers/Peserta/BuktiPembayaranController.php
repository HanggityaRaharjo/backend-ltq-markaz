<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta\BiodataPeserta;
use App\Models\Peserta\BuktiPembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class BuktiPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataBuktiPembayaran()
    {
        $BuktiPembayaran = BuktiPembayaran::latest()->get();
        return response()->json(['Data' => $BuktiPembayaran]);
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
    public function CreateDataBuktiPembayaran(Request $request)
    {
        try {
            $request->validate([
                'bukti_pembayaran' => 'required',
                'status' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = Auth::user()->id;

        $file_name = $request->bukti_pembayaran->getClientOriginalName();
        $image = $request->bukti_pembayaran->storeAs('public/bukti_pembayaran', $file_name);

        $BuktiPembayaran = BuktiPembayaran::create([
            'user_id' => $user,
            'bukti_pembayaran' => $image,
            'status' => 'Unpaid',
        ]);

        if ($BuktiPembayaran) {
            return response()->json(['message' => 'BuktiPembayaran Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'BuktiPembayaran Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataBuktiPembayaran($id)
    {
        $user = Auth::user()->id;
        $BuktiPembayaran = BuktiPembayaran::where('id', $user)->orWhere('id', $id)->first();
        return response()->json(['Data' => $BuktiPembayaran]);
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
    public function UpdateDataBuktiPembayaran(Request $request, $id)
    {
        $biodata = BuktiPembayaran::find($id);
        $user = Auth::user()->id;
        if (Request()->hasFile('photo')) {
            if (Storage::exists($biodata->photo)) {
                Storage::delete($biodata->photo);
            }

            $file_name = $request->bukti_pembayaran->getClientOriginalName();
            $image = $request->bukti_pembayaran->storeAs('public/bukti_pembayaran', $file_name);

            $biodata->update([
                'user_id' => $user,
                'bukti_pembayaran' => $image,
                'status' => $request->status,
            ]);
        } else {
            $biodata->update([
                'user_id' => $user,
                'status' => $request->status,
            ]);
        }
        if ($biodata) {
            return response()->json(['message' => 'Biodata Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Biodata Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataBuktiPembayaran($id)
    {
        $BuktiPembayaran = BuktiPembayaran::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'Bukti Pembayaran Berhasil Dihapus']);
    }
}
