<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Pembayaran;
use App\Models\SuperAdmin\CabangLembaga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminPembayaranController extends Controller
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
        $validator = Validator::make($request->all(), [
            'norek' => 'required',
            'nama_bank' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $branchCode = 'ltq';
        $dateCode = date('ymd');
        $code = $dateCode  . $branchCode;
        return response()->json($code);

        $file_name = $request->type_bank->getClientOriginalName();
        $image = $request->type_bank->storeAs('public/type_bank', $file_name);
        $Pembayaran = Pembayaran::create([
            'nama_bank' => $request->nama_bank,
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
    public function ShowDataPembayaran($id)
    {
        $Pembayaran = Pembayaran::with('user')->where('id', $id)->latest()->first();
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
        $validator = Validator::make($request->all(), [
            'norek' => 'required',
            'nama_bank' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $Pembayaran = Pembayaran::find($id);
        if (Request()->hasFile('type_bank')) {
            if (Storage::exists($Pembayaran->type_bank)) {
                Storage::delete($Pembayaran->type_bank);
            }
            $file_name = $request->type_bank->getClientOriginalName();
            $image = $request->type_bank->storeAs('public/type_bank', $file_name);
            // $image = $request->poto->store('thumbnail');
            $Pembayaran->update([
                'nama_bank' => $request->nama_bank,
                'norek' => $request->norek,
                'type_bank' => 'type_bank/' . $file_name,
            ]);
        } else {
            $Pembayaran->update([
                'norek' => $request->norek,
                'nama_bank' => $request->nama_bank,
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
