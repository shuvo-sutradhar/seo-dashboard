@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
@endsection

@section('breadcrumb')
   {{--  <h2>Orders</h2> --}}
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>All Orders</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">
			
			@include('includes.alert')
			
			<section class="card card-horizontal mb-4">
				
				

				<div class="card-body">
					
					<h3 class="font-weight-semibold mt-3 dark">Orders</h3>
					<a href="{{ route('order.create') }}" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button">
						<i class="fab fa-searchengin"></i> Add Order
					</a>
					
					<br/>
					<table class="table table-responsive-md  mb-0" id="table">
						<thead>
							<tr>
								<th>Invoice</th>
								<th>Client Name</th>
								<th>Status</th>
								<th>Added</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($orders as $key => $order)
								<tr>
									
									<td>
										<a href="{{ route('order.show', $order->order_number) }}">
											{{ $order->order_number }}
										</a>  &nbsp; <span class="badge badge-secondary"><i class="far fa-envelope" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $order->messageCount() }} {{ $order->messageCount() > 0 ? 'Messages' : 'Message' }}"></i> {{ $order->messageCount() }}</span>&nbsp;<span class="badge badge-secondary">New</span>

										@if(auth()->user()->followingOrders->count() > $key)
											@if(auth()->user()->followingOrders[$key++]->is_following == true)
												<span class="badge badge-secondary"><i class="far fa-bell" data-toggle="tooltip" data-placement="top" title="" data-original-title="You're following this order"></i></span>
											@endif
										@endif

										
										<p>
											{{ $order->quantity }} x {{ $order->orderService->name }} 
											(${{number_format($order->orderService->price, 2) }}) 
										</p>
										
									</td>
									<td><a href="{{ route('client.show', $order->orderClinet->email) }}">{{ $order->orderClinet->name }}</a></td>

									<td>
										<button class="btn btn-primary btn-sm m-xs" data-toggle="popover" data-container="body" data-placement="top" title="{{ ucfirst($order->order_status) }}" data-content="Example of top popover, click again to close :)">{{ ucfirst($order->order_status) }}</button>

										
									</td>

									<td>{{ $order->created_at->format('d M y') }}</td>

									<td class="text-right">
										<div class="btn-group flex-wrap">
											<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu" role="menu">
												<a class="dropdown-item text-1" href="{{ route('order.show', $order->order_number) }}"><i class="far fa-eye"></i> View</a>

												<a class="dropdown-item text-1" href="{{ route('order.edit', $order->order_number) }}"><i class="far fa-edit"></i> Edit</a>

												<a class="dropdown-item text-1" href=""><i class="far fa-bell-slash"></i> Unfollow</a>

												<a onclick="deleteData(event,{{ $order->id }})" class="dropdown-item text-1" href="#">
													<i class="fa fa-trash-alt"></i> Delete
												</a>

												
											</div>
										</div>
									</td>
									
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</section>
			

		</div>

	</div>

@endsection



@section('page-script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>


	let table = document.querySelector('.table');
        //window.table1 = table1;

        function deleteData(event,id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this file!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({ 
                url  : "{{ url('order-delete') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token },
                cache: false,
                success: function (data) {
                    $("#table").load(location.href + " #table"); 
                    swal({
                        title: "Delete Done!",
                        text: "You have deleted the service!",
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
                swal("Your imaginary fill is safe!");
            }
            });
            event.preventDefault(); 
            event.stopPropagation();
        }
</script>
@endsection