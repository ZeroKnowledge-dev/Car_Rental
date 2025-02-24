<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class CarController extends Controller {
	/**
	 * Display a listing of the cars.
	 */
	public function index() {
		$cars = Car::all(); // Fetch all cars

		return Inertia::render('Admin/Cars/Index', [
			'cars' => $cars,
		]);
	}

	/**
	 * Show the form for creating a new car.
	 */
	public function create() {
		return Inertia::render('Admin/Cars/Create');
	}

	/**
	 * Store a newly created car in storage.
	 */
	public function store(Request $request) {
		// Validate incoming request data
		$request->validate([
			'name'             => 'required|string|max:255',
			'brand'            => 'required|string|max:255',
			'model'            => 'required|string|max:255',
			'year'             => 'required|integer|min:1900|max:' . date('Y'),
			'car_type'         => 'required|string|max:255',
			'daily_rent_price' => 'required|numeric|min:0',
			'availability'     => 'required|boolean',
			'image'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// If there's an image, handle the upload
		if ($request->hasFile('image')) {
			$imagePath = $request->file('image')->store('cars', 'public');
		}

		// Create the car
		Car::create([
			'name'             => $request->name,
			'brand'            => $request->brand,
			'model'            => $request->model,
			'year'             => $request->year,
			'car_type'         => $request->car_type,
			'daily_rent_price' => $request->daily_rent_price,
			'availability'     => $request->availability,
			'image'            => $imagePath,
		]);

		return redirect()->route('admin.cars.index')->with('success', 'Car created successfully.');
	}

	/**
	 * Display the specified car.
	 */
	public function show(string $id) {
		$car = Car::findOrFail($id); // Find car by ID

		return Inertia::render('Admin/Cars/Show', [
			'car' => $car,
		]);
	}

	/**
	 * Show the form for editing the specified car.
	 */
	public function edit(string $id) {
		$car = Car::findOrFail($id); // Find car by ID

		return Inertia::render('Admin/Cars/Edit', [
			'car' => $car,
		]);
	}

	/**
	 * Update the specified car in storage.
	 */
	public function update(Request $request, string $id) {
		$car = Car::findOrFail($id); // Find the car

		// Validate incoming request data
		$request->validate([
			'name'             => 'required|string|max:255',
			'brand'            => 'required|string|max:255',
			'model'            => 'required|string|max:255',
			'year'             => 'required|integer|min:1900|max:' . date('Y'),
			'car_type'         => 'required|string|max:255',
			'daily_rent_price' => 'required|numeric|min:0',
			'availability'     => 'required|boolean',
			'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// If there's an image, handle the upload
		if ($request->hasFile('image')) {
			$imagePath = $request->file('image')->store('cars', 'public');
		} else {
			$imagePath = $car->image; // Keep the old image if no new image was uploaded
		}

		// Update the car
		$car->update([
			'name'             => $request->name,
			'brand'            => $request->brand,
			'model'            => $request->model,
			'year'             => $request->year,
			'car_type'         => $request->car_type,
			'daily_rent_price' => $request->daily_rent_price,
			'availability'     => $request->availability,
			'image'            => $imagePath,
		]);

		return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully.');
	}

	/**
	 * Remove the specified car from storage.
	 */
	public function destroy(string $id) {
		$car = Car::findOrFail($id);

		// If the car has an image, delete it from storage
		$fullPath = public_path('/storage/' . $car->image);
		if (File::exists($fullPath)) {
			File::delete($fullPath);
		}

		$car->delete(); // Delete the car

		return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully.');
	}
}
