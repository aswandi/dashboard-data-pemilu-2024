<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PetaSuaraController;
use App\Http\Controllers\PetaSuaraDprdProvController;
use App\Http\Controllers\DprRiController;
use App\Http\Controllers\DataPartaiController;
use App\Http\Controllers\DataProvinsiController;
use App\Http\Controllers\DataDapilController;
use App\Http\Controllers\ChangelogController;

Route::get('/', [PetaSuaraController::class, 'index'])->name('peta-suara.index');
Route::get('/peta-suara/dprd-prov', [PetaSuaraDprdProvController::class, 'index'])->name('peta-suara.dprd-prov');

// Data Utama Routes
Route::get('/data-utama/dpr-ri', [DprRiController::class, 'index'])->name('data-utama.dpr-ri');
Route::get('/data-utama/partai', [DataPartaiController::class, 'index'])->name('data-utama.partai');
Route::get('/data-utama/provinsi', [DataProvinsiController::class, 'index'])->name('data-utama.provinsi');
Route::get('/data-utama/dapil', [DataDapilController::class, 'index'])->name('data-utama.dapil');
Route::get('/data-utama/dapil/{proId}/{dapilNama}', [DataDapilController::class, 'detail'])->name('data-utama.dapil.detail');

// Changelog Route
Route::get('/changelog', [ChangelogController::class, 'index'])->name('changelog');
