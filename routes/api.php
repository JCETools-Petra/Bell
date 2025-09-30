<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomPriceController;

// API route untuk mengecek harga kamar pada tanggal tertentu (setelah tanggal dipilih)
Route::get('/room-prices', [RoomPriceController::class, 'getPricesOnDate']);

// API route BARU untuk mengambil semua harga dalam sebulan (untuk ditampilkan di dalam kalender)
Route::get('/monthly-room-prices', [RoomPriceController::class, 'getPricesForMonth']);