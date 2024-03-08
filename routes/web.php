<?php

use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EvenmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResetPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResetPasswordConteroller;



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



Route::get('/', [EvenmentController::class, 'index'])->name('home');


Route::middleware(['auth'])->get('/detaile/organisateur/{id}', [ReservationController::class, 'show'])->name('shows');
// Route::middleware(['auth'])->get('/detaile/organisateur/{id}', [ReservationController::class, 'show'])->name('shows');

Route::middleware(['auth'])->get('/accepeter/{id}', [ReservationController::class, 'accepeter'])->name('accepeter');

Route::middleware(['auth'])->get('/anniller/{id}', [ReservationController::class, 'anniller'])->name('anniller');

Route::get('/tickets/{ticketId}/download', [ReservationController::class, 'download'])->name('download.ticket');

Route::middleware(['auth'])->post('/evenement', [EvenmentController::class, 'store'])->name('evenement');

Route::get('/detaile/{id}', [EvenmentController::class, 'show'])->name('show');

Route::middleware(['auth'])->get('/edit/{id}', [EvenmentController::class, 'edit'])->name('updite');

Route::middleware(['auth'])->post('/update/{id}', [EvenmentController::class, 'update'])->name('updateEvenement');

Route::middleware(['auth'])->get('/delet/{id}', [EvenmentController::class, 'destroy'])->name('delete');

Route::middleware(['auth'])->get('/recherch', [EvenmentController::class, 'recherch'])->name('recherch');

Route::middleware(['auth'])->get('/recherchCategory', [EvenmentController::class, 'recherchCategory'])->name('recherchCategory');

Route::middleware(['auth'])->get('/accepter/{id}', [EvenmentController::class, 'accepter'])->name('accepter');


Route::get('/auth', [AuthController::class, 'create'])->name("creatUser");

Route::post('/auth', [AuthController::class, 'regester'])->name("register");

Route::get('/auth/login', [AuthController::class, 'getLogin'])->name(('getLogin'));
//
Route::post('/auth/login', [AuthController::class, 'login'])->name("login");

Route::middleware(['auth'])->get('/profile', [AuthController::class, 'index'])->name('profile');

Route::middleware(['auth'])->get('/admin', [AuthController::class, 'admin'])->name('admin');

Route::middleware(['auth'])->post('/profile', [AuthController::class, 'upload'])->name("upload.image");


Route::middleware(['auth'])->get('/logOut', [AuthController::class, 'logOut'])->name(('logOut'));

Route::middleware(['auth'])->get('/changerRoler/{id}', [AuthController::class, 'changerRoler'])->name(('changerRoler'));

Route::middleware(['auth'])->get('/userProfile', [AuthController::class, 'userProfile'])->name('userProfile');


Route::middleware(['auth'])->get('/ajouter', [ReservationController::class, 'ajouter'])->name('ajouter');

Route::middleware(['auth'])->post('/category', [CategorieController::class, 'store'])->name('category');
Route::middleware(['auth'])->get('/deletCategory/{id}', [CategorieController::class, 'destroy'])->name('delete.category');
Route::middleware(['auth'])->post('/upditCategory/{id}', [CategorieController::class, 'update'])->name('update.category');

// Route::get('/showForgotPasswordForm', [ResetPassword::class, 'showForgotPasswordForm'])->name(('PasswordForm'));

// Route::post('/sendResetLinkEmail', [ResetPassword::class, 'sendResetLinkEmail'])->name("password.email");

Route::get('/forgot-password', [ResetPassword::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ResetPassword::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPassword::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ResetPassword::class, 'resetPassword'])->name('password.update');
