<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::middleware(['auth'])->group(
    function () {

        Route::get('/', 'DashboardController@ministry')
            ->name('dashboard.ministry');


        Route::group([
            'prefix' => 'dashboard',
            'as' => 'dashboard.'
        ], function () {
            Route::get('coworker', 'DashboardController@coworker')
                ->name('coworker');
            Route::get('report', 'DashboardController@report')
                ->name('report');
        }
        );

        Route::group([
            'prefix' => 'ministry',
            'as' => 'ministry.'
        ], function () {
            Route::get('proposal', 'MinistryController@proposal')
                ->name('proposal');

            Route::get('proposal/accept/{id}', 'MinistryController@proposalAccept')
                ->name('proposal.accept');

            Route::get('proposal/reject/{id}', 'MinistryController@proposalReject')
                ->name('proposal.reject');
        }
        );

        Route::resource('ministry', MinistryController::class);

        Route::group([
            'prefix' => 'coworker',
            'as' => 'coworker.'
        ], function () {
            Route::get('never', 'CoworkerController@never')
                ->name('never');

            Route::get('link/form', 'CoworkerController@linkForm')
                ->name('link.form');

            Route::post('link', 'CoworkerController@link')
                ->name('link');

            Route::get('list/{id}', 'MinistryController@listForCoworker')
                ->where(['id' => '[0-9]+'])
                ->name('ministry.list');
        }
        );

        Route::resource('coworker', CoworkerController::class);

        Route::group(
        [
            'prefix' => 'congregation',
            'as' => 'congregation.'
        ],
            function () {
            Route::get('list', 'CongregationController@list')
                ->name('list'); //index
    
            Route::get('add/form', 'CongregationController@addForm')
                ->name('add.form'); //create
    
            Route::post('add', 'CongregationController@add')
                ->name('add'); //store
        }
        );

        Route::group(
        [
            'prefix' => 'google',
            'as' => 'google.'
        ],
            function () {
            Route::get('index', 'GoogleAccountController@index')
                ->name('index');
            Route::get('oauth', 'GoogleAccountController@store')
                ->name('store');
            Route::delete('{googleAccount}', 'GoogleAccountController@destroy')
                ->name('destroy');
            Route::post('{googleCalendar}', 'GoogleAccountController@select')
                ->name('select');
        }
        );

        Route::group(
        [
            'prefix' => 'team',
            'as' => 'team.'
        ],
            function () {
            Route::get('list', 'TeamController@list')
                ->name('list'); //index
            Route::get('add/form', 'TeamController@addForm')
                ->name('add.form'); //create
            Route::post('add', 'TeamController@add')
                ->name('add'); //store
        }
        );
    }
);

Auth::routes();
