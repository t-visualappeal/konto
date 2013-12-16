<?php

View::composer('*', function($view) {
	$view->with('session', Session::all());
});

/**
 * Account
 */
Route::get('/', array(
	'as' => 'home',
	'uses' => 'AccountController@index',
));
Route::get('/account/{id}', array(
	'as' => 'account.show',
	'uses' => 'AccountController@show',
))->where('id', '[0-9]+');

/**
 * Turnover
 */
Route::get('/turnover/{id}', array(
	'as' => 'turnover.show',
	'uses' => 'TurnoverController@show',
))->where('id', '[0-9]+');

/**
 * API
 */
Route::get('/api/account/{id}/history', array(
	'as' => 'api.account.history',
	'uses' => 'ApiController@accountHistory',
))->where('id', '[0-9]+');