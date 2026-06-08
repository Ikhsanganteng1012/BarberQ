<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\HairStyleController as AdminHairStyleController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Testimonials
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::post('/testimonials', [TestimonialController::class, 'store'])->middleware('auth')->name('testimonials.store');

// Booking (requires login)
Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});
Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])
    ->middleware('signed')
    ->name('booking.confirmation');
Route::post('/booking/confirmation/{booking}/payment', [BookingController::class, 'choosePayment'])
    ->middleware('signed')
    ->name('booking.payment');
Route::get('/booking/confirmation/{booking}/print', [BookingController::class, 'printBarcode'])
    ->middleware('signed')
    ->name('booking.print');
Route::post('/booking/confirmation/{booking}/proof', [BookingController::class, 'uploadProof'])
    ->middleware('signed')
    ->name('booking.proof');

// Contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Dashboard User (untuk melihat booking history)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');

    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/my-bookings/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Konsultasi model rambut (selfie -> admin rekomendasi)
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});

// Admin routes (akan diisi lengkap nanti)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::post('/users/{user}/active', [AdminUserController::class, 'updateActive'])->name('users.active');

    Route::resource('galleries', AdminGalleryController::class)->except(['show']);
    Route::resource('services', AdminServiceController::class)->except(['show']);
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('/testimonials/{testimonial}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::post('/bookings/{booking}/payment', [AdminBookingController::class, 'updatePayment'])->name('bookings.payment');

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

    Route::get('/hair-styles', [AdminHairStyleController::class, 'index'])->name('hair-styles.index');
    Route::get('/hair-styles/create', [AdminHairStyleController::class, 'create'])->name('hair-styles.create');
    Route::post('/hair-styles', [AdminHairStyleController::class, 'store'])->name('hair-styles.store');
    Route::get('/hair-styles/{hairStyle}/edit', [AdminHairStyleController::class, 'edit'])->name('hair-styles.edit');
    Route::put('/hair-styles/{hairStyle}', [AdminHairStyleController::class, 'update'])->name('hair-styles.update');

    Route::get('/consultations', [AdminConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/{consultation}', [AdminConsultationController::class, 'show'])->name('consultations.show');
    Route::post('/consultations/{consultation}/reply', [AdminConsultationController::class, 'reply'])->name('consultations.reply');
});