<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/ministry','MinistryController@list');




Route::middleware(['auth'])->group(
    function () {

        Route::get('/', 'MinistryController@dashboard')
            ->name('ministry.dashboard');

        Route::group([
            'prefix' => 'ministry',
            'as' => 'ministry.'
        ], function () {
            Route::get('list', 'MinistryController@list')
            ->name('list');

            Route::get('add', 'MinistryController@add')
            ->name('add');
        });

        Route::group([
            'prefix' => 'coworker',
            'as' => 'coworker.'
        ], function () {
            Route::get('list', 'CoworkerController@list')
                ->name('list');

            Route::get('never', 'CoworkerController@never')
                ->name('never');

            Route::get('add', 'CoworkerController@add')
                ->name('add');
        });

        Route::group([
            'prefix' => 'report',
            'as' => 'report.'
        ], function () {
            Route::get('list', 'ReportController@list')
            ->name('list');
        });



    }
);

Auth::routes();


// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')
//     ->name('home');
