<!doctype html>
<html class="fixed">
	<head>
		{{-- Basic --}}
		<meta charset="UTF-8">
		<meta name="keywords" content="" />
		<meta name="description" content="P">
		<meta name="author" content="">

		{{-- Mobile Metas --}}
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<title>Client Area :: SEO SHAPER</title>

		{{-- Web Fonts  --}}
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,600,700|Josefin+Sans:400,600,700|Muli:400,400i,600,700|Ubuntu" rel="stylesheet">

		{{-- Vendor CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.css') }}">

		<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/fontawesome-all.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />

		{{-- Theme CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

		{{-- Skin CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />

		{{-- Theme Custom CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

		{{-- Head Libs --}}
		<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>

		@yield('auth-page-style')

	</head>
	<body>

		{{-- start: page --}}
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo float-left">
					<img src="{{ asset('assets/img/logo.png') }}" height="54" alt="" />
				</a>
				
				@yield('auth-page-content')
				
				<p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2019. All Rights Reserved.</p>
			</div>
		</section>
		{{-- end: page --}}

		{{-- Vendor --}}
		<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
		<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
		<script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
		<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('assets/vendor/common/common.js') }}"></script>
		<script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
		<script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
		<script src="{{ asset('assets/vendor/jquery-placeholder/jquery-placeholder.js') }}"></script>
		
		{{-- Theme Base, Components and Settings --}}
		<script src="{{ asset('assets/js/theme.js') }}"></script>
		
		{{-- Theme Custom --}}
		<script src="{{ asset('assets/js/custom.js') }}"></script>
		
		{{-- Theme Initialization Files --}}
		<script src="{{ asset('assets/js/theme.init.js') }}"></script>

		@yield('auth-page-script')

	</body>
</html>