<?php

class TurnoverController extends BaseController
{
	public function view($id)
	{
		$turnover = Turnover::with('theAccount')->findOrFail($id);

		return View::make('turnover.view', array(
			'turnover' => $turnover,
		));
	}
}