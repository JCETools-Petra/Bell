<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\SitemapGenerator;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RoomController as FrontendRoomController;
use App\Http\Controllers\Frontend\MiceController as FrontendMiceController;
use App\Http\Controllers\Frontend\RestaurantController as FrontendRestaurantController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\BookingController;

// Backend (Admin) Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\MiceRoomController as AdminMiceRoomController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Frontend\MiceInquiryController; 
use App\Http\Controllers\Admin\MiceInquiryController as AdminMiceInquiryController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == FRONTEND ROUTES ==
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rooms
Route::get('/rooms', [FrontendRoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/availability', [FrontendRoomController::class, 'checkAvailability'])->name('rooms.availability');
Route::get('/rooms/{slug}', [FrontendRoomController::class, 'show'])->name('rooms.show');

// MICE
Route::get('/mice', [FrontendMiceController::class, 'index'])->name('mice.index');
Route::get('/mice/{slug}', [FrontendMiceController::class, 'show'])->name('mice.show');

// Restaurants
Route::get('/restaurants', [FrontendRestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{slug}', [FrontendRestaurantController::class, 'show'])->name('restaurants.show');

// Contact Us
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');

// Booking
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

Route::post('/mice-inquiries', [MiceInquiryController::class, 'store'])->name('mice.inquiries.store');

// Sitemap
Route::get('/sitemap.xml', function () {
    return SitemapGenerator::create(config('app.url'))->generate()->toResponse(request());
});


// == BACKEND (ADMIN) ROUTES ==
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resources
    Route::resource('rooms', AdminRoomController::class);
    Route::resource('mice', AdminMiceRoomController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('restaurants', AdminRestaurantController::class);

    // Image Deletion Routes
    Route::delete('restaurants/images/{image}', [AdminRestaurantController::class, 'destroyImage'])->name('restaurants.image.destroy');
    Route::get('images/{image}/delete', [ImageController::class, 'destroy'])->name('images.destroy');

    // Settings Routes
    Route::get('homepage-settings', [HomepageSettingController::class, 'edit'])->name('homepage.edit');
    Route::put('homepage-settings', [HomepageSettingController::class, 'update'])->name('homepage.update');
    
    Route::get('contact-settings', [ContactSettingController::class, 'edit'])->name('contact.edit');
    Route::put('contact-settings', [ContactSettingController::class, 'update'])->name('contact.update');

    Route::resource('mice-inquiries', MiceInquiryController::class)->only(['index', 'destroy']);
    
    Route::resource('mice-inquiries', AdminMiceInquiryController::class)->only(['index', 'destroy']);

});


// Route bawaan dari Laravel Breeze untuk autentikasi
require __DIR__.'/auth.php';