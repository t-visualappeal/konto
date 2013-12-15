<?php

class Account extends Eloquent
{
	protected $table = 'accounts';

	protected $softDelete = true;

	protected $fillable = array(
		'id',
		'nr',
		'bank_code',
		'name',
		'type',
		'customer',
		'currency',
		'iban',
		'bic',
		'balance',
		'balance_date',
	);

	/**
	 * Returns the HTML entity of the currency.
	 *
	 * @return string
	 */
	public function getCurrencySymboleAttribute()
	{
		switch ($this->currency) {
			case 'EUR':
				return '&euro;';
			default:
				return $this->currency;
		}
	}

	/**
	 * Returns the balance with currency.
	 *
	 * @return string
	 */
	public function getBalanceWithCurrencyAttribute()
	{
		return $this->balance . ' ' . $this->currencySymbole;
	}

	/**
	 * Get the date of the last balance as Carbon object.
	 *
	 * @param string $value
	 *
	 * @return \Carbon\Carbon
	 */
	public function getBalanceDateAttribute($value)
	{
		return new \Carbon\Carbon($value);
	}

	/**
	 * Get the turnovers for this account.
	 *
	 * @return Collection
	 */
	public function turnovers()
	{
		return $this->hasMany('Turnover', 'account_id')
			->orderBy('date_booking', 'desc');
	}
}