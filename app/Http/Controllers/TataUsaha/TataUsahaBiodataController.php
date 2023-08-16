<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\TataUsaha\BiodataTataUsaha;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TataUsahaBiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getbiodatatatausaha()
    {
        $biodata = BiodataTataUsaha::with('')->latest()->get();
        return response()->json(['Data' => $biodata]);
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
    public function createbiodatatatausaha(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required',
                // 'photo' => 'required',
                // 'photo_ktp' => 'required',
                'usia' => 'required',
                'jenis_kelamin' => 'required',
                'alamat' => 'required',
                'kelurahan' => 'required',
                'kecamatan' => 'required',
                'kabupaten_kota' => 'required',
                'provinsi' => 'required',
                'no_wa' => 'required',
                'no_alternatif' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user_id = User::where('uuid', $request->uuid)->first();
        $user = Auth::user()->id;

        // $file_name = $request->photo->getClientOriginalName();
        // $image = $request->photo->storeAs('public/photo', $file_name);

        // $file_name2 = $request->photo_ktp->getClientOriginalName();
        // $image2 = $request->photo_ktp->storeAs('public/photo_ktp', $file_name2);

        $biodata = BiodataTataUsaha::create([
            'uuid' => Str::uuid(),
            'user_id' => $user_id->id,
            'full_name' => $request->full_name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'photo_ktp' => 'photo_ktp',
            'photo' => 'photo',
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'no_wa' => $request->no_wa,
            'no_alternatif' => $request->no_alternatif,
        ]);

        if ($biodata) {
            return response()->json(['message' => 'Biodata Berhasil Ditambahkan']);
        } else {
            return response()->json(['message' => 'Biodata Gagal Ditambahkan']);
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
    public function showbiodatatatausaha($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $biodata = BiodataTataUsaha::with('userbiodata')->where('user_id', $user->id)->first();
        return response()->json(['Data' => $biodata]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatebiodatatatausaha(Request $request, $id)
    {
        $biodata = BiodataTataUsaha::find($id);
        $user = Auth::user()->id;
        if (Request()->hasFile('photo')) {
            if (Storage::exists($biodata->photo)) {
                Storage::delete($biodata->photo);
            }

            $file_name = $request->photo->getClientOriginalName();
            $image = $request->photo->storeAs('public/photo', $file_name);

            $biodata->update([
                'uuid' => Str::uuid(),
                'user_id' => $user,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'photo' => $image,
                'usia' => $request->usia,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi,
                'no_wa' => $request->no_wa,
                'no_alternatif' => $request->no_alternatif,
            ]);
        } elseif (Request()->hasFile('photo_ktp')) {
            if (Storage::exists($biodata->photo_ktp)) {
                Storage::delete($biodata->photo_ktp);
            }

            $file_name2 = $request->photo_ktp->getClientOriginalName();
            $image2 = $request->photo_ktp->storeAs('public/photo_ktp', $file_name2);

            $biodata->update([
                'uuid' => Str::uuid(),
                'user_id' => $user,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'photo_ktp' => $image2,
                'usia' => $request->usia,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi,
                'no_wa' => $request->no_wa,
                'no_alternatif' => $request->no_alternatif,
            ]);
        } else {
            $biodata->update([
                'user_id' => $user,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'usia' => $request->usia,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'keluraha' => $request->keluraha,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi,
                'no_wa' => $request->no_wa,
                'no_alternatif' => $request->no_alternatif,
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
    public function deletebiodatatatausaha($uuid)
    {
        $data = BiodataTataUsaha::where('uuid', $uuid)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
