<?php

namespace App\Http\Controllers\AdminCabang;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateDataRole(Request $request, $uuid, $id, $nama_role)
    {
        try {
            $request->validate([
                'nama_role' => 'required',
            ]);

            // Kode untuk mengupdate data pengguna jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        foreach ($request->data as $data) {

            $user = User::where('uuid', $uuid)->first();
            if ($request->input == 1) {
                $role = Role::create([
                    'user_id' => $data->user_id,
                    'nama_role' => $data->nama_role,
                ]);
                return response()->json(['masage' => 'Success Create Data']);
            } elseif ($request->input == 0) {
                $role = Role::where('user_id', $user->id)->where('nama_role', $nama_role)->first();
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
        $user_id = User::get();
        $role = Role::where('id', $id)->first()->update([
            'user_id' => $request->user_id,
            'nama_role' => $request->nama_role,
        ]);

        return response()->json(['masage' => 'success', 'data' => $role]);
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