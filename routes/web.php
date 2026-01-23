<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LetterCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

Route::middleware(['auth','role:member'])->prefix('member')->group(function(){

    Route::get('/', [MemberController::class,'index'])->name('member.dashboard');

    Route::get('/profile', [MemberController::class,'profile'])->name('member.profile');
    Route::post('/profile', [MemberController::class,'updateProfile']);

    Route::get('/plans', [MemberController::class,'membershipPlans'])->name('member.plans');

    Route::get('/subscriptions', [MemberController::class,'mySubscriptions'])
        ->name('member.subscriptions');

    Route::get('/attendance', [MemberController::class,'myAttendance']);

    Route::get('/report', [MemberController::class,'reportForm'])->name('member.report');
    Route::post('/report', [MemberController::class,'submitReport']);

    Route::get('/reports', [MemberController::class,'myReports']);

    Route::post('/check-in', [MemberController::class,'checkIn']);
    Route::post('/check-out', [MemberController::class,'checkOut']);

    Route::get('/password', [MemberController::class,'changePasswordForm']);
    Route::post('/password', [MemberController::class,'changePassword']);

    Route::get('/subscribe/{id}', [MemberController::class,'subscribe']);
    Route::post('/subscribe', [MemberController::class,'processSubscription']);

});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [HomeController::class, 'about']);

Route::get('/services', [HomeController::class, 'services']);

Route::get('/membership', [HomeController::class, 'membership']);

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::post('/contact/send', [HomeController::class, 'sendMessage'])->name('contact.send');

Route::get('/join', [HomeController::class, 'join']);


Route::middleware(['auth','admin'])->group(function(){

    Route::get('/gym', [GymController::class,'index']);

    Route::get('/gym/members', [GymController::class,'members'])->name('gym.members');

    Route::get('/gym/members/add', [GymController::class,'addMember']);

    Route::post('/gym/members/store', [GymController::class,'storeMember']);

    Route::get('/gym/members/edit/{id}', [GymController::class,'editMember']);

    Route::post('/gym/members/update/{id}', [GymController::class,'updateMember']);

    Route::delete('/gym/members/{id}', [GymController::class,'deleteMember']);

});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth');

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::prefix('master/lettercategory')->group(function () {

    Route::get('/', [LetterCategoryController::class, 'index'])
        ->name('lettercategory.index');

    Route::get('/create', [LetterCategoryController::class, 'create']);

    Route::post('/store', [LetterCategoryController::class, 'store']);

    Route::get('/edit/{id}', [LetterCategoryController::class, 'edit']);

    Route::post('/update/{id}', [LetterCategoryController::class, 'update']);

    Route::post('/delete', [LetterCategoryController::class, 'destroy']);


Route::prefix('master/inhabitant')->group(function () {

    Route::get('/', [InhabitantController::class, 'index'])
        ->name('inhabitant.index');

    Route::get('/create', [InhabitantController::class, 'create']);

    Route::post('/store', [InhabitantController::class, 'store']);

    Route::get('/edit/{id}', [InhabitantController::class, 'edit']);

    Route::post('/update/{id}', [InhabitantController::class, 'update']);

    Route::post('/delete', [InhabitantController::class, 'destroy']);

Route::prefix('master/admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::get('/create', [AdminController::class, 'create']);

    Route::post('/store', [AdminController::class, 'store']);

    Route::get('/edit/{id}', [AdminController::class, 'edit']);

    Route::post('/update/{id}', [AdminController::class, 'update']);

    Route::post('/delete', [AdminController::class, 'destroy']);


Route::get('/incoming', [IncomingController::class, 'index'])
    ->name('incoming.index');

Route::post('/incoming/store', [IncomingController::class, 'store'])
    ->name('incoming.store');

Route::prefix('outgoing')->group(function () {

    Route::get('/', [OutgoingController::class, 'index'])
        ->name('outgoing.index');

    Route::get('/create', [OutgoingController::class, 'create']);

    Route::post('/store', [OutgoingController::class, 'store']);

    Route::get('/edit/{id}', [OutgoingController::class, 'edit']);

    Route::post('/update/{id}', [OutgoingController::class, 'update']);

    Route::post('/delete', [OutgoingController::class, 'destroy']);

    Route::post('/realis', [OutgoingController::class, 'realis']);

    Route::post('/tindak', [OutgoingController::class, 'tindak']);

});