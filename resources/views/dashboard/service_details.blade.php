@extends('layouts.master')

@section('page-style')

@endsection

@section('breadcrumb')
    <h2>Service Details</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>{{ $service->name }}</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">
			
			@include('includes.alert')
			
			<div class="card card-featured-primary mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-4">
							@if(!empty($service->thumbnail))
								<img src="{{ asset('uploads/service_pic') }}/{{ $service->thumbnail }}" alt="{{ $service->name }}" class="img-fluid">
							@else
								<img src="{{ asset('uploads/service_pic/default.png') }}" alt="{{ $service->name }}" class="img-fluid">
							@endif
						</div>
						<div class="col-lg-8">
							<h3>{{ $service->name }}</h3>
							<p> {{ $service->description }} </p>
							<h4>Price: ${{ $service->price }}</h4>

							@foreach($serviceVariants as $key => $variants) 

								@php
					    			$numItems = count($variants);
					    			$i = 0;
					    		@endphp

					    		@foreach ($variants as $newKey => $variant) 
		
					    			@if ($newKey == 0)
					    				
					    				<span class="variant-name">{{ $key }} : </span>

					    			@endif

									<span class="badge badge badge-primary variant-badge"> {{ $variant->variant_value }}</span>

					    			
					    		@endforeach

					    		<br>
					    	@endforeach
							
							@if($service->deadline == 1)
					    		<h4>Deadline: {{ $service->deadline_number }} {{ $service->deadline_type }}</h4>
					    	@endif
							
							@if($service->requirments == 1)
					    		<h6>N.B. For this service you may need to provide requiremts</h6>
					    	@endif

					    	<form action="{{ route('cart.store') }}" method="post">
								@csrf
								<input type="hidden" name="serviceName" value="{{ $service->slug }}">
								<button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary"><i class="fas fa-shopping-basket"></i> Add to cart</button>
							</form>
						</div>
					</div>
				</div>	
			</div>
			

		</div>

	</div>

@endsection



@section('page-script')

@endsection