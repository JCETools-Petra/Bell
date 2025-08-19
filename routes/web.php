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
use App\Http\Controllers\Frontend\AffiliateController;
use App\Http\Controllers\Frontend\MiceInquiryController;

// Backend (Admin) Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\MiceRoomController as AdminMiceRoomController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MiceInquiryController as AdminMiceInquiryController;
use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\UserController;

// Affiliate Dashboard Controller
use App\Http\Controllers\Affiliate\DashboardController as AffiliateDashboardController;
use App\Http\Controllers\Affiliate\BookingController as AffiliateBookingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
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

// Booking & Inquiries
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::post('/mice-inquiries', [MiceInquiryController::class, 'store'])->name('mice.inquiries.store');

// Affiliate Registration
Route::get('/affiliate/register', [AffiliateController::class, 'create'])->name('affiliate.register.create');
Route::post('/affiliate/register', [AffiliateController::class, 'store'])->name('affiliate.register.store');

// Sitemap
Route::get('/sitemap.xml', function () {
    return SitemapGenerator::create(config('app.url'))->generate()->toResponse(request());
});


// == BACKEND (ADMIN) & AFFILIATE DASHBOARD ROUTES ==

// Affiliate Dashboard (membutuhkan login sebagai affiliate yang aktif)
Route::middleware(['auth', 'affiliate.active'])->prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/dashboard', [AffiliateDashboardController::class, 'index'])->name('dashboard');
    Route::resource('bookings', AffiliateBookingController::class)->only(['create', 'store']);
});

// Admin Panel (membutuhkan login sebagai admin/pegawai terverifikasi)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Rute yang bisa diakses SEMUA STAF (Admin, Admin-Web, Accounting)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk ADMIN dan ACCOUNTING
    Route::middleware('role:admin,accounting')->group(function () {
        Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
        Route::get('/commissions/{affiliate}', [CommissionController::class, 'show'])->name('commissions.show');
        Route::post('/commissions/{affiliate}/pay', [CommissionController::class, 'markAsPaid'])->name('commissions.pay');
        Route::resource('commissions', CommissionController::class)->only(['create', 'store']); // Untuk form manual
    });

    // Rute yang HANYA BISA DIAKSES OLEH SUPER ADMIN
    Route::middleware('role:admin')->group(function () {
        // CRUDs
        Route::resource('rooms', AdminRoomController::class);
        Route::resource('mice', AdminMiceRoomController::class);
        Route::resource('restaurants', AdminRestaurantController::class);
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        Route::resource('bookings', AdminBookingController::class);
        Route::resource('mice-inquiries', AdminMiceInquiryController::class)->only(['index', 'destroy']);
        Route::resource('affiliates', AdminAffiliateController::class)->only(['index', 'update']);

        // Settings
        Route::get('homepage-settings', [HomepageSettingController::class, 'edit'])->name('homepage.edit');
        Route::put('homepage-settings', [HomepageSettingController::class, 'update'])->name('homepage.update');
        Route::get('contact-settings', [ContactSettingController::class, 'edit'])->name('contact.edit');
        Route::put('contact-settings', [ContactSettingController::class, 'update'])->name('contact.update');

        // Utilities
        Route::delete('restaurants/images/{image}', [AdminRestaurantController::class, 'destroyImage'])->name('restaurants.image.destroy');
        Route::get('images/{image}/delete', [ImageController::class, 'destroy'])->name('images.destroy');
    });
});


// Route bawaan dari Laravel Breeze untuk autentikasi
require __DIR__.'/auth.php';