<?php

class ApiController extends BaseController
{
	/**
	 * Get the data for the account history
	 *
	 * @param integer $id Account ID
	 *
	 * @return string
	 */
	public function accountHistory($id)
	{
		$account = Account::findOrFail($id);

		$raw = DB::table('turnovers')
			->select(array(
				DB::raw('UNIX_TIMESTAMP(date_booking) * 1000 as time'),
				DB::raw('SUM(value) as sum')
			))
			->where('account_id', '=', $account->id)
			->groupBy(DB::raw('YEAR(date_booking), MONTH(date_booking) ASC'))
			->get();

		$inoutcome = array();
		foreach ($raw as $date) {
			$inoutcome[] = array(intval($date->time), floatval($date->sum));
		}

		$balance = array();
		$raw = array_reverse($raw);
		$currentBalance = floatval($account->balance);
		foreach ($raw as $date) {
			$balance[] = array(intval($date->time), floatval($currentBalance));
			$currentBalance -= floatval($date->sum);
		}
		$balance = array_reverse($balance);

		return array(
			array(
				'name' => Lang::get('account.view.history-chart.headline-inoutcome'),
				'data' => $inoutcome,
			),
			array(
				'name' => Lang::get('account.view.history-chart.headline-balance'),
				'data' => $balance,
			),
		);
	}
}