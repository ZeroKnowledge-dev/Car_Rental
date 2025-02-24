<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class CarController extends Controller {
	/**
	 * Display a listing of available cars.
	 */
	public function index() {
		$cars = Car::all();

		return Inertia::render('Frontend/Cars/Index', [
			'cars'        => $cars,
			'canLogin'    => Route::has('login'),
			'canRegister' => Route::has('register'),
		]);
	}

	/**
	 * Display the specified car.
	 */
	public function show(Car $car) {
		// Load similar cars
		$similarCars = Car::where('car_type', $car->car_type)
			->where('id', '!=', $car->id)
			->where('availability', true)
			->take(3)
			->get();

		return Inertia::render('Frontend/Cars/Show', [
			'car'         => $car,
			'similarCars' => $similarCars,
			'canLogin'    => Route::has('login'),
			'canRegister' => Route::has('register'),
		]);
	}

	/**
	 * Check car availability for specific dates.
	 */
	public function checkAvailability(Request $request, Car $car) {
		$request->validate([
			'start_date' => 'required|date|after_or_equal:today',
			'end_date'   => 'required|date|after:start_date',
		]);

		$isAvailable = $car->availability && !$car->rentals()
			->where(function ($query) use ($request) {
				$query->whereBetween('start_date', [$request->start_date, $request->end_date])
					->orWhereBetween('end_date', [$request->start_date, $request->end_date])
					->orWhere(function ($q) use ($request) {
						$q->where('start_date', '<=', $request->start_date)
							->where('end_date', '>=', $request->end_date);
					});
			})
			->where('status', 'ongoing')
			->exists();

		return response()->json(['available' => $isAvailable]);
	}
}
