<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\BiodataGuru;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\Peserta\BiodataPeserta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruBiodataController extends Controller
{
    public function getbiodataguru()
    {
        $biodata = BiodataGuru::with('userbiodata')->latest()->get();
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
    public function createbiodataguru(Request $request)
    {
        // return response()->json($request->all(), 'sampe sini');
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = User::where('uuid', $request->uuid)->first();
        $user = Auth::user()->id;

        $file_name = $request->photo->getClientOriginalName();
        $image = $request->photo->storeAs('public/photo', $file_name);

        $file_name2 = $request->photo_ktp->getClientOriginalName();
        $image2 = $request->photo_ktp->storeAs('public/photo_ktp', $file_name2);

        $biodata = BiodataGuru::create([
            'uuid' => Str::uuid(),
            'user_id' => $user_id->id,
            'full_name' => $request->full_name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'photo_ktp' => 'photo_ktp/' . $file_name2,
            'photo' => 'photo/' . $file_name,
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
    public function showbiodataguru($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $biodata = BiodataGuru::with('user')->where('user_id', $user->id)->first();
        return response()->json($biodata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatebiodataguru(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::where('uuid', $uuid)->first();
        $biodata = BiodataGuru::where('user_id', $user->id);
        if (Request()->hasFile('photo')) {
            if (Storage::exists($biodata->photo)) {
                Storage::delete($biodata->photo);
            }

            $file_name = $request->photo->getClientOriginalName();
            $image = $request->photo->storeAs('public/photo', $file_name);

            $biodata->update([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'photo' => 'photo/' . $file_name,
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
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'photo_ktp' => 'photo_ktp/' . $file_name2,
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
    public function deletebiodataguru($id)
    {
        $data = BiodataGuru::where('id', $id)->first();
        $data->delete();
        return response()->json(['msg' => ['status' => 200, 'pesan' => 'success deleted'], "data" => $data]);
    }
}
