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
        $typeData = $request->input();
        $columnNames = $request->input();
        Schema::create($tableName, function (Blueprint $table) use ($columnNames, $typeData) {
            $table->id();
            foreach ($columnNames as $columnName => $columnValue) {
                $table->string($columnName);
            }
            $table->timestamps();
        });

        return response()->json(['message' => 'Table created successfully.'], 201);
    }
}
