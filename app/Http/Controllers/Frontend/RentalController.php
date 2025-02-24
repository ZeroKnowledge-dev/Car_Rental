<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RentalController extends Controller {
	/**
	 * Show the rental form for a car.
	 */
	public function create(Car $car) {
		return Inertia::render('Frontend/Rentals/Create', [
			'car' => $car,
		]);
	}

	/**
	 * Store a newly created rental in storage.
	 */
	public function store(Request $request, Car $car) {
		$validated = $request->validate([
			'start_date' => 'required|date|after_or_equal:today',
			'end_date'   => 'required|date|after:start_date',
		]);

		// Check if car is available for these dates
		$isAvailable = !$car->rentals()
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

		if (!$isAvailable) {
			return back()->withErrors(['message' => 'Car is not available for the selected dates.']);
		}

		// Calculate total cost
		$days      = date_diff(date_create($request->start_date), date_create($request->end_date))->days + 1;
		$totalCost = $car->daily_rent_price * $days;

		// Create rental
		$rental = Rental::create([
			'user_id'    => Auth::id(),
			'car_id'     => $car->id,
			'start_date' => $request->start_date,
			'end_date'   => $request->end_date,
			'total_cost' => $totalCost,
		]);

		// Update car availability
		$car->update(['availability' => false]);

		return redirect()->route('dashboard')
			->with('success', 'Car rental booked successfully!');
	}

	/**
	 * Cancel a rental.
	 */
	public function cancel(Rental $rental) {
		if ($rental->user_id !== Auth::id()) {
			abort(403);
		}

		if ($rental->status !== 'ongoing') {
			return back()->withErrors(['message' => 'This rental cannot be canceled.']);
		}

		if (strtotime($rental->start_date) <= strtotime('today')) {
			return back()->withErrors(['message' => 'Cannot cancel a rental that has already started.']);
		}

		$rental->update(['status' => 'canceled']);
		$rental->car->update(['availability' => true]);

		return redirect()->route('dashboard')
			->with('success', 'Rental canceled successfully.');
	}
}
