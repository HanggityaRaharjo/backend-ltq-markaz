<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Guru\BiodataGuru;
use App\Models\Peserta\BiodataPeserta;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BuatAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDataAkun()
    {
        $akun = User::latest()->get();
        return response()->json(['data' => $akun]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateUserRole(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateDataAkun(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $userData = $request->email;

        $user = User::where('email', $userData)->first();

        if (empty($user)) {
            $dataUser = User::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'email' => $userData,
                'password' => encrypt($request->password),
            ]);
            return response()->json(['massage' => 'Akun Berhasil diBuat']);
        } else {
            return response()->json(['massage' => 'Akun Sudah Ada']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataAkun($uuid)
    {
        $akun = User::where('uuid', $uuid)->first();
        return response()->json(['data' => $akun]);
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
    public function UpdateDataAkun(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('id', $id)->first()->update([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role_id,
        ]);

        if ($user) {
            return response()->json(['message' => ' Berhasil Diupdate']);
        } else {
            return response()->json(['message' => ' Gagal Diupdate']);
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
        $akun = User::where('id', $id)->first();
        $akun->delete();
        return response()->json(['masage' => 'Berhasil Dihapus']);
    }
}
