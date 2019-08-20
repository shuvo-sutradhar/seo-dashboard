@extends('layouts.master')

@section('page-style')

@endsection

@section('breadcrumb')
    <h2>Cart page</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Cart</span></li>
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
					@if (Cart::count() > 0)
						<h3 class="font-weight-semibold mt-3">Services in cart</h3>
						<a class="add-service" href="{{ route('services') }}">Add more service</a>
						<table class="table table-responsive-md mb-0">				
							<tbody>
								@foreach(Cart::content() as $key => $item)
									<tr>
										<td>
											<div class="row">
												<div class="col-lg-2 col-xl-2 ">
													<figure class="image rounded img-60">

														@if(!empty($item->model->thumbnail))
															<img src="{{ asset('uploads/service_pic/') }}/{{ $item->model->thumbnail }}" alt="{{ $item->name }}" class="">
														@else
															<img src="{{ asset('uploads/service_pic/default.png') }}" alt="{{ $item->name }}" class="rounded-circle">
														@endif
													</figure>
												</div>

												<div class="col-lg-10 col-xl-10">
													<div class="user-info">
														<a href="#">{{ $item->name }}</a>
														<p>${{ $item->price }}</p>
													</div>
												</div>
											</div>
											
										</td>
										<td class="user-role text-left">
											<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 10 }'>
												<div class="input-group" style="width:150px;">
													
													<div class="input-group-append">
														<button type="button" class="btn btn-default spinner-down">
															<i class="fas fa-minus"></i>
														</button>
														<input type="text" class="spinner-input form-control" maxlength="3" value="{{ $item->qty }}" >
														
														<button type="button" class="btn btn-default spinner-up btn-sm">
															<i class="fas fa-plus"></i>
														</button>
													</div>
												</div>
											</div>
										</td>
										<td class="user-role text-left">
											<a href=""> ${{  $item->qty * $item->price }} </a>
										</td>
										<td class="actions">
											
											<div class="btn-group flex-wrap">
												<a href="{{ route('cart.remove', $item->rowId) }}" class="mb-1 mt-1 mr-1 btn btn-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove  service from cart"><i class="fa fa-times" ></i></a>
											</div>
										</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="2" class="text-right"><strong>Total</strong></td>
									<td> <strong>${{ Cart::total() }}</strong></td>
									<td></td>
								</tr>
							</tbody>
						</table>

					@else
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-info">
									<i class="fas fa-shopping-basket"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4>You don't have any service on your cart.</h4>
									<p>Please add some services on your cart to discover the checkout feature. </p>
								</div>
								<div class="summary-footer">
									<a href="{{ route('services') }}" class="text-primary text-uppercase">Add Services</a>
								</div>
							</div>
						</div>
					@endif


				</div>
				@if (Cart::count() > 0)
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-6">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One" >Have a coupon?</a>
												
								<div id="collapse1One" class="collapse">
									<div class="input-group mb-3">
										<input type="text" class="form-control" placeholder="Enter coupon code" name="couponCode" value="{{ old('couponCode') }}">
										<span class="input-group-append">
											<button class="btn btn-success" type="submit">Apply Coupon</button>
										</span>
									</div>
								</div>
							</div>

							<div class="col-lg-6 text-right">
								
								<a class="btn btn-primary" href="{{ route('checkout') }}">Continue to checkout</a>
							</div>
						</div>
					</div>
				@endif
			</div>

		</div>

	</div>

@endsection



@section('page-script')
<script src="{{ asset('assets/vendor/fuelux/js/spinner.js') }}"></script>
@endsection