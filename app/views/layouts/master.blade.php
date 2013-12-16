<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>@yield('title') | Konto</title>

		<link rel="stylesheet" type="text/css" href="{{ asset('css/reset.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('js/vendor/semantic/build/packaged/css/semantic.min.css') }}">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css') }}">

		@yield('head')
	</head>

	<body>
		<header class="ui fixed transparent inverted main menu">
			<a class="item" href="{{ URL::action('AccountController@index') }}">
				<i class="home icon>"></i> Konto
			</a>
		</header>

		<div class="container">
			<div id="flash-messages">
				@if (isset($session['success']))
					<div class="ui green message">
						<i class="close icon"></i>
						{{ $session['success'] }}
					</div>
				@endif

				@if (isset($session['error']))
					<div class="ui red message">
						<i class="close icon"></i>
						{{ $session['error'] }}
					</div>
				@endif

				@if (isset($session['info']))
					<div class="ui blue message">
						<i class="close icon"></i>
						{{ $session['info'] }}
					</div>
				@endif

				@if (isset($session['warning']))
					<div class="ui yellow message">
						<i class="close icon"></i>
						{{ $session['warning'] }}
					</div>
				@endif
			</div>

			<div id="content">
				@yield('content')
			</div>

			<footer>
				<p>&copy; 2013, <a href="http://github.com/t-visualappeal/">Tim Helfensdörfer</a></p>
			</footer>
		</div>

		<script type="text/javascript" src="{{ asset('js/vendor/jquery/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/vendor/semantic/build/packaged/javascript/semantic.min.js') }}"></script>
		@yield('scripts')
		<script type="text/javascript" src="{{ asset('js/main.min.js') }}"></script>
	</body>
</html>