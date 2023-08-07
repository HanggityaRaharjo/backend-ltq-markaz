<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Pembayaran;
use App\Models\SuperAdmin\CabangLembaga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataPembayaran()
    {
        $Pembayaran = Pembayaran::with('user')->latest()->get();
        return response()->json(['data' => $Pembayaran]);
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
    public function UpdateGenerateCode(Request $request, $id)
    {
        $branchCode = 'ltq';
        $dateCode = date('ymd');
        $code = $dateCode  . $branchCode . $request->input('nobank');

        $Pembayaran = Pembayaran::where('id', $id)->first()->update([
            'code' => $code,
        ]);
        return response()->json($code);
    }
    public function CreateGenerateCode(Request $request, $id)
    {
        // $cabang = CabangLembaga::where('id', $id)->first();
        $branchCode = 'ltq';
        $dateCode = date('ymd');
        $code = $dateCode  . $branchCode . $request->code;

        $Pembayaran = Pembayaran::create([
            'code' => $code,
        ]);
        return response()->json($code);
    }

    public function CreateDataPembayaran(Request $request)
    {
        try {
            $request->validate([
                'norek' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $branchCode = 'ltq';
        $dateCode = date('ymd');
        $code = $dateCode  . $branchCode;
        return response()->json($code);

        $file_name = $request->type_bank->getClientOriginalName();
        $image = $request->type_bank->storeAs('public/type_bank', $file_name);
        $Pembayaran = Pembayaran::create([
            'norek' => $code,
            'code' => $request->code,
            'type_bank' => 'type_bank/' . $file_name,
        ]);

        if ($Pembayaran) {
            return response()->json(['message' => 'Pembayaran Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Pembayaran Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataPemabayaran($id)
    {
        $user = Auth::user()->uuid;
        $Pembayaran = Pembayaran::with('user')->where('id', $id)->orWhere('uuid', $user)->latest()->first();
        return response()->json(['data' => $Pembayaran]);
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
    public function UpdateDataPembayaran(Request $request, $id)
    {
        $Pembayaran = Pembayaran::find($id);
        if (Request()->hasFile('type_bank')) {
            if (Storage::exists($Pembayaran->type_bank)) {
                Storage::delete($Pembayaran->type_bank);
            }
            $file_name = $request->type_bank->getClientOriginalName();
            $image = $request->type_bank->storeAs('public/type_bank', $file_name);
            // $image = $request->poto->store('thumbnail');
            $Pembayaran->update([
                'norek' => $request->norek,
                'type_bank' => 'type_bank/' . $file_name,
            ]);
        } else {
            $Pembayaran->update([
                'norek' => $request->norek,
            ]);
        }
        if ($Pembayaran) {
            return response()->json(['message' => 'Pembayaran Berhasil Diubah']);
        } else {
            return response()->json(['message' => 'Pembayaran Gagal Diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataPembayaran($id)
    {
        $Pembayaran = Pembayaran::where('id', $id)->first()->delete();
        return response()->json(['massage' => 'data berhasil dihapus']);
    }
}
