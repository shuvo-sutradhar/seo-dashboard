@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
@endsection

@section('breadcrumb')
    <h2>Logs</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>All Logs</span></li>
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
					
					<h3 class="font-weight-semibold mt-3">Logs</h3>

					
					<br/>
					<table class="table table-responsive-md  mb-0" id="table">
						<thead>
							<tr>
								<th>MESSAGE</th>
								<th class="text-right">DATE</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($activities as $key => $activity)
								<tr>
									<td>{{ $activity->description }}</td>

									<td class="text-right">
										{{ $activity->created_at->format('d M Y') }}
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
{{-- <script>


	let table = document.querySelector('.table');
    //window.table1 = table1;

    function deleteData(event) {
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
            url  : "{{ route('service.delete', $service->slug) }}",
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
</script> --}}
@endsection