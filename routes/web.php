<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Frontend\CarController as FrontendController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\RentalController as FrontendRental;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
	// Route::get('/dashboard/1', [PageController::class, 'dashboard'])->name('dashboard');

	// Rental Routes
	Route::get('/cars/{car}/rent', [FrontendRental::class, 'create'])->name('rentals.create');
	Route::post('/cars/{car}/rent', [FrontendRental::class, 'store'])->name('rentals.store');
	Route::patch('/rentals/{rental}/cancel', [FrontendRental::class, 'cancel'])->name('rentals.cancel');
});

Route::get('/admin/dashboard', function () {
	$rentals   = Rental::all(); // Get all rentals
	$cars      = Car::all(); // Get all cars
	$users     = User::all(); // Get all users
	$totalCars = Car::count();

	return Inertia::render('Admin/Dashboard', [
		'rentals'   => $rentals,
		'cars'      => $cars,
		'users'     => $users,
		'totalCars' => $totalCars,
	]);
})->middleware(AdminMiddleware::class)->name('dashboard');

Route::get('/dashboard', function () {
	$rentals = Rental::with('car')
		->where('user_id', Auth::id())
		->get();

	return Inertia::render('Dashboard', [
		'rentals' => [
			'data' => $rentals,
		],
		'flash'   => [
			'success' => session('success'),
			'error'   => session('error'),
		],
	]);
})->middleware(CustomerMiddleware::class)->name('CustomerDashboard');
Route::post('/rentals/{rental}/cancel', [FrontendRental::class, 'cancel'])
	->middleware(CustomerMiddleware::class)
	->name('rentals.cancel');

Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {
	Route::resource('customers', CustomerController::class);
	Route::resource('cars', CarController::class);
	Route::resource('rentals', RentalController::class);
});

require __DIR__ . '/auth.php';
