@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
@endsection

@section('breadcrumb')
    <h2>Services</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>All Services</span></li>
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
					
					<h3 class="font-weight-semibold mt-3">Services</h3>
					<a href="{{ route('service.create') }}" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button">
						<i class="fab fa-searchengin"></i> Add Service
					</a>
					
					<br/>
					<table class="table table-responsive-md  mb-0" id="table">
						<thead>
							<tr>
								<th>Service Thumbnail</th>
								<th>Service Name</th>
								<th>Price</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($services as $key => $service)
								<tr>
									<td>
										<figure class="image rounded img-60">
											@if (!empty($service->thumbnail))
												<img src="{{ asset('uploads/service_pic/') }}/{{ $service->thumbnail }}" alt="{{ $service->name }}">
											@else
												<img src="{{ asset('uploads/service_pic/default.png') }}/" alt="{{ $service->name }}" >
											@endif	
										</figure>
									</td>

									<td>
										<a href="">{{ $service->name }}</a>
									</td>

									<td>
										<a href="">${{ $service->price }}</a>
									</td>

									<td class="text-right">
										<div class="btn-group flex-wrap">
											<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu" role="menu">
												<a class="dropdown-item text-1" href="{{ route('service.edit', $service->id) }}"><i class="fa fa-edit"></i> Edit</a>

												<a class="dropdown-item text-1" href=""><i class="far fa-clone"></i> Duplicate</a>

												<a onclick="deleteData(event, '{{ $service->slug }}')" class="dropdown-item text-1" href="#">
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

        function deleteData(event,slug) {
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
                url  : "{{ url('/services') }}" + '/' + slug,
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