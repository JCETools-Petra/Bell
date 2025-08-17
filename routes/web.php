<?php

use Illuminate\Support\Facades\Route;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RoomController as FrontendRoomController;
use App\Http\Controllers\Frontend\MiceController as FrontendMiceController;

// Backend (Admin) Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\MiceRoomController as AdminMiceRoomController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Frontend\BookingController;
use Spatie\Sitemap\SitemapGenerator;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == FRONTEND ROUTES ==
// URUTAN YANG BENAR
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [FrontendRoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/availability', [FrontendRoomController::class, 'checkAvailability'])->name('rooms.availability'); // Pindahkan ke sini
Route::get('/rooms/{slug}', [FrontendRoomController::class, 'show'])->name('rooms.show'); // Ini sekarang di bawah
Route::get('/mice', [FrontendMiceController::class, 'index'])->name('mice.index');
Route::get('/mice/{slug}', [FrontendMiceController::class, 'show'])->name('mice.show');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/sitemap.xml', function () {
    return SitemapGenerator::create(config('app.url'))->generate()->toResponse(request());
});

// == BACKEND (ADMIN) ROUTES ==
// Grup ini memerlukan user untuk login sebelum mengaksesnya
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Routes untuk Kamar Hotel
    Route::resource('rooms', AdminRoomController::class);

    // CRUD Routes untuk Ruang MICE
    Route::resource('mice', AdminMiceRoomController::class);

    // Routes untuk pengaturan Homepage
    Route::get('homepage-settings', [HomepageSettingController::class, 'edit'])->name('homepage.edit');
    Route::put('homepage-settings', [HomepageSettingController::class, 'update'])->name('homepage.update');
    Route::get('images/{image}/delete', [ImageController::class, 'destroy'])->name('images.destroy');
    Route::resource('bookings', AdminBookingController::class);
});


// Route bawaan dari Laravel Breeze untuk autentikasi
require __DIR__.'/auth.php';