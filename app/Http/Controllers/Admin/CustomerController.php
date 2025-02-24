<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class CustomerController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		$customers = User::where('role', 'customer')->get();

		return Inertia::render('Admin/Customer/Index', [
			'customers' => $customers,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		return Inertia::render('Admin/Customer/Create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$validation = $request->validate([
			'name'     => 'required|string|max:255',
			'email'    => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
		]);

		$validation['password'] = Hash::make($validation['password']);

		User::create($validation);

		return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id) {
		$customer = User::findOrFail($id);
		$rentals  = Rental::where('user_id', $id)->get();
		$cars     = Car::with(['rentals'])->get();
		return Inertia::render('Admin/Customer/Show', [
			'customer' => $customer,
			'rentals'  => $rentals,
			'cars'     => $cars,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id) {
		$customer = User::findOrFail($id);

		return Inertia::render('Admin/Customer/Edit', [
			'customer' => $customer,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
		$validation = $request->validate([
			'name'  => 'required|string|max:255',
			'email' => 'required|string|email|max:255',
		]);

		User::findOrFail($id)->update($validation);

		return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		$customer = User::findOrFail($id);
		$customer->delete();

		return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
	}
}
