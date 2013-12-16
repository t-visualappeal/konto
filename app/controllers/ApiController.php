<?php

class ApiController extends BaseController
{
	protected function getIncomeNextMonth($accountId)
	{
		$sums = DB::table('turnovers')
			->select(DB::raw('SUM(value) as sum'))
			->where('account_id', '=', $accountId)
			->where('date_booking', '>=', date('Y-m-d', mktime(0, 0, 0, date('m') - 3, 1, date('Y'))))
			->where('date_booking', '<=', date('Y-m-d', mktime(0, 0, 0, date('m'), -1, date('Y'))))
			->groupBy(DB::raw('YEAR(date_booking) ASC, MONTH(date_booking) ASC'))
			->get();
		$sum = 0;
		foreach ($sums as $sumMonth) {
			$sum += $sumMonth->sum;
		}
		return round($sum / 3);
	}

	protected function getIncomeData($accountId)
	{
		$raw = DB::table('turnovers')
			->select(array(
				DB::raw('UNIX_TIMESTAMP(date_booking) * 1000 as time'),
				DB::raw('SUM(value) as sum')
			))
			->where('account_id', '=', $accountId)
			->groupBy(DB::raw('YEAR(date_booking) ASC, MONTH(date_booking) ASC'))
			->get();

		$inoutcome = array();
		foreach ($raw as $date) {
			$inoutcome[] = array(
				'x' => intval($date->time),
				'y' => floatval($date->sum),
			);
		}

		$inoutcome[] = array(
			'x' => mktime(0, 0, 0, date('m') + 1, 1, date('Y')) * 1000,
			'y' => $this->getIncomeNextMonth($accountId),
			'color' => '#cccccc',
		);

		return $inoutcome;
	}

	protected function getBalanceData($accountId, $accountBalance)
	{
		$raw = DB::table('turnovers')
			->select(array(
				DB::raw('UNIX_TIMESTAMP(date_booking) * 1000 as time'),
				DB::raw('SUM(value) as sum')
			))
			->where('account_id', '=', $accountId)
			->groupBy(DB::raw('YEAR(date_booking) DESC, MONTH(date_booking) DESC'))
			->get();

		$balance = array();
		$currentBalance = floatval($accountBalance);
		foreach ($raw as $date) {
			$balance[] = array(
				'x' => intval($date->time),
				'y' => floatval($currentBalance)
			);
			$currentBalance -= floatval($date->sum);
		}
		$balance = array_reverse($balance);

		$balance[] = array(
			'x' => mktime(0, 0, 0, date('m') + 1, 1, date('Y')) * 1000,
			'y' => $accountBalance += $this->getIncomeNextMonth($accountId),
			'color' => '#cccccc',
			'marker' => array(
				'lineColor' => '#cccccc',
			)
		);

		return $balance;
	}

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

		$inoutcome = $this->getIncomeData($account->id);
		$balance = $this->getBalanceData($account->id, $account->balance);

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