<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Frontend\CarController as FrontendController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\RentalController as FrontendRental;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Car Browsing Routes
Route::get('/cars', [FrontendController::class, 'index'])->name('cars');
Route::get('/cars/{car}', [FrontendController::class, 'show'])->name('cars.show');
Route::post('/cars/{car}/check-availability', [FrontendController::class, 'checkAvailability'])
	->name('cars.check-availability');

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	// Rental Routes
	Route::get('/cars/{car}/rent', [FrontendRental::class, 'create'])->name('rentals.create');
	Route::post('/cars/{car}/rent', [FrontendRental::class, 'store'])->name('rentals.store');
	Route::patch('/rentals/{rental}/cancel', [FrontendRental::class, 'cancel'])->name('rentals.cancel');
});

Route::get('/admin/dashboard', function () {
	$rentals = Rental::all(); // Get all rentals
	$cars    = Car::all(); // Get all cars
	$users   = User::all(); // Get all users

	return Inertia::render('Admin/Dashboard', [
		'rentals' => $rentals,
		'cars'    => $cars,
		'users'   => $users,
	]);
})->middleware(AdminMiddleware::class)->name('dashboard');

Route::get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->middleware(CustomerMiddleware::class)->name('CustomerDashboard');

Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {
	Route::resource('customers', CustomerController::class);
	Route::resource('cars', CarController::class);
	Route::resource('rentals', RentalController::class);
});

require __DIR__ . '/auth.php';
