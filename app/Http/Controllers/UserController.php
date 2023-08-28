<?php

namespace App\Http\Controllers;

use App\Mail\kirimEmail;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\MyNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_user_active()
    {
        $user = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('nama_role', 'peserta');
        })->where('status', 'active')->get();
        return response()->json($user);
    }
    public function get_user()
    {
        $user = User::with('roles', 'UserCabang', 'biodata_peserta', 'biodata_guru', 'biodata_tatausaha', 'user_level', 'UserPaket', 'UserProgram', 'RequestDay', 'CutiPeserta', 'CutiGuru', 'spp', 'dpp', 'kegiatan', 'ziswaf', 'CutiTataUsaha', 'kelas', 'absensi_peserta', 'program_pembayaran', 'input_nilai', 'konsumen')->get();
        return response()->json($user);
    }

    public function kirimEmail(Request $request)
    {

        $pesan = "<p>Selamat Datang Di LTQ</p>";

        $data_email = [
            'subject' => "Selamat Anda di terima",
            'sender_name' => "ervanherdiansyah9@gmail.com",
            'isi' => $pesan,
        ];

        $tujuan = $request->tujuan;
        foreach ($tujuan as $datas) {
            Mail::to($datas)->send(new kirimEmail($data_email));
        }
        return response()->json(['massage' => 'Success']);
    }
    public function kirimBroadcast(Request $request)
    {

        $pesan = "<p>Selamat Datang Di LTQ</p>";

        $data_email = [
            'subject' => "Selamat Anda di terima",
            'sender_name' => "ervanherdiansyah9@gmail.com",
            'isi' => $pesan,
        ];

        $tujuan = $request->tujuan;
        $notifiables = collect($tujuan)->map(function ($email) {
            return (new \Illuminate\Notifications\AnonymousNotifiable)->route('mail', $email);
        });

        Notification::send($notifiables, new MyNotification($data_email));

        return response()->json(['message' => 'Broadcast email sent successfully']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userData = $request->email;
        $roledata = $request->role;

        $user = User::where('email', $userData)->first();

        if (empty($user)) {
            $dataUser = User::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'email' => $userData,
                'password' => encrypt($request->password),
            ]);
            $dataRole = Role::create([
                'user_id' => $dataUser->id,
                'superadmin' => $request->superadmin,
                'admincabang' => $request->admincabang,
                'peserta' => $request->peserta,
                'guru' => $request->guru,
                'tatausaha' => $request->tatausaha,
                'bendahara' => $request->bendahara,
            ]);
        } else {
            return response()->json(['massage' => 'akun sudah ada']);
        }
        return response()->json(['massage' => 'akun berhasil dibuat']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowDataByUuidPeserta($uuid)
    {
        $user = User::with('user_level')->where('uuid', $uuid)->first();
        return response()->json($user);
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
    public function update_user(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::where('id', $id)->first()->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'Data Berhasil Di Update'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return response()->json(['message' => 'Data Berhasil Di Delete'], 201);
    }
}
