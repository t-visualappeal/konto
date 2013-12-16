@extends('layouts.master')

@section('title')
	{{ trans('account.index.title') }}
@stop

@section('content')
	<h2 class="ui dividing header">{{ trans('account.index.headline') }}</h2>

	<div id="account-list" class="ui divided list">
		@foreach ($accounts as $account)
			<div class="item">
				<div class="ui right floated">
					<div class="ui label <?php if ($account->balance >= 0): ?>green<?php else: ?>red<?php endif; ?>">{{ $account->balanceWithCurrency }}</div>
				</div>
				<div class="content">
					<a class="header" href="{{ URL::route('account.show', array('id' >= $account->id)) }}">{{{ $account->name }}} ({{{ $account->nr }}} - {{{ $account->type }}})</a>
					<div class="description">{{ trans('account.index.last_update') }}: {{ $account->balance_date->format(Config::get('app.format.datetime')) }}</div>
				</div>
			</div>
		@endforeach
	</div>
@stop