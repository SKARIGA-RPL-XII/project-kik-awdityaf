<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    IncomingController,
    OutgoingController,
    AdminController,
    LetterCategoryController,
    AuthController,
    DashboardController,
    HomeController,
    PaymentController,
    MemberController,
    GymController,
    InhabitantController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [HomeController::class, 'about']);
Route::get('/services', [HomeController::class, 'services']);
Route::get('/membership', [HomeController::class, 'membership']);

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact/send', [HomeController::class, 'sendMessage'])->name('contact.send');

Route::get('/join', [HomeController::class, 'join']);


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| PAYMENT (MIDTRANS)
|--------------------------------------------------------------------------
*/

Route::prefix('payment')->middleware('auth')->group(function () {

    Route::post('/create', [PaymentController::class, 'createTransaction']);

    Route::get('/finish', [PaymentController::class, 'finish']);

    Route::get('/client-key', [PaymentController::class, 'getClientKey']);

    Route::get('/test', [PaymentController::class, 'test']);
});

// Webhook (NO AUTH)
Route::post('/payment/notification', [PaymentController::class, 'notification']);


/*
|--------------------------------------------------------------------------
| MEMBER AREA
|--------------------------------------------------------------------------
*/

Route::prefix('member')
    ->middleware(['auth', 'role:member'])
    ->group(function () {

    Route::get('/', [MemberController::class, 'index'])
        ->name('member.dashboard');

    Route::get('/profile', [MemberController::class, 'profile'])
        ->name('member.profile');

    Route::post('/profile', [MemberController::class, 'updateProfile']);

    Route::get('/plans', [MemberController::class, 'membershipPlans'])
        ->name('member.plans');

    Route::get('/subscriptions', [MemberController::class, 'mySubscriptions'])
        ->name('member.subscriptions');

    Route::get('/attendance', [MemberController::class, 'myAttendance']);

    Route::get('/report', [MemberController::class, 'reportForm'])
        ->name('member.report');

    Route::post('/report', [MemberController::class, 'submitReport']);

    Route::get('/reports', [MemberController::class, 'myReports']);

    Route::post('/check-in', [MemberController::class, 'checkIn']);
    Route::post('/check-out', [MemberController::class, 'checkOut']);

    Route::get('/password', [MemberController::class, 'changePasswordForm']);
    Route::post('/password', [MemberController::class, 'changePassword']);

    Route::get('/subscribe/{id}', [MemberController::class, 'subscribe']);
    Route::post('/subscribe', [MemberController::class, 'processSubscription']);

});


/*
|--------------------------------------------------------------------------
| ADMIN / GYM AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::prefix('gym')->group(function () {

        Route::get('/', [GymController::class, 'index']);

        Route::get('/members', [GymController::class, 'members'])
            ->name('gym.members');

        Route::get('/members/add', [GymController::class, 'addMember']);

        Route::post('/members/store', [GymController::class, 'storeMember']);

        Route::get('/members/edit/{id}', [GymController::class, 'editMember']);

        Route::post('/members/update/{id}', [GymController::class, 'updateMember']);

        Route::delete('/members/{id}', [GymController::class, 'deleteMember']);
    });

});


/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
*/

Route::prefix('master')->middleware('auth')->group(function () {

    // Letter Category
    Route::prefix('lettercategory')->group(function () {

        Route::get('/', [LetterCategoryController::class, 'index'])
            ->name('lettercategory.index');

        Route::get('/create', [LetterCategoryController::class, 'create']);

        Route::post('/store', [LetterCategoryController::class, 'store']);

        Route::get('/edit/{id}', [LetterCategoryController::class, 'edit']);

        Route::post('/update/{id}', [LetterCategoryController::class, 'update']);

        Route::post('/delete', [LetterCategoryController::class, 'destroy']);
    });


    // Inhabitant
    Route::prefix('inhabitant')->group(function () {

        Route::get('/', [InhabitantController::class, 'index'])
            ->name('inhabitant.index');

        Route::get('/create', [InhabitantController::class, 'create']);

        Route::post('/store', [InhabitantController::class, 'store']);

        Route::get('/edit/{id}', [InhabitantController::class, 'edit']);

        Route::post('/update/{id}', [InhabitantController::class, 'update']);

        Route::post('/delete', [InhabitantController::class, 'destroy']);
    });


    // Admin
    Route::prefix('admin')->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('admin.index');

        Route::get('/create', [AdminController::class, 'create']);

        Route::post('/store', [AdminController::class, 'store']);

        Route::get('/edit/{id}', [AdminController::class, 'edit']);

        Route::post('/update/{id}', [AdminController::class, 'update']);

        Route::post('/delete', [AdminController::class, 'destroy']);
    });

});


/*
|--------------------------------------------------------------------------
| INCOMING & OUTGOING
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Incoming
    Route::get('/incoming', [IncomingController::class, 'index'])
        ->name('incoming.index');

    Route::post('/incoming/store', [IncomingController::class, 'store'])
        ->name('incoming.store');


    // Outgoing
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

});