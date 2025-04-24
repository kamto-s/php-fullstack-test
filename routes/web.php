<?php

use App\Http\Controllers\MyClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('client/datatable', [MyClientController::class, 'getDataClients']);
Route::resource('clients', MyClientController::class);
