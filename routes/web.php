<?php

use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/print/pengaduan/{id}', [PengaduanController::class, 'print'])->name('print.pengaduan');

Route::get('/print/all-pengaduan', [PengaduanController::class, 'printAll'])->name('print.all.pengaduan');
