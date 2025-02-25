<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PageController extends Controller {
	public function welcome() {
		$featuredCars = Car::where('availability', true)->latest()->take(6)->get();

		return Inertia::render('Welcome', [
			'featureCars' => $featuredCars,
		]);
	}

	public function about() {
		return Inertia::render('About', [
			'canLogin'    => Route::has('login'),
			'canRegister' => Route::has('register'),
		]);
	}

	public function contact() {
		return Inertia::render('Contact', [
			'canLogin'    => Route::has('login'),
			'canRegister' => Route::has('register'),
		]);
	}

	public function terms() {
		return Inertia::render('../Layouts/MainLayout', [
			'canLogin'    => Route::has('login'),
			'canRegister' => Route::has('register'),
		]);
	}
}
