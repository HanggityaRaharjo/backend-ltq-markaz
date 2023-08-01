<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateTableController extends Controller
{
    public function createTable(Request $request)
    {
        $tableName = $request->input('table_name');

        // Pastikan nama tabel hanya terdiri dari karakter alfanumerik
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            return response()->json(['error' => 'Invalid table name.'], 400);
        }

        // Periksa apakah tabel sudah ada dalam database
        if (Schema::hasTable($tableName)) {
            return response()->json(['error' => 'Table already exists.'], 400);
        }

        // Buat tabel baru
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            // Definisi kolom tabel lainnya
            // $table->string('column_name');
            // ...
            $table->timestamps();
        });

        return response()->json(['message' => 'Table created successfully.'], 201);
    }
}
