@extends('layouts.master')


@section('breadcrumb')
    <h2>Invoices</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Invoice </span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">
			
			<div class="card">
				<div class="card-body">
					<div class="invoice">
						<header class="clearfix">
							<div class="row">
								<div class="col-sm-6 mt-3">
									<h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">INVOICE</h2>
									<h4 class="h4 m-0 text-dark font-weight-bold">#{{ $invoice->invoice_number }}</h4>
								</div>
								<div class="col-sm-6 text-right mt-3 mb-3">
									<address class="ib">
										{{ \App\GeneralSetting::where('key', 'app.name')->firstOrFail()->value }}
										<br/>
										{{ \App\GeneralSetting::where('key', 'app.address')->firstOrFail()->value }}
									</address><br/>
									<div class="ib invoice-image">
										<img src="{{ asset('/uploads/company_logo/') }}/{{ \App\GeneralSetting::where('key', 'app.logo')->firstOrFail()->value }}" alt="{{ \App\GeneralSetting::where('key', 'app.name')->firstOrFail()->value }}"  />
									</div>
								</div>
							</div>
						</header>
						<div class="bill-info">
							<div class="row">
								<div class="col-md-6">
									<div class="bill-to">
										<p class="h5 mb-1 text-dark font-weight-semibold">To:</p>
										<address>
											John 
											<br/>
											121 King Street, Melbourne, Australia
											<br/>
											Phone: +61 3 8376 6284
											<br/>
											info@envato.com
										</address>
									</div>
								</div>
								<div class="col-md-6">
									<div class="bill-data text-right">
										<p class="mb-0">
											<span class="text-dark">Invoice Date:</span>
											<span class="value">05/20/2017</span>
										</p>
										<p class="mb-0">
											<span class="text-dark">Due Date:</span>
											<span class="value">06/20/2017</span>
										</p>
									</div>
								</div>
							</div>
						</div>
					
						<table class="table table-responsive-md invoice-items">
							<thead>
								<tr class="text-dark">
									<th id="cell-id"     class="font-weight-semibold">#</th>
									<th id="cell-item"   class="font-weight-semibold">Item</th>
									<th id="cell-desc"   class="font-weight-semibold">Description</th>
									<th id="cell-price"  class="text-center font-weight-semibold">Price</th>
									<th id="cell-qty"    class="text-center font-weight-semibold">Quantity</th>
									<th id="cell-total"  class="text-center font-weight-semibold">Total</th>
								</tr>
							</thead>
							<tbody>

								@php
									$subTotal = 0;
								@endphp

								@foreach($invoice->invoiceItems as $key => $invoiceItems) 
									@php
										$subTotal += $invoiceItems->invoiceService->price * $invoiceItems->quantity;
									@endphp
									<tr>
										<td>123456</td>
										<td class="font-weight-semibold text-dark">
											<a href="{{ route('service.edit', $invoiceItems->invoiceService->slug) }}">{{ $invoiceItems->invoiceService->name }} </a></td>
										<td>{{ str_limit($invoiceItems->invoiceService->description, 40) }}</td>
										<td class="text-center">${{ $invoiceItems->invoiceService->price }}</td>
										<td class="text-center">{{ $invoiceItems->quantity }}</td>
										<td class="text-center">${{ $invoiceItems->invoiceService->price * $invoiceItems->quantity }}</td>
									</tr>
								@endforeach

							</tbody>
						</table>
					
						<div class="invoice-summary">
							<div class="row justify-content-end">
								<div class="col-sm-4">
									<table class="table h6 text-dark">
										<tbody>
											<tr class="b-top-0">
												<td colspan="2">Subtotal</td>
												<td class="text-left">${{ number_format($subTotal, 2) }}</td>
											</tr>
											<tr>
												<td colspan="2">Tax</td>
												<td class="text-left">${{ number_format($invoice->invoice_vat, 2) }}</td>
											</tr>
											<tr>
												<td colspan="2">Grand Total</td>
												<td class="text-left">${{ number_format($invoice->invoice_total, 2) }}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="text-right mr-4">
						
						<a href="pages-invoice-print.html" target="_blank" class="btn btn-primary ml-3"><i class="fas fa-print"></i> Print</a>
					</div>
				</div>
			</div>
			
		</div>

	</div>

@endsection



