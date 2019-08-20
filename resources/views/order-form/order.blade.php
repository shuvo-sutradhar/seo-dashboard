<!DOCTYPE html>
<html lang="en">
   <head>
		{{-- Basic --}}
		<meta charset="UTF-8">
		<meta name="keywords" content="" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="">
		<meta name="author" content="">

		{{-- Mobile Metas --}}
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Client Area :: SEO SHAPER</title>
     	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
		{{-- Theme CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
		
		{{-- Skin CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />
		<style type="text/css">
			.navbar.navbar-public {
			    padding-top: 1rem;
			    padding-bottom: 1rem;
			}
			.navbar.navbar-public .navbar-brand {
			    margin: 0;
			    font-weight: 700;
			    color: #6c757d;
			}
			.cardarea{
				background: #fff;
			    border-radius: .25rem;
			    padding: 3rem;
			}
		</style>

   </head>
   <body>

   	<div id="app">
   		
   		<custom-order 
   		:data="{{$formData}}" 
   		@if(Auth::user()) :user="{{ Auth::user() }}" @endif
   		@if(!empty(Auth::user()->client)) :clientinfo="{{ Auth::user()->client }}" @endif></custom-order>
	    <vue-progress-bar></vue-progress-bar>
	    
    </div>


    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/app.js') }}"></script>
   </body>
</html>