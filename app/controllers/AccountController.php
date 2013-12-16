<?php

class AccountController extends BaseController
{
	/**
	 * Display the account overview page.
	 *
	 * @return string
	 */
	public function index()
	{
		return View::make('account.index', array(
			'accounts' => Account::all(),
		));
	}

	public function show($id)
	{
		$account = Account::with('turnovers')->findOrFail($id);

		return View::make('account.show', array(
			'account' => $account,
		));
	}
}