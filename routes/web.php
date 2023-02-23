<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return Inertia::render('Bienvenido');
})->name('default');


Route::inertia('convenios', 'Agreements/Search')->name('agreements.search');


/* >>>>> Facultades <<<<<< */
Route::inertia('faculties', 'Faculties/Index')->middleware('auth')->name('faculties.view');
Route::resource('api/faculties', \App\Http\Controllers\FacultyController::class, [
    'as' => 'api'
])->middleware('auth');

/* >>>>> Convenios <<<<<< */
Route::inertia('agreements', 'Agreements/Index')->middleware('auth')->name('agreements.view');
Route::resource('api/agreements', \App\Http\Controllers\AgreementController::class, [
    'as' => 'api'
])->middleware('auth');
Route::get('api/agreements', [\App\Http\Controllers\AgreementController::class, 'index'])->name('api.agreements.index');

/* >>>>> Programas <<<<<< */
Route::inertia('programs', 'Programs/Index')->middleware('auth')->name('programs.view');
Route::resource('api/programs', \App\Http\Controllers\ProgramController::class, [
    'as' => 'api'
])->middleware('auth');
Route::get('api/programs', [\App\Http\Controllers\ProgramController::class, 'index'])->name('api.programs.index');


/* >>>>> Agreement types <<<<<< */
Route::inertia('agreementTypes', 'AgreementTypes/Index')->middleware('auth')->name('agreementTypes.view');
Route::resource('api/agreementTypes', \App\Http\Controllers\AgreementTypeController::class, [
    'as' => 'api'
])->middleware('auth');
Route::get('api/agreementTypes', [\App\Http\Controllers\AgreementTypeController::class, 'index'])->name('api.agreementTypes.index');

/* >>>>> Countries  <<<<<< */
Route::inertia('countries', 'Countries/Index')->middleware('auth')->name('countries.view');
Route::resource('api/countries', \App\Http\Controllers\CountryController::class, [
    'as' => 'api'
])->middleware('auth');
Route::get('api/countries', [\App\Http\Controllers\CountryController::class, 'index'])->name('api.countries.index');

/* >>>>> universities types <<<<<< */
Route::inertia('universities', 'Universities/Index')->middleware('auth')->name('universities.view');
Route::resource('api/universities', \App\Http\Controllers\UniversityController::class, [
    'as' => 'api'
])->middleware('auth');
Route::get('api/universities', [\App\Http\Controllers\UniversityController::class, 'index'])->name('api.universities.index');
Route::get('universities/{university}/campuses', [\App\Http\Controllers\CampusController::class, 'indexView'])->name('universities.campus.view');
Route::get('api/universities/{university}/campuses', [\App\Http\Controllers\UniversityController::class, 'getCampuses'])->name('api.universities.campuses');

/* >>>>> campus  <<<<<< */
Route::inertia('campuses', 'Campus/Index')->middleware('auth')->name('campus.view');
Route::resource('api/campuses', \App\Http\Controllers\CampusController::class, [
    'as' => 'api'
])->middleware('auth');

/* >>>>> statuses  <<<<<< */
Route::get('api/statuses', [\App\Http\Controllers\StatusesController::class, 'index'])->name('api.statuses.index');

/* >>>>>Roles routes <<<<<< */
//Get all roles
Route::get('/roles', [\App\Http\Controllers\Roles\RoleController::class, 'index'])->middleware(['auth', 'isAdmin'])->name('roles.index');
//Roles api
Route::resource('api/roles', \App\Http\Controllers\Roles\ApiRoleController::class, [
    'as' => 'api'
])->middleware('auth');

/* >>>>>User routes <<<<<< */

//Get all users
Route::get('/users', [\App\Http\Controllers\Users\UserController::class, 'index'])->middleware(['auth', 'isAdmin'])->name('users.index');
//users api
Route::resource('api/users', \App\Http\Controllers\Users\ApiUserController::class, [
    'as' => 'api'
])->middleware('auth');
//Update user role
Route::patch('/api/users/{user}/roles', [\App\Http\Controllers\Users\ApiUserController::class, 'updateUserRole'])->middleware('auth')->name('api.users.roles.update');
Route::get('/api/users/{user}/roles', [\App\Http\Controllers\Users\ApiUserController::class, 'getUserRole'])->middleware('auth')->name('api.users.roles.show');

/* >>>>>Roles routes <<<<<< */
Route::get('landing', function () {
    return Inertia::render('SuperTest');
})->name('landing');

//Auth routes
Route::get('/', [\App\Http\Controllers\AuthController::class, 'handleRoleRedirect'])->middleware(['auth'])->name('redirect');
Route::get('login', [\App\Http\Controllers\AuthController::class, 'redirectGoogleLogin'])->name('login');
Route::get('/google/callback', [\App\Http\Controllers\AuthController::class, 'handleGoogleCallback']);

