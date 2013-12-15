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

	public function view($id)
	{
		$account = Account::with('turnovers')->findOrFail($id);

		return View::make('account.view', array(
			'account' => $account,
		));
	}
}