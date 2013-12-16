@extends('layouts.master')

@section('title')
	{{{ $account->name }}} ({{{ $account->nr }}} - {{{ $account->type }}})
@stop

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendor/sortable/css/sortable-theme-light.css') }}">
@stop

@section('content')
	<h2 class="ui dividing header">{{{ $account->name }}} ({{{ $account->nr }}} - {{{ $account->type }}})</h2>

	<div class="ui segment chart">
		<div class="chart-contents" id="account-history-chart" data-url="{{ URL::action('ApiController@accountHistory', array('id' => $account->id)) }}" data-currency="{{ $account->currencySymbole }}"></div>
	</div>

	<table class="ui table sortable-theme-light" data-sortable>
		<thead>
			<tr>
				<th>{{ trans('turnover.name') }}</th>
				<th>{{ trans('turnover.accountnr') }}</th>
				<th>{{ trans('turnover.date_booking') }}</th>
				<th>{{ trans('turnover.type') }}</th>
				<th>{{ trans('turnover.value') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($account->turnovers as $turnover)
				<tr>
					<td>{{{ $turnover->to_name }}}</td>
					<td>{{{ $turnover->to_accountnr }}}</td>
					<td data-value="{{ $turnover->date_booking->format('U') }}">{{ $turnover->date_booking->format(Config::get('app.format.date')) }}</td>
					<td>{{{ $turnover->type }}}</td>
					<td><a href="{{ URL::to('turnover.show', array('id' => $turnover->id)) }}" title="{{{ $turnover->purpose }}}">{{{ $turnover->value }}}</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop

@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/vendor/sortable/js/sortable.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/vendor/highcharts.com/js/highcharts.src.js') }}"></script>
@stop