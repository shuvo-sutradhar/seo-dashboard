@extends('layouts.master')

@section('page-style')
<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
<script>
	tinymce.init({ 

		selector: '#message-editor',
		menubar: false,

	});
</script>
@endsection

@section('breadcrumb')
    <h2>Order Details</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{ route('home') }}">Orders</a></li>
            <li><span>Order number</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-12 col-xl-12">

			@include('includes.alert')

			@if (count($errors))
			    @foreach($errors->all() as $error)
				    <div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong><i class="fa fa-fw fa-check"></i> Oh snap!</strong> {{ $error }} 
					</div>
			    @endforeach
			@endif
			<div class="row">
				<div class="col-lg-7">
					<div class="row order-note">
						{{-- <h3 class="text-dark mb-3 mt-3">{{ $order->orderService->name }} ({{ $order->quantity }}Qty)</h3> --}}
						<div class="card card-featured-left card-featured-primary" style="width: 100%">
							<div class="card-body">
								<form action="{{ route('orderNote.update', $order->order_number) }}" method="post">
									@csrf
									@method('PUT')

									<div class="form-group order-note-field" id="order-note-area">
										<div id="order-note">
											<div id="note" class="note">
												{!! $order->order_note !!}
											</div>
											<div class="note-icon">
												<a class="edit-note" id="edit-note" href="#" onclick="noteEditor();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Note"><i class="fa fa-edit"></i></a>
											</div>
										</div>
										<div class="editor" id="note-editor"></div>
									</div>
								</form>
								
							</div>
						</div>
					</div>
					<div class="row message-area">
						<h2>Messages</h2>
						<div class="card card-horizontal">
							<div class="card-body order-communication-area">

								@foreach($order->orderMessages as $key => $message)

									<div class="message-single row">
										<div class="col-md-2 bg-white">
											<div class="ml-3 img-60 rounded">


												@if($message->messageSender->isClient())
													<img src="{{ asset('uploads/profile_pic') }}/{{ !$message->messageSender->client->profile_picture ? 'avatar.png' :  $message->messageSender->client->profile_picture }}" alt="{{ ucfirst($message->messageSender->name) }}" class="rounded-circle">
												@else
													<img src="{{ asset('uploads/profile_pic') }}/{{ !$message->messageSender->profile->profile_picture ? 'avatar.png' :  $message->messageSender->profile->profile_picture }}" alt="{{ ucfirst($message->messageSender->name) }}" class="rounded-circle">
												@endif
											</div>
										</div>
										<div class="col-md-10" id="message-{{ $message->message_link }}">

											<h4>{{ ucfirst($message->messageSender->name) }}</h4>
											<div class="btn-group flex-wrap float-right message-options">
												<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
												<div class="dropdown-menu" role="menu">
													<a class="dropdown-item text-1" href="{{ url()->current() }}#message-{{ $message->message_link }}"><i class="fa fa-link"></i> Link</a>
													<a class="dropdown-item text-1" href=""><i class="fa fa-edit"></i> Edit</a>

													<a onclick="deleteData(event)" class="dropdown-item text-1" href="#">
														<i class="fa fa-trash-alt"></i> Delete
													</a>
												</div>
											</div>
											<div class="date-area">
	                                            Mar 3rd at 07:28 pm &nbsp;                                           
	                                             <i class="fas fa-check" data-toggle="tooltip" data-original-title="Seen on Mar 3rd at 07:28 pm"></i>

	                                        </div>
											{!! $message->message_body !!}
										</div>
									</div>

									@if( $key !== count( $order->orderMessages ) -1 )
										<hr/>
									@endif

									
								@endforeach
							</div>

						</div>
					</div>
					<div class="row">
						<div class="card card-horizontal mt-5">
							<div class="card-body">
								<form action="{{ route('order.message') }}" method="post">

									@csrf
									<div class="form-group">

										<h3>Message</h3>
										<span class="radio-custom radio-primary">
											<input type="radio" id="radioExample" name="sendTo" value="client" checked>
											<label for="radioExample">Send to client</label>
										</span>
										<span class="radio-custom radio-primary ml-5 mb-4">
											<input type="radio" id="radioExample1" name="sendTo" value="team">
											<label for="radioExample1">Send to team</label>

										</span>
										<br/><br/>
										<div class="message-input">
											<textarea name="orderMessage" id="message-editor" class="" placeholder="Send a message or upload a file here"></textarea>
										</div>
										

										@if ($errors->has('orderMessage'))
					                        <span class="invalid-feedback" role="alert">
					                            <strong>{{ $errors->first('orderMessage') }}</strong>
					                        </span>
					                    @endif

					                    <input type="hidden" value="{{ $order->order_number }}" name="orderNumber">
									</div>
									<div class="form-group">
										The receiver will receive the message via email and in their client panel.
										<button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary float-right"><i class="fas fa-envelope"></i> Send Message</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="offset-lg-1 col-lg-4">
					<div class="row  mt-5 justify-content-center">
						<div class="btn-group">
							<button type="button" class="mb-1 mt-1 mr-1 btn btn-success dropdown-toggle" data-toggle="dropdown">Working <span class="caret"></span></button>
							<div class="dropdown-menu" role="menu">
								<a class="dropdown-item text-1" href="#">Pending <span class="text-muted small">Waiting for client to submit project details</span></a>
								<a class="dropdown-item text-1" href="#">Submitted <span class="text-muted small">Client has submitted project details</span></a>
								<a class="dropdown-item text-1" href="#">Working <span class="text-muted small">Order is in progress</span></a>
								<a class="dropdown-item text-1" href="#">Complete <span class="text-muted small">Order has been delivered</span></a>
								<a class="dropdown-item text-1" href="#">Canceled <span class="text-muted small">Order stopped due to a refund</span></a>
							</div>
						</div>
						<div class="btn-group">
							<button type="button" class="mb-1 mt-1 mr-1 btn btn-primary dropdown-toggle" data-toggle="dropdown">Anyone <span class="caret"></span></button>
							<div class="dropdown-menu" role="menu">
								<a class="dropdown-item text-1" href="#">Anyone <span class="text-muted small">Team members can still follow the order to receive updates</span></a>
								<a class="dropdown-item text-1" href="#">Jhon <span class="text-muted small">Empolyee</span></a>
								<a class="dropdown-item text-1" href="#">Alok <span class="text-muted small">Admin</span></a>
							</div>
						</div>
						
						<button type="button" class="mb-1 mt-1 mr-1 btn btn-default " ><i class="fa fa-bell"></i> Follow </button>
						
					</div>

					<div class="row">
						<div class="card card-horizontal mt-2">
							<div class="card-body">
								<h3>Order #B39U312Y 
									<span class="float-right">
										<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
										<div class="dropdown-menu" role="menu">
											<a class="dropdown-item text-1" href=""><i class="fa fa-edit"></i> Edit</a>

											<a onclick="deleteData(event)" class="dropdown-item text-1" href="#">
												<i class="fa fa-trash-alt"></i> Delete
											</a>
										</div>
									</span>
								</h3>
								<table class="details">
			                        <tbody>
			                        	<tr>
				                            <th style="width: 150px">Client</th>
				                            <td>
				                                <a href="https://alok.spp.io/accounts/client/2" data-pjax="">James Conor</a>
				                            </td>
				                        </tr>

			                            <tr>
			                                <th>Payment</th>
			                                <td><a href="https://alok.spp.io/invoice/B39U312Y" data-pjax="">Manual</a></td>
			                            </tr>
			                            <tr>
			                                <th>Amount</th>
			                                <td>bdt 0.00  </td>
			                            </tr>
			                            <tr>
			                                <th>Invoice</th>
			                                <td><a href="https://alok.spp.io/invoice/B39U312Y" data-pjax="">SPP-1</a></td>
			                            </tr>
			                            <tr>
			                                <th>Origin</th>
			                                <td><a href="https://alok.spp.io/order/Sample Orderform">Form Sample Orderform</a></td>
			                            </tr>
			                            <tr>
			                                <th>IP address</th>
			                                <td><a href="https://alok.spp.io/search?q=127.0.0.1" data-pjax="">127.0.0.1</a></td>
			                            </tr>
			                        
				                        <tr>
				                            <th>Order date</th>
				                            <td>Mar 3</td>
				                        </tr>
			                        
			                        </tbody>
			                    </table>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="card card-horizontal mt-2">
							<div class="card-body">
								<h3>Tags</h3>
								<div class="input-group mb-3">
									<input type="text" class="form-control">
									<span class="input-group-append">
										<button class="btn btn-success" type="button">Add</button>
									</span>
								</div>
								<button type="submit" class="btn btn-primary btn-sm" >New Tag ×</button>
								<button type="submit" class="btn btn-primary btn-sm" >New Tag ×</button>
								<button type="submit" class="btn btn-primary btn-sm" >New Tag ×</button>
								<button type="submit" class="btn btn-primary btn-sm" >New Tag ×</button>
							</div>
						</div>
					</div>
				</div>

				
				
			</div>

		</div>

	</div>

@endsection



@section('page-script')
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>



<script type="text/javascript">
	
    function noteEditor()
    {

	    var maxField = 2; //Input fields increment limitation
	    var editNote = $('.edit-note'); //Add button selector
	    var wrapper = $('.editor'); //Input field wrapper
	    var x = 1; //Initial field counter is 1
	    
        //Check maximum number of input fields
        if(x < maxField)
        { 
            //$(wrapper).append(fieldHTML); //Add field html
            var div = document.getElementById('note-editor');
            div.insertAdjacentHTML('beforeend', '<div id="remove-note-editor"><textarea name="orderNote" id="editor" class="form" required>{{ $order->order_note }}</textarea><button type="sumit" class="mb-1 mt-1 mr-1 btn btn-primary  btn-sm">Save Change</button><a class="mb-1 mt-1 mr-1 btn btn-danger btn-sm cancele-note" href="#" onclick="cancleNote()">Cancel</a></div>');

            var noteDive =  document.getElementById("order-note");
        	noteDive.remove(); //Remove field html

            ClassicEditor
			    .create( document.querySelector( '#editor' ),{
			    	
					toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedlist', 'numberedlist', 'blockquote', '|', 'undo', 'redo' ]
			    } )
			    .then( editor => {
			        console.log( editor );
			    } )
			    .catch( error => {
			        console.error( error );
			    } );
            x++; //Increment field counter

        }

	}
	    

    //Once remove button is clicked
    function cancleNote(){
        //x --; //Decrement field counter
        var pDiv =  document.getElementById("remove-note-editor");
        pDiv.remove(); 

        var noteDive =  document.getElementById("order-note-area");

        var divContent = '<div class="form-group order-note-field" id="order-note-area"><div id="order-note"><div id="note" class="note">{!! $order->order_note !!}</div><div class="note-icon"><a class="edit-note" id="edit-note" href="#" onclick="noteEditor();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Note"><i class="fa fa-edit" ></i> </a></div></div><div class="editor" id="note-editor"></div></div>';
        noteDive.insertAdjacentHTML('beforeend', divContent);
    };

</script>



@endsection

