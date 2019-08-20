@extends('layouts.master')

@section('page-style')

@endsection

@section('breadcrumb')
    <h2>Checout Confirmation</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Checout Confirmation</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">
			
			@include('includes.alert')
			
			
			<div class="card  card-featured-primary mb-4">
				<div class="card-body">
					
					<h2>Checkout Confirm</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At error veniam, reprehenderit eligendi odio neque, maxime laboriosam alias ipsam quae voluptatum, cum quis corrupti, laudantium facere? Voluptatibus, iure voluptates asperiores?</p>

				</div>

			</div>

		</div>

	</div>

@endsection



@section('page-script')
<script src="{{ asset('assets/vendor/fuelux/js/spinner.js') }}"></script>
@endsection