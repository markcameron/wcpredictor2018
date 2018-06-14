<?php

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

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {

  Route::resource('/', 'Admin\DashboardController', [
    'only' => ['index']
  ]);

  Route::get('match-can-predict-false', 'Admin\DashboardController@matchesCanPredictFalse')->name('dashboard.matches_can_predict_false');
  Route::get('match-can-predict-true', 'Admin\DashboardController@matchesCanPredictTrue')->name('dashboard.matches_can_predict_true');

  Route::get('user-can-predict-false', 'Admin\DashboardController@usersCanPredictFalse')->name('dashboard.users_can_predict_false');
  Route::get('user-can-predict-true', 'Admin\DashboardController@usersCanPredictTrue')->name('dashboard.users_can_predict_true');

  Route::resource('matches', 'Admin\MatchesController', [
    'only' => ['index', 'edit', 'update']
  ]);

  Route::get('matches/{match}/allow-prediction', 'Admin\MatchesController@allowPrediction')->name('matches.allow_prediction');
  Route::get('matches/{match}/deny-prediction', 'Admin\MatchesController@denyPrediction')->name('matches.deny_prediction');

  Route::resource('goals', 'Admin\GoalsController', [
    'only' => ['create', 'store', 'edit', 'update']
  ]);

  Route::resource('users', 'Admin\UsersController', [
    'only' => ['index']
  ]);

  Route::get('users/{user}/allow-prediction', 'Admin\UsersController@allowPrediction')->name('users.allow_prediction');
  Route::get('users/{user}/deny-prediction', 'Admin\UsersController@denyPrediction')->name('users.deny_prediction');

});
