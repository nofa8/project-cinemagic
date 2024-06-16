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
use App\Models\Theater;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PDFControllerView;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ParametersController;

/* ----- PUBLIC ROUTES ----- */

Route::get('parameters', [ParametersController::class, 'index'])->name('parameters.index');
Route::post('/update-ticket-price', [ParametersController::class, 'updateTicketPrice'])->name('updateTicketPrice');
Route::post('/update-ticket-discount', [ParametersController::class, 'updateDiscount'])->name('updateDiscount');

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::view('/', 'home')->name('home');





Route::get('movies/showcase', [MovieController::class, 'showCase'])
    ->name('movies.showcase');






Route::resource('movies', MovieController::class)->only(['show']);

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::post('/tickets/verify/{screening}', [TicketController::class, 'verify'])->name('tickets.verify');
Route::post('/tickets/validate/{ticket}', [TicketController::class, 'validate'])->name('tickets.validate');

Route::get('theaters/deleted', [TheaterController::class, 'deleted'])
    ->name('theaters.deleted');
Route::patch('theaters/deleted/{theater}/save', [TheaterController::class, 'saveD'])
    ->name('theaters.save')->withTrashed();
Route::delete('theaters/{theater}/permanent-delete', [TheaterController::class, 'destructionD'])
    ->name('theaters.permanent-delete')->withTrashed();
Route::delete('theater/{theater}/image', [TheaterController::class, 'destroyImage'])
    ->name('theaters.image.destroy')
    ->can('update', Movie::class);

Route::resource('theaters', TheaterController::class);



Route::get('/tickets/ticket_qr_codes', [PDFControllerView::class, 'show'])->name('ticket.pdf');
Route::get('/receipts/receipt', [PDFControllerView::class, 'receipt'])->name('receipt.pdf');



Route::post('purchases/store', [PurchaseController::class,'store'])->name('purchases.store');



Route::get('tickets/{ticket}/show', [TicketController::class, 'show'])
    ->name('tickets.show');

Route::get('tickets/ticket/{ticket}', [TicketController::class, 'showTicket'])
    ->name('tickets.ticket');
Route::resource('tickets', TicketController::class)->except('show');


Route::get('movies/{movie}/screenings', [MovieController::class, 'showScreenings'])
    ->name('movies.screenings');
    //->can('viewCurriculum', Movie::class);


Route::delete('theaters/{theater}/seat', [SeatController::class, 'destroyUpdate'])->name('seats.destroyAll');

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
    Route::patch('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.update.image');
    Route::delete('/profile/image', [ProfileController::class, 'destroyImage'])->name('profile.destroy.image');


    Route::get('/dashboard', function () {
        return redirect('movies/showcase');
    })->name('dashboard');

    Route::post('/statistic/chosen', [StatisticsController::class, 'redirectioning'])->name('statistics.day');
    Route::get('statistics', [StatisticsController::class, 'index'])
        ->name('statistics.index');
    // ->can('viewStatistics', User::class);
    Route::post('/export-statistics', [StatisticsController::class, 'exportToExcel'])->name('statistics.export');


    //Purchases
    Route::get('purchases/my', [PurchaseController::class, 'myPurchases'])
            ->name('purchases.my');
    Route::resource('purchases', PurchaseController::class);

    

    // MOVIES

    Route::get('movies/create', [MovieController::class, 'create'])->name('movies.create');

    Route::get('movies/deleted', [MovieController::class, 'indexDeleted'])
    ->withTrashed()->name('movies.deleted');

    Route::patch('movies/deleted/{movie}/save', [MovieController::class, 'save'])
        ->name('movies.save')->withTrashed();

    Route::delete('movies/{movie}/permanent-delete', [MovieController::class, 'destruction'])
        ->name('movies.permanent-delete')->withTrashed();

    Route::delete('movies/{movie}/permanent-delete-forced', [MovieController::class, 'destructionForced'])
    ->name('movies.permanent-delete-forced')->withTrashed();

    Route::delete('movies/{movie}/image', [MovieController::class, 'destroyImage'])
        ->name('movies.image.destroy')
        ->can('update', Movie::class);
    Route::resource('movies', MovieController::class)->except(['show']);


    //GENRES
    Route::patch('genres/deleted/{genre}/save', [GenreController::class, 'save'])
    ->name('genres.save')->withTrashed();
    Route::delete('genres/{genre}/permanent-delete', [GenreController::class, 'destruction'])
    ->name('genres.permanent-delete')->withTrashed();
    Route::get('genres/deleted', [GenreController::class, 'indexDeleted'])
        ->withTrashed()
        ->name('genres.deleted');
    Route::resource('genres', GenreController::class);
    Route::resource('movies', MovieController::class)->except(['show']);


    

    Route::get('screenings/management', [ScreeningController::class, 'management'])->name('screenings.management');
    Route::resource('screenings', ScreeningController::class)->except('show');


    // CUSTOMERS
    // Route::get('customers/my', [CustomerController::class, 'myCustomers'])
    //     ->name('customers.my')
    //     ->can('viewMy', Customer::class);

    Route::delete('customers/{customer}/photo', [CustomerController::class, 'destroyPhoto'])
        ->name('customers.photo.destroy')
        ->can('update', 'customer');

    Route::post('customers/deleted/{customer}/block', [CustomerController::class, 'invertBlockTrash'])
        ->withTrashed()
        ->name('customers.deleted.invert');

    Route::post('customers/{customer}/block', [CustomerController::class, 'invertBlock'])
        ->name('customers.invert');

    Route::get('customers/deleted', [CustomerController::class, 'indexDeleted'])
        ->withTrashed()
        ->name('customers.deleted');
    Route::patch('customers/deleted/{customer}/save', [CustomerController::class, 'save'])
        ->name('customers.save')->withTrashed();
    Route::delete('customers/{customer}/permanent-delete', [CustomerController::class, 'destruction'])
        ->name('customers.permanent-delete')
        ->withTrashed();

    Route::resource('customers', CustomerController::class);

    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy');//->can('update', 'administrative');

    Route::patch('administratives/deleted/{administrative}/save', [TheaterController::class, 'save'])
    ->name('administratives.save')->withTrashed();
    Route::delete('administratives/{administrative}/permanent-delete', [TheaterController::class, 'destruction'])
    ->name('administratives.permanent-delete')->withTrashed();
    Route::get('administratives/deleted', [AdministrativeController::class, 'indexDeleted'])
    ->withTrashed()
    ->name('administratives.deleted');
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
