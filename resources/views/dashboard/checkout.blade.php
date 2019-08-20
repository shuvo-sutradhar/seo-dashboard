@extends('layouts.master')

@section('page-style')
	<style type="text/css">
		.StripeElement {
		  box-sizing: border-box;
		  border: 1px solid transparent;
		  border-radius: 4px;
		  background-color: white;
		  box-shadow: 0 1px 3px 0 #e6ebf1;
		  -webkit-transition: box-shadow 150ms ease;
		  transition: box-shadow 150ms ease;
		  width: 100%;
		  margin-bottom: 1.3rem;
		  padding: 1rem;
		  border-radius: 5px;
		  outline: none;
		  font-size: 1.1rem;
		  line-height: 1.1rem;
		  background: #FFF;
		  color: #49425a;
		  transition: all 300ms ease;
		  border: 1px solid#49425a;
		  font-family: "Ubuntu", sans-serif !important;
		}



		.StripeElement--focus {
		  box-shadow: 0 1px 3px 0 #cfd7df;
		}

		.StripeElement--invalid {
		  border-color: #fa755a;
		}

		.StripeElement--webkit-autofill {
		  background-color: #fefde5 !important;
		}

		#card-errors{
			color: red;
			margin-bottom:20px;
		}
	</style>
@endsection

@section('breadcrumb')
    <h2>Checkout page</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Checkout</span></li>
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

					  	<div class="payment-card-body">
				    		<div class="payment">
				      			<div class="row">
				      				<div class="col-lg-6">
				      					<div class="creditcard hidden-xs">
							        		<div class="thecard">
						          				<div class="top-card">
						            				<div class="circle"></div>
						            				<div class="card-title">The Card</div>
						          				</div>
						          				<div class="card-info">
										            <div class="card-number">1234 5678 9012 3456</div>
										            <div class="exp-date">01 / 2018</div>
										            <div class="card-holder">
										              John Doe
										            </div>
						          				</div>
						        			</div>
							      		</div>
				    					

				      				</div>
				      				<div class="col-lg-6">
				      					
							      		<div class="form">
									        <form action="{{ route('checkout.store') }}" method="post" id="payment-form">
									        	@csrf

									          	<label for="cardHolderName">Card Holder Name</label>
									          	<input type="text" id="cardHolderName" placeholder="John Doe" name="cardHolderName" required>

									          	<label for="cardHolderEmail">Card Holder Email</label>
									          	<input type="email" id="cardHolderEmail" placeholder="john@example.com" name="cardHolderEmail" required>

									          	<div class="form-row">
												    <label for="card-element">
												      Credit or debit card
												    </label>
												    <div id="card-element">
												      <!-- A Stripe Element will be inserted here. -->
												    </div>

												    <!-- Used to display form errors. -->
												    <div id="card-errors" role="alert"></div><br/>
												 </div>
									          	<button type="submit" id="proceed">Proceed</button>
									        </form>
							      		</div>
				      				</div>
				      			</div>
					      		
				    		</div>

						</div>
					</div>	
				</div>
			</div>
			

		</div>

	</div>

@endsection



@section('page-script')
	<script src="https://js.stripe.com/v3/"></script>
	<script>
		// Create a Stripe client.
		var stripe = Stripe('pk_test_B3Pu9cKGxPiSOyrxNaXYJArB');

		// Create an instance of Elements.
		var elements = stripe.elements({
			fonts: [
			    {
			      cssSrc: 'https://fonts.googleapis.com/css?family=Crimson+Text:400,600,700|Josefin+Sans:400,600,700|Muli:400,400i,600,700|Ubuntu'
			    }
			]
		});

		// Custom styling can be passed to options when creating an Element.
		// (Note that this demo uses a wider set of styles than the guide below.)
		var style = {
		  	base: {
			    color: '#32325d',
			    fontFamily: '"Ubuntu", sans-serif',
			    fontSmoothing: 'antialiased',
			    fontSize: '16px',
			    '::placeholder': {
			      color: '#aab7c4'
			    }
		  	},
			invalid: {
			    color: '#fa755a',
			    iconColor: '#fa755a'
			}
		};

		// Create an instance of the card Element.
		var card = elements.create('card', {
			style: style,
			hidePostalCode:true
		});

		// Add an instance of the card Element into the `card-element` <div>.
		card.mount('#card-element');

		// Handle real-time validation errors from the card Element.
		card.addEventListener('change', function(event) {
		  	var displayError = document.getElementById('card-errors');
		  	if (event.error) 
		  	{
		    	displayError.textContent = event.error.message;
		  	} 
		  	else
		  	{
		    	displayError.textContent = '';
		  	}
		});

		// Handle form submission.
		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
		  	
		  	event.preventDefault();

		  	// Disable the submit button to prevent repeated click
		  	document.getElementById('proceed').disabled = true;

		  	// Billing info based on client profile info
		  	@if (!empty(auth()->user()->client->address) && !empty(auth()->user()->client->city) && !empty(auth()->user()->client->state) && !empty(auth()->user()->client->post_code))
			  	var options = {

			  		name: document.getElementById("cardHolderName").value,
			  		address_line1: '{{ auth()->user()->client->address }}',
			  		address_city: '{{ auth()->user()->client->city }}',
			  		address_state: '{{ auth()->user()->client->state }}',
			  		address_zip: '{{ auth()->user()->client->post_code }}'

			  	}

		  	@else
			  	var options = {
			  		name: document.getElementById("cardHolderName").value

			  	}

		  	@endif


		  	stripe.createToken(card, options).then(function(result) {
			    if (result.error) 
			    {
			      // Inform the user if there was an error.
			      var errorElement = document.getElementById('card-errors');
			      errorElement.textContent = result.error.message;

			      // Enable the submit button
			      document.getElementById('proceed').disabled = false;
			    } 
			    else 
			    {
			      // Send the token to your server.
			      stripeTokenHandler(result.token);
			    }
		  	});
		});

		// Submit the form with the token ID.
		function stripeTokenHandler(token) {
		  	// Insert the token ID into the form so it gets submitted to the server
		  	var form = document.getElementById('payment-form');
		  	var hiddenInput = document.createElement('input');
		  	hiddenInput.setAttribute('type', 'hidden');
		  	hiddenInput.setAttribute('name', 'stripeToken');
		  	hiddenInput.setAttribute('value', token.id);
		  	form.appendChild(hiddenInput);

		  	// Submit the form
		  	form.submit();
		}
	</script>
@endsection