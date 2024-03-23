<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Home page */

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

/* Login page */
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login_post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/* Register page */
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register_post');
/* Auth pages */
Route::middleware(['auth'])->group(function () {

    /* Account route */
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account/informations', [AccountController::class, 'update_informations'])->name('informations');
    Route::put('/account/password', [AccountController::class, 'updade_password'])->name('password');
    Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('delete');

    /* Dashboard route */
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    /* Customers route */
    Route::get('/customers', [CustomersController::class, 'index'])->name('customers');
    Route::get('/customers/search', [CustomersController::class, 'search'])->name('search_customers');
    Route::post('/customers', [CustomersController::class, 'create'])->name('customers_post');
    Route::get('/customers/{id}', [CustomersController::class, 'edit'])->name('edit_customer');
    Route::put('/customers/{id}', [CustomersController::class, 'update'])->name('update_customer');
    Route::delete('/customers/{id}', [CustomersController::class, 'destroy'])->name('delete_customer');

    /* Vehicles route */
    Route::get('/vehicles', [VehiclesController::class, 'index'])->name('vehicles');
    Route::get('/vehicles/search', [VehiclesController::class, 'search'])->name('search_vehicles');
    Route::get('/vehicles/search_owner/{id}', [VehiclesController::class, 'search_owner'])->name('search_customer_vehicles');
    Route::get('/vehicles/{id}', [VehiclesController::class, 'index_owner'])->name('owner_vehicle');
    Route::post('/vehicles/{id}', [VehiclesController::class, 'create'])->name('create_vehicles');
    Route::get('/vehicles/{id_customer}/{id_vehicle}', [VehiclesController::class, 'edit'])->name('edit_vehicles');
    Route::put('/vehicles/{id_customer}/{id_vehicle}', [VehiclesController::class, 'update'])->name('update_vehicles');
    Route::delete('/vehicles/{id_customer}/{id_vehicle}', [VehiclesController::class, 'destroy'])->name('delete_vehicles');

    /* Reviews route */
    Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews');
    Route::post('/reviews/task/{id}', [ReviewsController::class, 'completed_task'])->name('completed_task');
    Route::get('/reviews/search', [ReviewsController::class, 'search'])->name('search_review');
    Route::get('/reviews/search_owner/{id}', [ReviewsController::class, 'search_owner'])->name('search_vehicles_review');
    Route::get('/reviews/{id}', [ReviewsController::class, 'index_owner_review'])->name('owner_review');
    Route::post('/reviews/{id}', [ReviewsController::class, 'create'])->name('create_review');
    Route::get('/reviews/{id_vehicle}/{id_review}', [ReviewsController::class, 'edit'])->name('edit_reviews');
    Route::put('/reviews/{id_vehicle}/{id_review}', [ReviewsController::class, 'update'])->name('update_reviews');
    Route::delete('/reviews/{id_vehicle}/{id_review}', [ReviewsController::class, 'destroy'])->name('delete_reviews');

    /* Files route */
    Route::get('/pdf', [PdfController::class, 'index'])->name('pdf');
    Route::get('/excel', [ExcelController::class, 'index'])->name('excel');
});

Route::fallback(function () {
    return view('access_denied');
});
