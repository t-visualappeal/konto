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
			<div id="content">
				@yield('content')
			</div>

			<footer>
				<p>&copy; 2013, <a href="http://github.com/t-visualappeal/">Tim Helfensdörfer</a></p>
			</footer>
		</div>

		<script type="text/javascript" src="{{ asset('js/vendor/jquery/jquery.min.js') }}"></script>
		@yield('scripts')
		<script type="text/javascript" src="{{ asset('js/main.min.js') }}"></script>
	</body>
</html>