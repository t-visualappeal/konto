<?php

class Turnover extends Eloquent
{
	protected $table = 'turnovers';

	protected $recurringScore = false;

	protected $fillable = array(
		'account_id',
		'to_accountnr',
		'to_bank_code',
		'to_name',
		'value',
		'purpose_1',
		'purpose_2',
		'purpose_3',
		'date_booking',
		'date_value',
		'type',
		'comment',
		'gvcode',
	);

	/**
	 * Get the date of the booking as Carbon object.
	 *
	 * @param string $value
	 *
	 * @return \Carbon\Carbon
	 */
	public function getDateBookingAttribute($value)
	{
		return new \Carbon\Carbon($value);
	}

	/**
	 * Get the date of the saved value as Carbon object.
	 *
	 * @param string $value
	 *
	 * @return \Carbon\Carbon
	 */
	public function getDateValueAttribute($value)
	{
		return new \Carbon\Carbon($value);
	}

	/**
	 * Get the purpose of the turnover.
	 *
	 * @return string
	 */
	public function getPurposeAttribute()
	{
		$purpose = '';
		if (!empty($this->purpose_1))
			$purpose .= $this->purpose_1;
		if (!empty($this->purpose_2))
			$purpose .= "\n\n" . $this->purpose_2;
		if (!empty($this->purpose_3))
			$purpose .= "\n\n" . $this->purpose_3;

		return $purpose;
	}

	/**
	 * Get the correct formatted type.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function getTypeAttribute($value)
	{
		return ucwords(strtolower($value));
	}

	/**
	 * Returns the description for the gvcode
	 * @link https://www.stadtsparkasse-bocholt.de/Download/gvc.pdf
	 *
	 * @return string
	 */
	public function getGvcodeDescriptionAttribute()
	{
		$description = '';

		if (!empty($this->gvcode) and strlen($this->gvcode) === 3) {
			$mainCode = substr($this->gvcode, 0, 1);

			if (is_numeric($mainCode)) {
				$description .= Lang::get('gvcode.main.' . $mainCode);

				if (!empty(Lang::get('gvcode.sub.' . $this->gvcode))) {
					$description .= ' - ' . Lang::get('gvcode.sub.' . $this->gvcode);
				}
			}
		}

		return $description;
	}

	/**
	 * Get the account for the turnover
	 *
	 * @return Account
	 */
	public function theAccount()
	{
		return $this->belongsTo('Account', 'account_id');
	}
}