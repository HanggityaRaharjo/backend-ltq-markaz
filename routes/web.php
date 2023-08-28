<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    //terdapat sebuah array yang berisi [3,4,5,1,2] lakukan sorting dari kecil ke terbesar kemudian sebaliknya
    //array tersebut semua kalikan 2 cek apakah terdapat bilangan prima 
    //tambahkan array [-5,4,5,1] gabungkan dengan array sebelumnya
    //cek apabilah terdapat nilai yang sama pada array tersebut dan ambil hanya satu dan replace menjadi satu
    //sorting dari kecil ke terbesar tetapi bilangan positif ambil hanya 5 angka

    $arr = [3, 4, 5, 1, 2];
    $n = count($arr);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return response()->json($arr);


    $arr = [3, 4, 5, 1, 2];
    for ($i = 0; $i < count($arr); $i++) {
        $arr[$i] *= 2;
    }
    return response()->json($arr);

    $arr = [3, 4, 5, 1, 2];
    $array = [-5, 4, 5, 1];
    $arr[] = $array;
    return response()->json($arr);

    $arr = [3, 4, 5, 1, 2];
    $array = [-5, 4, 5, 1];
    $arr[] = $array;
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 0; $j < count($array); $j++)
            if ($arr[$i] == $array[$j]) {
                $arr[$i] = $array[$j];
            }
    }
    return response()->json($arr);


    $arr = [3, 4, 5, 1, 2, -5,];
    $n = count($arr);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    $hanya5Array = [];
    for ($i = 0; $i < 5 && $i < count($arr); $i++) {
        $hanya5Array[] = $arr[$i];
    }
    return response()->json($hanya5Array);
});
