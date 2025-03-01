<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RentalController extends Controller {
	/**
	 * Display a listing of the rentals.
	 */
	public function index() {
		$rentals = Rental::with(['user', 'car'])->get(); // Get all rentals with related user and car data

		return Inertia::render('Admin/Rentals/Index', [
			'rentals' => $rentals,
		]);
	}

	/**
	 * Show the form for creating a new rental.
	 */
	public function create() {
		$cars  = Car::where('availability', true)->get(); // Only available cars
		$users = User::where('role', 'customer')->get(); // All users

		return Inertia::render('Admin/Rentals/Create', [
			'cars'  => $cars,
			'users' => $users,
		]);
	}

	/**
	 * Store a newly created rental in storage.
	 */
	public function store(Request $request) {
		// Validate the request
		$request->validate([
			'user_id'    => 'required|exists:users,id',
			'car_id'     => 'required|exists:cars,id',
			'start_date' => 'required|date',
			'end_date'   => 'required|date|after_or_equal:start_date',
			'total_cost' => 'required|numeric|min:0',
		]);

		// Store the rental
		Rental::create([
			'user_id'    => $request->user_id,
			'car_id'     => $request->car_id,
			'start_date' => $request->start_date,
			'end_date'   => $request->end_date,
			'total_cost' => $request->total_cost,
		]);

		return redirect()->route('admin.rentals.index')->with('success', 'Rental created successfully.');
	}

	/**
	 * Display the specified rental.
	 */
	public function show(string $id) {
		$rental = Rental::with(['user', 'car'])->findOrFail($id); // Get rental with related user and car

		return Inertia::render('Admin/Rentals/Show', [
			'rental' => $rental,
		]);
	}

	/**
	 * Show the form for editing the specified rental.
	 */
	public function edit(string $id) {
		$rental = Rental::findOrFail($id); // Find rental by ID
		$car    = Car::where('availability', true)->get(); // Only available cars
		$user   = User::where('role', 'customer')->get(); // All users

		return Inertia::render('Admin/Rentals/Edit', [
			'rental' => $rental,
			'car'    => $car,
			'user'   => $user,
		]);
	}

	/**
	 * Update the specified rental in storage.
	 */
	public function update(Request $request, string $id) {
		$rental = Rental::findOrFail($id);

		// Validate the request
		$request->validate([
			'user_id'    => 'required|exists:users,id',
			'car_id'     => 'required|exists:cars,id',
			'start_date' => 'required|date',
			'end_date'   => 'required|date|after_or_equal:start_date',
			'total_cost' => 'required|numeric|min:0',
		]);

		// Update the rental
		$rental->update([
			'user_id'    => $request->user_id,
			'car_id'     => $request->car_id,
			'start_date' => $request->start_date,
			'end_date'   => $request->end_date,
			'total_cost' => $request->total_cost,
		]);

		return redirect()->route('admin.rentals.index')->with('success', 'Rental updated successfully.');
	}

	/**
	 * Remove the specified rental from storage.
	 */
	public function destroy(string $id) {
		$rental = Rental::findOrFail($id);
		$rental->delete(); // Delete the rental

		return redirect()->route('admin.rentals.index')->with('success', 'Rental deleted successfully.');
	}
}
