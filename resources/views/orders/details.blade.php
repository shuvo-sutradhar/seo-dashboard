@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
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

					@if ($order->orderMessages->count() > 0 )
					
						<div class="row message-area">
							<h2>Messages</h2>
							<div class="card card-horizontal message-single" id="message-single">
								<div class="card-body order-communication-area">

									@foreach($order->orderMessages as $key => $message)

										<div class="message-single row">
											<div class="col-md-2 bg-white">
												<div class="ml-3 img-60 rounded">


													@if($message->messageSender->isClient())
														<img src="{{ asset('uploads/profile_pic') }}/{{ !$message->messageSender->client->profile_picture ? 'avatar.png' :  $message->messageSender->client->profile_picture }}" alt="{{ ucfirst($message->messageSender->name) }}" class="rounded-circle">
													@else
														{{-- <img src="{{ asset('uploads/profile_pic') }}/{{ !$message->messageSender->profile->profile_picture ? 'avatar.png' :  $message->messageSender->profile->profile_picture }}" alt="{{ ucfirst($message->messageSender->name) }}" class="rounded-circle"> --}}
													@endif
												</div>
											</div>
											<div class="col-md-10" id="message-{{ $key + 1 }}">

												<h4>{{ ucfirst($message->messageSender->name) }}</h4>
												<div class="btn-group flex-wrap float-right message-options">
													<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
													<div class="dropdown-menu" role="menu">
														<a class="dropdown-item text-1" href="{{ url()->current() }}#message-{{  $key + 1  }}"><i class="fa fa-link"></i> Link</a>
														<a class="dropdown-item text-1" href=""><i class="fa fa-edit"></i> Edit</a>
														
														<a onclick="deleteData(event, '{{ $message->id }}')" class="dropdown-item text-1" href="#">
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

										@if( ++$key !== count( $order->orderMessages ) )
											<hr/>
										@endif

										
									@endforeach
								</div>

							</div>
						</div>

					@endif


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
						<form action="{{ route('order.state', $order->order_number ) }}" method="post">
							
							@csrf
							@method('PUT')

							<div class="btn-group status-btn">

								<a class="mb-1 mt-1 mr-1 btn btn-success dropdown-toggle" data-toggle="dropdown" >{{ ucfirst($order->order_status) }} <span class="caret"></span></a>

								<div class="dropdown-menu" role="menu">
									<button type="submit" value="Pending" name="status" class="dropdown-item text-1">Pending <span class="text-muted small">Waiting for client to submit project details</span></button>

									<button type="submit" value="Submitted" name="status" class="dropdown-item text-1">Submitted <span class="text-muted small">Client has submitted project details</span></button>

									<button type="submit" value="Working" name="status" class="dropdown-item text-1">Working <span class="text-muted small">Order is in progress</span></button>

									<button type="submit" value="Complete" name="status" class="dropdown-item text-1">Complete <span class="text-muted small">Order has been delivered</span></button>

									<button type="submit" value="Canceled" name="status" class="dropdown-item text-1">Canceled <span class="text-muted small">Order stopped due to a refund</span></button>
								</div>
							</div>
							
						</form>
						

						<form action="{{ route('order.assign', $order->order_number) }}" method="post">
							
							@csrf
							@method('PUT')

							<div class="btn-group status-btn">
								<a href="#" class="mb-1 mt-1 mr-1 btn btn-primary dropdown-toggle" data-toggle="dropdown">
									
									@if($order->team_member_id == null)
										Anyone 
									@else
										{{ ucfirst($order->orderTeam->name)  }}
									@endif

									<span class="caret"></span>
								</a>
								<div class="dropdown-menu" role="menu">
									<button type="submit" value="anyone" name="teamMember" class="dropdown-item text-1" >Anyone <span class="text-muted small">Team members can still follow the order to receive updates</span></button>
									@foreach($teamMembers as $team)
										<button type="submit" value="{{ $team->id }}" name="teamMember" class="dropdown-item text-1" >{{ $team->name }} <span class="text-muted small">{{  $team->getRoleNames()->implode(' ') }}</span></button>
									@endforeach

								</div>
							</div>
						</form>

						<form action="{{ route('order.follow', $order->order_number) }}" method="post">

							@csrf
							@method('PUT')
						
							
								@if(isset($followOrUnfollow->is_following) && $followOrUnfollow->is_following == true)
									<button type="submit" name="follow" class="mb-1 mt-1 mr-1 btn btn-success " >
										<i class="fa fa-bell"></i> Following
									</button>
								@else
									<button type="submit" name="follow" class="mb-1 mt-1 mr-1 btn btn-danger " >
										<i class="far fa-bell-slash"></i> Unfollowing
									</button>
								@endif
							</button>

							{{-- {{ dd($order->userFollowingOrder) }} --}}

						</form>
						
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
								<div class="row">
									<div class="col-md-10">
										<select multiple data-plugin-selectTwo class="form-control populate" required>
											@foreach($tags as $tag)
												<option value="{{ $tag->id }}">{{ $tag->name }}</option>
											@endforeach
										</select>
										<a href="{{ route('tag.index') }}">Create New Tag</a>
									</div>
									<div class="col-md-2">
										<button class="btn btn-success" type="submit">Add</button>
									</div>
								</div>
								<br/>
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
	
	//import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';

	ClassicEditor
	    .create( document.querySelector( '#message-editor' ),{
	    	
			//plugins: [ CKFinder, ... ],

			toolbar: [
				'heading', 
				'|', 
				'bold', 'italic', 'link', 'bulletedlist', 'numberedlist', 'blockquote', 
				'|', 
				'imageUpload',
				'|',
				'undo', 'redo' 
			],


			/*
			ckfinder: {
            	// Upload the images to the server using the CKFinder QuickUpload command.
            	uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
        	}
        	*/
        }
	     )
	    .then( editor => {
	        console.log( editor );
	    } )
	    .catch( error => {
	        console.error( error );
	    } );
    


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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

	let table = document.querySelector('.message-single');
        //window.table1 = table1;

        function deleteData(event, id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({ 
                url  : "{{ url('orders/messages/delete' ) }}"+ "/" + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token },
                cache: false,
                success: function (data) {
                    $("#message-single").load(location.href + " #message-single"); 
                    swal({
                        title: "Delete Done!",
                        text: "You have deleted the client!",
                        icon: "success",
                        button: "Done",
                    });
                },
                error: function() {
                    swal({
                        title: "Oops...",
                        text: data.message,
                        type: 'error',
                        timer: '1500'
                    })
                }
              });

            } else {
                swal("The client is safe!");
            }
            });
            event.preventDefault(); 
            event.stopPropagation();
        }
</script>

<script src="{{ asset('assets/vendor/select2/js/select2.js') }}"></script>
@endsection

