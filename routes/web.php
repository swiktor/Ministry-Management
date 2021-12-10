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
        });

        Route::group([
            'prefix' => 'ministry',
            'as' => 'ministry.'
        ], function () {
            Route::get('list', 'MinistryController@list')
                ->name('list');

            Route::get('add/form', 'MinistryController@addForm')
                ->name('form.add');

            Route::post('add', 'MinistryController@add')
                ->name('add');

            Route::get('edit/form/{id}', 'MinistryController@editForm')
                ->name('form.edit');

            Route::post('edit', 'MinistryController@edit')
                ->name('edit');

            Route::get('delete/{id}', 'MinistryController@delete')
                ->name('delete');
        });

        Route::group([
            'prefix' => 'coworker',
            'as' => 'coworker.'
        ], function () {
            Route::get('list', 'CoworkerController@list')
                ->name('list');

            Route::get('never', 'CoworkerController@never')
                ->name('never');

            Route::get('add/form', 'CoworkerController@addForm')
                ->name('add.form');

            Route::post('add', 'CoworkerController@add')
                ->name('add');

            Route::get('link/form', 'CoworkerController@linkForm')
                ->name('link.form');

            Route::post('link', 'CoworkerController@link')
                ->name('link');

            Route::get('list/{id}', 'MinistryController@listForCoworker')
                ->where(['id' => '[0-9]+'])
                ->name('ministry.list');
        });

        Route::group([
            'prefix' => 'report',
            'as' => 'report.'
        ], function () {
            Route::get('edit/form/{id}', 'ReportController@editForm')
                ->name('edit.form');

            Route::post('edit', 'ReportController@edit')
                ->name('edit');
        });

        Route::group(
            [
                'prefix' => 'congregation',
                'as' => 'congregation.'
            ],
            function () {
                Route::get('list', 'CongregationController@list')
                    ->name('list');

                Route::get('add/form', 'CongregationController@addForm')
                    ->name('add.form');

                Route::post('add', 'CongregationController@add')
                    ->name('add');
            }
        );

        Route::group(
            [
                'prefix' => 'user',
                'as' => 'user.'
            ],
            function () {
                Route::get('calendar_id', 'UserController@get_google_calendar_id')
                    ->name('calendar_id');
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
    }
);

Auth::routes();
