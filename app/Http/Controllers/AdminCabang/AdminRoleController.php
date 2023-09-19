<?php

namespace App\Http\Controllers\AdminCabang;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *\
     * @return \Illuminate\Http\Response
     */
    public function GetDataRole()
    {
        $role = Role::with('user')->get();
        return response()->json(['data' => $role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $roledata = $request->user_id;
        $hasRole = Role::where('user_id', $roledata)->first();
        if (empty($hasRole)) {
            $dataRole = Role::create([
                'user_id' => $roledata,
                'superadmin' => $request->superadmin,
                'admincabang' => $request->admincabang,
                'peserta' => $request->peserta,
                'guru' => $request->guru,
                'tatausaha' => $request->tatausaha,
                'bendahara' => $request->bendahara,
            ]);
            return response()->json(['message' => 'Berhasil dibuat']);
        } else {
            return response()->json(['message' => 'sudah dibuat']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateDataRole(Request $request, $uuid)
    {
        try {
            $request->validate([]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        foreach ($request->data as $data) {

            $user = User::where('uuid', $uuid)->first();
            if ($data == 1) {
                $role = Role::create([
                    "user_id" => $user->id,
                    "superadmin" => $request->superadmin,
                    "peserta" => $request->peserta,
                    "guru" => $request->guru,
                    "tatausaha" => $request->tatausaha,
                    "bendahara" => $request->bendahara,
                    "panitia_psb" => $request->panitia_psb,
                    "admincabang" => $request->admincabang,
                ]);
                return response()->json(['masage' => 'Success Create Data']);
            } elseif ($data == 0) {
                $role = Role::where('user_id', $user->id)->first();
                $role->delete();
                return response()->json(['masage' => 'Success Delete Data']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataRole($id, $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $role = Role::where('user_id', $user->id)->orWhere('id', $id)->first();
        return response()->json(['data' => $role]);
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
    public function UpdateDataRole(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_role' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        $user_role = Role::where('user_id', $id)->first();
        if (!empty($user_role)) {
            $user_role->update([
                "superadmin" => $request->superadmin,
                "peserta" => $request->peserta,
                "guru" => $request->guru,
                "tatausaha" => $request->tatausaha,
                "bendahara" => $request->bendahara,
                "panitia_psb" => $request->panitia_psb,
                "admincabang" => $request->admincabang,
            ]);

            return response()->json(["msg" => "success"]);
        } else {
            Role::create([
                "user_id" => $id,
                "superadmin" => $request->superadmin,
                "peserta" => $request->peserta,
                "guru" => $request->guru,
                "tatausaha" => $request->tatausaha,
                "bendahara" => $request->bendahara,
                "panitia_psb" => $request->panitia_psb,
                "admincabang" => $request->admincabang,
            ]);
            return response()->json("ksoong");
        }

        // return response()->json(['masage' => 'success', 'data' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteDataRole($id)
    {
        $role = Role::where('id', $id)->first();
        $role->delete();
        return response()->json(['masage' => 'Success Delete Data']);
    }
}
