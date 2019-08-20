@extends('layouts.master')

@section('breadcrumb')
    <h2>Clients</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Clients</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">
			
			<div class="row">
				<div class="col-lg-4 mb-4 ">

					<div class="card">
						<div class="card-body client-profile">
							<div class="thumb-info mb-3">

								@if (!empty($user->client->profile_picture))
									<img src="{{ asset('uploads/profile_pic/') }}/{{ $user->client->profile_picture }}" alt="{{ ucfirst($user->name) }}" class="rounded img-fluid" alt="{{ $user->name }}">
								@else
									<img src="{{ asset('uploads/profile_pic/user.png') }}/" alt="{{ ucfirst($user->name) }}" class="rounded img-fluid" alt="{{ $user->name }}">
								@endif
								<div class="thumb-info-title">
									<span class="thumb-info-inner">{{ $user->name }}</span>
									<span class="thumb-info-type">Client</span>
								</div>
							</div>

							<div class="mb-4">
								<table class="table table-responsive-md mb-0 ">
									
									<tbody>
										<tr>
											<th>Name</th>
											<th class="text-right">{{ $user->name }}</th>
										</tr>

										<tr>
											<th>Email</th>
											<th class="text-right">
												<a href="mailto:{{ $user->email }}"> {{ $user->email }}</a>
											</th>
										</tr>

										<tr>
											<th>Phone</th>
											<th class="text-right">
												<a href="tel:{{ $user->email }}">{{ $user->client->phone }}</a>
											</th>
										</tr>
									</tbody>
								</table>
							</div>

							


						</div>
					</div>
				</div>
				<div class="col-lg-8">


					<div class="card-body mt-2">

						<table class="table table-responsive-md mb-0 client-profile-table">
								
							<tbody>
								<tr>
									<th>Name</th>
									<th class="text-right">{{ $user->name }}</th>
								</tr>

								<tr>
									<th>Email</th>
									<th class="text-right">
										<a href="mailto:{{ $user->email }}"> {{ $user->email }}</a>
									</th>
								</tr>

								<tr>
									<th>Phone</th>
									<th class="text-right">
										<a href="tel:{{ $user->email }}">{{ $user->client->phone }}</a>
									</th>
								</tr>

								@if(!empty($user->client->address))
									<tr>
										<th>Address</th>
										<th class="text-right">{{ $user->client->address }}</th>
									</tr>
								@endif

								@if(!empty($user->client->city))
									<tr>
										<th>City</th>
										<th class="text-right">{{ $user->client->city }}</th>
									</tr>
								@endif
								
								@if(!empty($user->client->country))
									<tr>
										<th>Country</th>
										<th class="text-right">{{ $user->userCountry($user->client->country) }} </th>
									</tr>
								@endif

								@if(!empty($user->client->state))
									<tr>
										<th>State</th>
										<th class="text-right">{{ $user->client->state }}</th>
									</tr>
								@endif

								@if(!empty($user->client->post_code))
									<tr>
										<th>Post code</th>
										<th class="text-right">{{ $user->client->post_code }}</th>
									</tr>
								@endif

								@if(!empty($user->client->company_name))
									<tr>
										<th>Company name</th>
										<th class="text-right">{{ $user->client->company_name }}</th>
									</tr>
								@endif

								@if(!empty($user->client->tax_id))
									<tr>
										<th>Tax Id</th>
										<th class="text-right">{{ $user->client->tax_id }}</th>
									</tr>
								@endif
								
							</tbody>
						</table>

					</div>

				</div>
			</div>

			<div class="card mt-4">
				
				<div class="card-body">
					<h3>Orders ({{ $user->orders->count() }} {{ $user->orders->count() > 1 ? 'Orders' : 'Order' }})</h3>

					<table class="table table-responsive-md mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>ORDER ID</th>
								<th>SERVICE</th>
								<th>ORDER DATE</th>
								<th class="text-right">STATUS</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($orders as $key => $order)

								<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $order->order_number }}</td>
									<td>
										{{ $order->quantity }} x {{ $order->orderService->name }} (${{number_format($order->orderService->price, 2) }})
									</td>
									<td>{{ $order->created_at->format('d M y') }}</td>
									<td class="text-right">
										<button type="button" class="btn btn-success btn-sm">{{ $order->order_status }}</button>
									</td>
								</tr>
							@endforeach

							

						</tbody>
					</table>
					
					@if (!empty($orders->links()))
						<div class="text-right float-right mt-4 mb-4">
							{{ $orders->links() }}
						</div>
					@endif
				</div>
			</div>


			<div class="card mt-4">
				
				<div class="card-body">
					<h3>Invoices ({{ $user->clientInvoices->count() }} {{ $user->clientInvoices->count() > 1 ? 'Invoices' : 'Invoice' }})</h3>

					<table class="table table-responsive-md mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>INVOICE NUMBER</th>
								<th>DATE</th>
								<th>TOTAL</th>
								<th class="text-right">STATUS</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($invoices as $key => $invoice)

								<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $invoice->invoice_number }}</td>
									
									<td>{{ $invoice->created_at->format('d M y') }}</td>
									<td>$ {{ $invoice->invoice_total }}</td>
									<td class="text-right">
										<button type="button" class="btn btn-success btn-sm">{{ $invoice->invoice_status }}</button>
									</td>
								</tr>
							@endforeach

							

						</tbody>
					</table>
					
					@if (!empty($invoices->links()))
						<div class="text-right float-right mt-4 mb-4">
							{{ $invoices->links() }}
						</div>
					@endif
				</div>
			</div>
		</div>

	</div>

@endsection

