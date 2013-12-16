@extends('layouts.master')

@section('title')
	{{{ $turnover->theAccount->nr }}} - #{{ $turnover->id }}
@stop

@section('content')
	<h2 class="ui dividing header">{{{ $turnover->theAccount->nr }}} - {{{ $turnover->to_name }}} {{ sprintf('%.2f', $turnover->value) }} {{ $turnover->theAccount->currencySymbole }}</h2>

	<div class="ui list">
	@if (!empty($turnover->to_accountnr))
			<div class="item">
				<div class="header">{{ trans('turnover.accountnr') }}</div>
				<div class="description">{{{ $turnover->to_accountnr }}}</div>
			</div>
		@endif
		@if (!empty($turnover->to_bank_code))
			<div class="item">
				<div class="header">{{ trans('turnover.bank_code') }}</div>
				<div class="description">{{{ $turnover->to_bank_code }}}</div>
			</div>
		@endif
		@if (!empty($turnover->to_name))
			<div class="item">
				<div class="header">{{ trans('turnover.name') }}</div>
				<div class="description">{{{ $turnover->to_name }}}</div>
			</div>
		@endif
		@if (!empty($turnover->value))
			<div class="item">
				<div class="header">{{ trans('turnover.value') }}</div>
				<div class="description">{{{ $turnover->value }}}</div>
			</div>
		@endif
		@if (!empty($turnover->purpose))
			<div class="item">
				<div class="header">{{ trans('turnover.purpose') }}</div>
				<div class="description">{{ nl2br(htmlspecialchars($turnover->purpose)) }}</div>
			</div>
		@endif
		@if (!empty($turnover->date_booking))
			<div class="item">
				<div class="header">{{ trans('turnover.date_booking') }}</div>
				<div class="description">{{{ $turnover->date_booking->format(Config::get('app.format.date')) }}}</div>
			</div>
		@endif
		@if (!empty($turnover->date_value))
			<div class="item">
				<div class="header">{{ trans('turnover.date_value') }}</div>
				<div class="description">{{{ $turnover->date_value->format(Config::get('app.format.date')) }}}</div>
			</div>
		@endif
		@if (!empty($turnover->type))
			<div class="item">
				<div class="header">{{ trans('turnover.type') }}</div>
				<div class="description">{{{ $turnover->type }}}</div>
			</div>
		@endif
		@if (!empty($turnover->comment))
			<div class="item">
				<div class="header">{{ trans('turnover.comment') }}</div>
				<div class="description">{{{ $turnover->comment }}}</div>
			</div>
		@endif
		@if (!empty($turnover->gvcode))
			<div class="item">
				<div class="header">{{ trans('turnover.gvcode') }}</div>
				<div class="description">{{{ $turnover->gvcode }}} ({{ $turnover->gvcodeDescription }})</div>
			</div>
		@endif
	</div>
@stop