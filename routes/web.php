<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TheaterController;
use App\Models\Screening;
use App\Models\Customer;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;

/* ----- PUBLIC ROUTES ----- */

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::view('/', 'home')->name('home');


Route::get('movies/showcase', [MovieController::class, 'showCase'])
    ->name('movies.showcase')
    ->can('viewShowCase', Movie::class);


Route::resource('movies', MovieController::class)->only(['show']);


Route::delete('theater/{theater}/image', [TheaterController::class, 'destroyImage'])
        ->name('theaters.image.destroy')
        ->can('update', Movie::class);
Route::resource('theaters', TheaterController::class);


Route::get('tickets/{ticket}', [TicketController::class, 'show'])
    ->name('tickets.show');
Route::resource('tickets', TicketController::class);


Route::get('movies/{movie}/screenings', [MovieController::class, 'showScreenings'])
    ->name('movies.screenings');
    //->can('viewCurriculum', Movie::class);


Route::get('screenings/{screenings}/seats', [SeatController::class, 'show'])
    ->name('seats.show');

Route::resource('movies', MovieController::class)->only(['show']);


/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});

/* ----- Verified users ----- */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::view('/home', 'home')->name('home');

    Route::get('/dashboard', function () {
        return redirect('movies/showcase');
    })->name('dashboard');


    Route::delete('movies/{movie}/image', [MovieController::class, 'destroyImage'])
        ->name('movies.image.destroy')
        ->can('update', Movie::class);

    //Movie resource routes are protected by MoviePolicy on the controller
    // The route 'show' is public (for anonymous user)
    Route::resource('movies', MovieController::class)->except(['show']);

    //Department resource routes are protected by DepartmentPolicy on the controller
    Route::resource('genres', GenreController::class);
    Route::resource('movies', MovieController::class)->except(['show']);


    Route::get('screenings/my', [ScreeningController::class, 'myScreenings'])
        ->name('screenings.my')
        ->can('viewMy', Screening::class);

    //Screening resource routes are protected by ScreeningPolicy on the controller
    //Screenings index and show are public
    Route::resource('screenings', ScreeningController::class)->except(['index', 'show']);

    Route::get('customers/my', [CustomerController::class, 'myCustomers'])
        ->name('customers.my')
        ->can('viewMy', Customer::class);

    Route::delete('customers/{customer}/photo', [CustomerController::class, 'destroyPhoto'])
        ->name('customers.photo.destroy')
        ->can('update', 'customer');

    //Customer resource routes are protected by CustomerPolicy on the controller
    Route::resource('customers', CustomerController::class);

    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy');//->can('update', 'administrative');

    //Admnistrative resource routes are protected by AdministrativePolicy on the controller
    Route::resource('administratives', AdministrativeController::class);

    // Confirm (store) the cart and save Screenings registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])
        ->name('cart.confirm')
        ->can('confirm-cart');
});

/* ----- OTHER PUBLIC ROUTES ----- */

// Use Cart routes should be accessible to the public
Route::middleware('can:use-cart')->group(function () {
    // Add a Screening to the cart:
    Route::post('cart/{screening}', [CartController::class, 'addToCart'])
        ->name('cart.add');
    // Remove a Screening from the cart:
    Route::delete('cart/{screening}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});

//Screenings index and show are public
Route::resource('screenings', ScreeningController::class)->only(['index', 'show']);

require __DIR__ . '/auth.php';
