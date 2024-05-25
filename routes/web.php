<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Models\Screening;
use App\Models\Customer;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/* ----- PUBLIC ROUTES ----- */

Route::view('/', 'home')->name('home');

Route::get('Movies/showcase', [MovieController::class, 'showCase'])
    ->name('Movies.showcase')
    ->can('viewShowCase', Movie::class);

Route::get('Movies/{Movie}/curriculum', [MovieController::class, 'showCurriculum'])
    ->name('Movies.curriculum')
    ->can('viewCurriculum', Movie::class);


/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});

/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {


// CHECK THIS -------- -------- -------- --------
    /* ----- Non-Verified users ----- */
    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // });
// CHECK THIS -------- -------- -------- --------


    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::delete('Movies/{Movie}/image', [MovieController::class, 'destroyImage'])
        ->name('Movies.image.destroy')
        ->can('update', Movie::class);

    //Movie resource routes are protected by MoviePolicy on the controller
    // The route 'show' is public (for anonymous user)
    Route::resource('Movies', MovieController::class)->except(['show']);

    //Department resource routes are protected by DepartmentPolicy on the controller
    Route::resource('departments', GenreController::class);

    Route::get('Screenings/my', [ScreeningController::class, 'myScreenings'])
        ->name('Screenings.my')
        ->can('viewMy', Screening::class);

    //Screening resource routes are protected by ScreeningPolicy on the controller
    //Screenings index and show are public
    Route::resource('Screenings', ScreeningController::class)->except(['index', 'show']);

    Route::get('Customers/my', [CustomerController::class, 'myCustomers'])
        ->name('Customers.my')
        ->can('viewMy', Customer::class);

    Route::delete('Customers/{Customer}/photo', [CustomerController::class, 'destroyPhoto'])
        ->name('Customers.photo.destroy')
        ->can('update', 'Customer');

    //Customer resource routes are protected by CustomerPolicy on the controller
    Route::resource('Customers', CustomerController::class);

    Route::get('Customers/my', [CustomerController::class, 'myCustomers'])
        ->name('Customers.my')
        ->can('viewMy', Customer::class);
    Route::delete('Customers/{Customer}/photo', [CustomerController::class, 'destroyPhoto'])
        ->name('Customers.photo.destroy')
        ->can('update', 'Customer');
    //Customer resource routes are protected by CustomerPolicy on the controller
    Route::resource('Customers', CustomerController::class);

    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy')
        ->can('update', 'administrative');

    //Admnistrative resource routes are protected by AdministrativePolicy on the controller
    Route::resource('administratives', AdministrativeController::class);

    // Confirm (store) the cart and save Screenings registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])
        ->name('cart.confirm')
        ->can('confirm-cart');
});

/* ----- OTHER PUBLIC ROUTES ----- */

// Use Cart routes should be accessible to the public */
Route::middleware('can:use-cart')->group(function () {
    // Add a Screening to the cart:
    Route::post('cart/{Screening}', [CartController::class, 'addToCart'])
        ->name('cart.add');
    // Remove a Screening from the cart:
    Route::delete('cart/{Screening}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});


//Movie show is public.
Route::resource('Movies', MovieController::class)->only(['show']);

//Screenings index and show are public
Route::resource('Screenings', ScreeningController::class)->only(['index', 'show']);

require __DIR__ . '/auth.php';
