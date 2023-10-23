<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminCabang\kota;
use App\Models\SuperAdmin\CabangLembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SuperAdminCabangLembagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataCabang()
    {
        $cabang = CabangLembaga::get();
        return response()->json($cabang);
    }
    public function GetDataCabangAllUser()
    {
        $cabang = CabangLembaga::with('users')->get();
        return response()->json($cabang);
    }
    public function getAllKotaCabang()
    {
        $datas = kota::with('cabang')->get();
        return response()->json($datas);
    }

    public function getCabangBySlug($slug)
    {
        $datas = CabangLembaga::where('slug', $slug)->first();
        return response()->json($datas);
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
    public function CreateDataCabang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required',
            'no_cabang' => 'required',
            'logo' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // $cabang_name = $request->nama_cabang;
        // $file_name = $request->logo->getClientOriginalExtension();
        // $nama = Str::slug($cabang_name) . '.' . $file_name;
        // $image = $request->logo->storeAs('public/logo', $nama);

        $file_name = $request->logo->getClientOriginalName();
        $namaGambar = str_replace(' ', '_', $file_name);
        $image = $request->logo->storeAs('public/logo', $namaGambar);
        $cabang = CabangLembaga::create([
            'nama_cabang' => $request->nama_cabang,
            'slug' => Str::slug($request->nama_cabang),
            'no_cabang' => $request->no_cabang,
            'logo' => 'logo/' . $namaGambar,
            'alamat' => $request->alamat,
            'kota_id' => 1,
        ]);

        if ($cabang) {
            return response()->json(['message' => 'cabang Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'cabang Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataCabang($id)
    {
        $cabang = CabangLembaga::where('id', $id)->first();
        return response()->json(['data' => $cabang]);
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
    public function UpdateDataCabang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required',
            'no_cabang' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cabang = CabangLembaga::find($id);
        if (Request()->hasFile('logo')) {
            if (Storage::exists($cabang->logo)) {
                Storage::delete($cabang->logo);
            }
            $file_name = $request->logo->getClientOriginalName();
            $namaGambar = str_replace(' ', '_', $file_name);
            $image = $request->logo->storeAs('public/logo', $namaGambar);
            // $image = $request->poto->store('thumbnail');
            $cabang->update([
                'nama_cabang' => $request->nama_cabang,
                'no_cabang' => $request->no_cabang,
                'logo' => 'logo/' . $namaGambar,
                'alamat' => $request->alamat,
            ]);
        } else {
            $cabang->update([
                'nama_cabang' => $request->nama_cabang,
                'no_cabang' => $request->no_cabang,
                'alamat' => $request->alamat,
            ]);
        }
        if ($cabang) {
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
    public function DeleteDataCabang($id)
    {
        $cabang = CabangLembaga::where('id', $id)->first();
        $cabang->delete();
        if ($cabang) {
            return response()->json(['message' => 'cabang Berhasil Dihapus']);
        } else {
            return response()->json(['message' => 'cabang Gagal Dihapus']);
        }
    }
}
