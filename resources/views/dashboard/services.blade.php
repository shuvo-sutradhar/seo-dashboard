@extends('layouts.master')

@section('page-style')

@endsection

@section('breadcrumb')
    <h2>Services</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Services</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-12 col-xl-12">
			
			@include('includes.alert')
			
			<div class="row">

				@foreach ($services as $key => $service)

					<div class="col-lg-6">
						<div class="card card-featured-top card-featured-primary mb-4">
							<div class="card-body">
								<div class="widget-summary">
									<div class="widget-summary-col widget-summary-col-icon">
										<div class="summary-icon service-page-icon">
											<a href="{{ route('services.details', $service->slug) }}">
												
												@if (!empty($service->thumbnail))

													<img src="{{ asset('uploads/service_pic') }}/{{ $service->thumbnail }}">
												
												@else
													
													<img src="{{ asset('uploads/service_pic/default.png') }}">
												@endif

											</a>
										</div>
									</div>
									<div class="widget-summary-col">
										<div class="summary">
											<h3>
												<a href="{{ route('services.details', $service->slug) }}" >{{ $service->name }}</a>
											</h3>
											<div class="info">
												<p> {{ str_limit($service->description, 150) }}</p>
												
											</div>

											<h3>${{ $service->price }}</h3>
										</div>
										<div class="summary-footer">
											
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

				@endforeach
				
				
			</div>

			<div class="text-right float-right">
				{{ $services->links() }}
			</div>
			

		</div>

	</div>

@endsection



@section('page-script')

@endsection