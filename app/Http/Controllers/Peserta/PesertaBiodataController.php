<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Peserta\BiodataPeserta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PesertaBiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getbiodatapeserta()
    {
        $biodata = BiodataPeserta::with('userbiodata')->get();
        return response()->json($biodata);
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
    public function createbiodatapeserta(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'photo' => 'required',
            'photo_ktp' => 'required',
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = User::where('uuid', $request->uuid)->first();

        $file_name = $request->photo->getClientOriginalName();
        $namaGambar = str_replace(' ', '_', $file_name);
        $image = $request->photo->storeAs('public/photo', $namaGambar);

        $file_name2 = $request->photo_ktp->getClientOriginalName();
        $namaGambar2 = str_replace(' ', '_', $file_name2);
        $image2 = $request->photo_ktp->storeAs('public/photo_ktp', $namaGambar2);

        $biodata = BiodataPeserta::create([
            'uuid' => Str::uuid(),
            'user_id' => $user_id->id,
            'full_name' => $request->full_name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'photo' => 'photo/' . $namaGambar,
            'photo_ktp' => 'photo_ktp/' . $namaGambar2,
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
    public function showbiodatapeserta($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $biodata = BiodataPeserta::with('userbiodata')->where('user_id', $user->id)->first();
        return response()->json($biodata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatebiodatapeserta(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('uuid', $uuid)->first();
        $biodata = BiodataPeserta::where('user_id', $user->id)->first();
        if (Request()->hasFile('photo')) {
            if (Storage::exists($biodata->photo)) {
                Storage::delete($biodata->photo);
            }

            $file_name = $request->photo->getClientOriginalName();
            $namaGambar = str_replace(' ', '_', $file_name);
            $image = $request->photo->storeAs('public/photo', $namaGambar);

            $biodata->update([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'photo' => 'photo/' . $namaGambar,
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
            $namaGambar2 = str_replace(' ', '_', $file_name2);
            $image2 = $request->photo_ktp->storeAs('public/photo_ktp', $namaGambar2);

            $biodata->update([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'photo_ktp' => 'photo_ktp/' . $namaGambar2,
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
    public function deletebiodatapeserta($uuid)
    {
        $data = BiodataPeserta::where('uuid', $uuid)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
