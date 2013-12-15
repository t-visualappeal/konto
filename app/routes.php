<?php

/**
 * Account
 */
Route::get('/', 'AccountController@index');
Route::get('/account/{id}', 'AccountController@view')
	->where('id', '[0-9]+');

/**
 * Turnover
 */
Route::get('/turnover/{id}', 'TurnoverController@view')
	->where('id', '[0-9]+');

/**
 * API
 */
Route::get('/api/account/{id}/history', 'ApiController@accountHistory')
	->where('id', '[0-9]+');