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

		<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/fontawesome-all.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
		
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

			.main-content-right{
			    padding: 15px;
			    background: #fff;
			    border-radius: .25rem;
			    margin-bottom: 2rem;
			}
			.table.last-right tr td:last-child {
			    text-align: right;
			}

			.strong {
			    font-weight: 700;
			}
			.content-right {
			    margin-top: 119px;
			}

			.container-wrap{
				margin-top: 50px;
			}
			.main-content-top h3 {
			    color: #000;
			    font-weight: 600;
			}

			.main-content-top h2 {
			    font-weight: 700;
			    color: #000;
			    margin-top: 10px;
			    margin-bottom: 24px;
			}
			.form-wrap-footer {
			    display: flex;
			    justify-content: space-between;
			    align-items: center;
			}

			.form-wrap-addr {
			    border-top: 1px solid #ddd;
			    margin-top: 10px;
			    margin-bottom: 20px;
			    border-bottom: 1px solid #ddd;
			    padding-top: 20px;
			}

			.preloder_loding {
				background:#fff;
			    height: 100%;
			    left: 0;
			    margin-top: 0;
			    position: fixed;
			    top: 0;
			    width: 100%;
			    z-index: 999999;
			    display: flex;
			    justify-content: center;
			    align-items: center;
			    flex-direction: column;
			}
		</style>

   </head>
   <body>

   	<!-- start preloader -->
   	<div class="preloder_loding" id="preloder_loding">
   		<img src="{{ asset('/uploads/company_logo/') }}/{{ \App\GeneralSetting::where('key', 'app.logo')->firstOrFail()->value }}" alt="{{ \App\GeneralSetting::where('key', 'app.name')->firstOrFail()->value }}" width="180px" />
   		<h2>Thank you for choosing us</h2>
   		<p>We are currently processing your payment.</p>
   		<img src="{{ asset('assets/img/loder.gif') }}" width="100px">
   		<p>If you stay on this page you'll be logged in as the order is done processing.You will also receive an email with your login details.</p>
   	</div>
   	<!-- /. preloader -->

   	<div class="container d-flex justify-content-center align-items-center container-wrap">
   		
        <div class="row">
        	<div class="col-md-12 text-center mb-4">
        		<img src="{{ asset('/uploads/company_logo/') }}/{{ \App\GeneralSetting::where('key', 'app.logo')->firstOrFail()->value }}" alt="{{ \App\GeneralSetting::where('key', 'app.name')->firstOrFail()->value }}" width="180px" />
        	</div>

            <div class="col-md-8">
                <div class="main-content-top">
                	<h3>Order #{{ $invoice->invoice_number }}</h3>
                	<h2>Thank you, {{ Auth::user()->name }}</h2>
                </div>
                <div class="main-content-left cardarea">
                    
                    <div class="form-wrap">
	                    <div class="form-wrap-desc">
	                        <p>We've accepted your order, and we're getting it ready. A confirmatin email has been sent to <b>{{ Auth::user()->email }}</b></p>
	                        <p>Got to the <a href="{{ url('/') }}">client panel</a> to check the status of this order and receive updates.</p>
	                    </div>
	                    <div class="form-wrap-addr">
	                        <div class="row">
	                        	<div class="col-md-6">
	                        		<div class="form-wrap-addr-left">
		                        		<div class="form-wrap-addr-single">
		                        			<b>Billing address</b>
		                        			<p>{{ Auth::user()->name }}</p>
		                        		</div>
	                        		</div>
	                        	</div>
	                        	<div class="col-md-6">
	                        		<div class="form-wrap-addr-right">
		                        		<div class="form-wrap-addr-single">
		                        			<b>IP address</b>
		                        			<p>118.179.96.11</p>
		                        		</div>
		                        		<div class="form-wrap-addr-single">
		                        			<b>Order date</b>
		                        			<p>{{ $invoice->created_at->format('d M Y') }}</p>
		                        		</div>
		                        		<div class="form-wrap-addr-single">
		                        			<b>Payment Method</b>
		                        			<p>{{$invoice->payment_getway}} - ${{$invoice->invoice_total}}</p>
		                        		</div>
	                        		</div>
	                        	</div>
	                        </div>
	                    </div>

	                    <div class="form-wrap-footer">
	                    	<div class="from-wrap-footer-left">
	                    		<i class="fas fa-info-circle"></i> Need help <a href="#">Contact us</a>
	                    	</div>
	                    	<div class="from-wrap-footer-right">
	                    		<a href="{{ url('/') }}" class="btn btn-success">Continue to client panel</a>
	                    	</div>
	                    </div>
                    </div><!-- email -->
                </div>
            </div><!-- /. main-content-left -->

            <div class="col-md-4">
                <div class="content-right">
                    <div class="main-content-right">
                        <table class="table last-right">
                            <thead>
                                <tr>
                                    <th colspan="3">Order summary</th>
                                </tr>
                            </thead>
                            <tbody>
								@php
									$total = 0;
								@endphp

								@foreach($invoice->invoiceItems as $key => $invoiceItems) 
								@php
									$total += $invoiceItems->invoiceService->price * $invoiceItems->quantity;
								@endphp
                                <tr>
                                    <td class="quantity">{{ $invoiceItems->quantity }}×</td>
                                    <td>{{ $invoiceItems->invoiceService->name }}</td>
                                    <td>{{ $invoiceItems->invoiceService->price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table last-right totals mb-4">
                            <tbody>
                                <tr class="strong">
                                    <td>Total</td>
                                    <td>USD ${{$total}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /. main-content-left -->
        </div>
	    
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
    	    /*-- Preloader --*/
		    $(window).on('load', function() {
		        $('#preloder_loding').delay(3500).fadeOut('slow');
		    });
		    
    </script>
   </body>
</html>