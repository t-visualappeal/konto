<?php

class TurnoverController extends BaseController
{
	public function show($id)
	{
		$turnover = Turnover::with('theAccount')->findOrFail($id);

		return View::make('turnover.show', array(
			'turnover' => $turnover,
		));
	}
}