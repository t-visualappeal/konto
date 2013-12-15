<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportHibiscusCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'hibiscus:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import data from the hibiscus database';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$accounts = DB::connection('hibiscus')
			->table('konto')
			->get();

		foreach ($accounts as $account) {
			$exist = DB::table('accounts')
				->where('nr', '=', $account->kontonummer)
				->where('bank_code', '=', $account->blz)
				->count();

			if ($exist == 0) {
				$newAccount = Account::create(array(
					'id' => $account->id,
					'nr' => $account->kontonummer,
					'bank_code' => $account->blz,
					'name' => $account->name,
					'type' => $account->bezeichnung,
					'customer' => $account->kundennummer,
					'currency' => $account->waehrung,
					'iban' => $account->iban,
					'bic' => $account->bic,
					'balance' => $account->saldo,
					'balance_date' => $account->saldo_datum,
				));

				if ($newAccount !== null)
					$this->info(sprintf('Account %s (%s) imported.', $newAccount->nr, $newAccount->bank_code));
				else
					$this->error(sprintf('Error while importing account %s (%s)!', $account->kontonummer, $account->blz));
			} else {
				$this->comment(sprintf('Account %s (%s) already exists.', $account->kontonummer, $account->blz));
			}
		}

		$lastDate = DB::table('turnovers')
			->orderBy('date_value', 'desc')
			->take(1)
			->pluck('date_value');

		if ($lastDate === null)
			$lastDate = '0000-00-00';
		else
			$this->comment(sprintf('Import turnovers from %s', $lastDate));

		$turnovers = DB::connection('hibiscus')
			->table('umsatz')
			->where('valuta', '>=', $lastDate)
			->get();

		foreach ($turnovers as $turnover) {
			$exist = DB::table('turnovers')
				->where('date_booking', '=', $turnover->datum)
				->where('account_id', '=', $turnover->konto_id)
				->where('to_accountnr', '=', $turnover->empfaenger_konto)
				->where('to_bank_code', '=', $turnover->empfaenger_blz)
				->where('to_name', '=', $turnover->empfaenger_name)
				->where('value', '=', $turnover->betrag)
				->where('purpose_1', '=', $turnover->zweck)
				->count();

			if ($exist == 0) {
				$newTurnover = Turnover::create(array(
					'account_id' => $turnover->konto_id,
					'to_accountnr' => $turnover->empfaenger_konto,
					'to_bank_code' => $turnover->empfaenger_blz,
					'to_name' => $turnover->empfaenger_name,
					'value' => $turnover->betrag,
					'purpose_1' => $turnover->zweck,
					'purpose_2' => $turnover->zweck2,
					'purpose_3' => $turnover->zweck3,
					'date_booking' => $turnover->datum,
					'date_value' => $turnover->valuta,
					'type' => $turnover->art,
					'comment' => $turnover->kommentar,
					'gvcode' => $turnover->gvcode,
				));

				if ($newTurnover !== null)
					$this->info(sprintf('Turnover %.2f from %s (%s) imported.', $newTurnover->value, $newTurnover->to_name, $newTurnover->date_booking));
				else
					$this->error(sprintf('Error while importing turnover %.2f from %s (%s)!', $turnover->betrag, $turnover->empfaenger_name, $turnover->datum));
			} else {
				$this->comment(sprintf('Turnover %.2f from %s (%s) already exists.', $turnover->betrag, $turnover->empfaenger_name, $turnover->datum));
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
