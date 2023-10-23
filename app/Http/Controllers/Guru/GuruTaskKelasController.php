<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru\kelas;
use App\Models\Guru\TaskKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class GuruTaskKelasController extends Controller
{
    public function getTaskAllKelas()
    {
        $taskKelas = TaskKelas::with("kelas")->get();
        return response()->json($taskKelas);
    }

    public function getTaskByKelas($kelas_id)
    {
        $taskKelas = TaskKelas::with("kelas")->where('kelas_id', $kelas_id)->get();
        return response()->json($taskKelas);
    }
    public function getTaskById($id)
    {
        $taskKelas = TaskKelas::with("kelas")->where('id', $id)->get();
        return response()->json($taskKelas);
    }
    public function createTaskKelas(Request $request)
    {
        // return response()->json($request->all());


        try {

            $validator = Validator::make($request->all(), [
                'description' => 'required|string',
                'kelas_id' => 'required|integer',
                'type' => 'required',
                'additional' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('additional') && Request()->hasFile('type')) {

                $file_nametype = $request->type->getClientOriginalName();
                $namaGambar = str_replace(' ', '_', $file_nametype);
                $image = $request->type->storeAs('public/type', $namaGambar);

                $file_nameadditional = $request->additional->getClientOriginalName();
                $namaGambar2 = str_replace(' ', '_', $file_nameadditional);
                $image = $request->additional->storeAs('public/additional', $namaGambar2);

                $taskKelas = TaskKelas::create([
                    'kelas_id' => $request->kelas_id,
                    'description' => $request->description,
                    'type' => 'type/' . $namaGambar,
                    'additional' => 'additional/' . $namaGambar2
                ]);

                return response()->json($taskKelas);
            } elseif (Request()->hasFile('type')) {

                $file_nametype = $request->type->getClientOriginalName();
                $image = $request->type->storeAs('public/type', $file_nametype);

                $taskKelas = TaskKelas::create([
                    'kelas_id' => $request->kelas_id,
                    'description' => $request->description,
                    'type' => $file_nametype,
                    'additional' => $request->additional,
                ]);
                return response()->json($taskKelas);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateTaskKelas(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'description' => 'required',
                'kelas_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $taskKelas = TaskKelas::where('id', $id)->first();
            if (Request()->hasFile('type') && Request()->hasFile('additional')) {

                $file_nametype = $request->type->getClientOriginalName();
                $namaGambar = str_replace(' ', '_', $file_nametype);
                $image = $request->type->storeAs('public/type', $namaGambar);

                $file_nameadditional = $request->additional->getClientOriginalName();
                $namaGambar2 = str_replace(' ', '_', $file_nameadditional);
                $image = $request->additional->storeAs('public/additional', $namaGambar2);
                $taskKelas->update([
                    'kelas_id' => $request->kelas_id,
                    'description' => $request->description,
                    'type' => 'type/' . $namaGambar,
                    'additional' => 'additional/' . $namaGambar2
                ]);
            }
            if (Request()->hasFile('type')) {

                $file_nametype = $request->type->getClientOriginalName();
                $namaGambar = str_replace(' ', '_', $file_nametype);
                $image = $request->type->storeAs('public/type', $namaGambar);

                $taskKelas->update([
                    'kelas_id' => $request->kelas_id,
                    'description' => $request->description,
                    'type' => 'type/' . $namaGambar,
                ]);
            }
            if (Request()->hasFile('additional')) {

                $file_nameadditional = $request->additional->getClientOriginalName();
                $namaGambar2 = str_replace(' ', '_', $file_nameadditional);
                $image = $request->additional->storeAs('public/additional', $namaGambar2);

                $taskKelas->update([
                    'kelas_id' => $request->kelas_id,
                    'description' => $request->description,
                    'additional' => 'additional/' . $namaGambar2
                ]);
            } else {
                $taskKelas->update([
                    'kelas_id' => $request->kelas_id,
                    'description' => $request->description,
                    // 'additional' => $request->additional,
                ]);
            }
            return response()->json(['massage' => 'Berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteTaskKelas($id)
    {
        $taskKelas = TaskKelas::where('id', $id)->first();
        $taskKelas->delete();
        return response()->json(['massage' => 'berhasil dihapus'], 200);
    }
}
