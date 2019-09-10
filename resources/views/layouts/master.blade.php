<!DOCTYPE html>
<html class="sidebar-light sidebar-left-big-icons">
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

		{{-- Web Fonts  --}}
		{{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,600,700|Josefin+Sans:400,600,700|Muli:400,400i,600,700|Ubuntu" rel="stylesheet"> --}}


		<link href="https://fonts.googleapis.com/css?family=Kanit:200,300,400,500,600,700,800,900|Roboto:300,400,500,700,900&display=swap" rel="stylesheet">

		{{-- Vendor CSS --}}
		
		<link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.css') }}">

		<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/fontawesome-all.min.css') }}" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

		<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
		{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" /> --}}

		{{-- Specific Page Vendor CSS --}}
		@yield('page-style')
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />

		{{-- Theme CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
		
		{{-- Skin CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />
		
		{{-- Theme Custom CSS --}}
		<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

		{{-- Head Libs --}}
		<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>

	</head>
	<body>
		

		<section class="body" >

			{{-- start: header --}}
			@include('includes.header')
			{{-- end: header --}}

			<div class="inner-wrapper">
				{{-- start: sidebar --}}
				<aside id="sidebar-left" class="sidebar-left">
				
				    <div class="sidebar-header">
				        <div class="sidebar-title">
				            Navigation
				        </div>
				        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>
				
				    <div class="nano">
				        <div class="nano-content">
	            			{{-- left sidebar navigation --}}
	            			@include('includes.left-sidebar')

				        </div>
				        
				    </div>
				
				</aside>
				{{-- end: sidebar --}}

				<section role="main" class="content-body">
					
					{{-- start: page breadcrumb --}}
					@include('includes.breadcrumb')
					{{-- end: page breadcrumb --}}


					@if(session()->get('hasClonedUser'))
					
						<div class="alert alert-primary">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<strong>Well done!</strong> Your are accessing team account from your admin acount. All features amy not be available here!
							<div class="">
								<form action="{{ route('account.back') }}" method="post">

									@csrf
									<button type="submit" class="btn btn-default btn-sm">Back to account</button>
								</form>
							</div>
							
						</div>

					@endif

					{{-- start: page content --}}
					@yield('page-content')
					{{-- end: page content --}}
				</section>
			</div>
			
		</section>


		{{-- Vendor --}}
		<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>

		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
		<script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
		<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('assets/vendor/common/common.js') }}"></script>
		<script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
		<script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
		<script src="{{ asset('assets/vendor/jquery-placeholder/jquery-placeholder.js') }}"></script>
		
		{{-- Specific Page Vendor --}}
		@yield('page-script')
		
		{{-- Theme Base, Components and Settings --}}
		<script src="{{ asset('assets/js/theme.js') }}"></script>
		
		{{-- Theme Custom --}}
		<script src="{{ asset('assets/js/custom.js') }}"></script>
		
		{{-- Theme Initialization Files --}}
		<script src="{{ asset('assets/js/theme.init.js') }}"></script>

		{{-- Examples --}}
		<script src="{{ asset('assets/js/examples/examples.modals.js') }}"></script>
		<script src="{{ asset('assets/js/examples/examples.dashboard.js') }}"></script>
		<script>
			$(document).ready(function(){
			  $('[data-toggle="tooltip"]').tooltip();   
			});
		</script>

	</body>
</html>