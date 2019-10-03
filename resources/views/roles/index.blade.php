@extends('layouts.master')


@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
@endsection



@section('breadcrumb')
    <h2>Team Settings</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href=""><i class="fas fa-cogs"></i>  Settings </a></li>
            <li><span>Team Settings</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">
			@include('includes.alert')
			<section class="card card-horizontal mb-4">

	            <div class="card_header">
	                <h3 class="font-weight-semibold mt-3 dark">Roles</h3>
	                <a href="{{ route('settings') }}" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> Go back
	                </a>
	            </div>
				<div class="card-body p-4">
					<table class="table table-responsive-md mb-0">
						<thead>
							<th>Name</th>
							<th>Action</th>
						</thead>				
						<tbody>

							@foreach($roles as $key => $role)
								
								<tr>
									<td style="width: 100%">
										<a href="{{ route('role.edit', $role->id) }}">{{ $role->name }}</a>
										
									</td>
									
									<td class="actions">

										<div class="btn-group flex-wrap">
											<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu" role="menu">
												<a class="dropdown-item text-1" href="{{ route('role.edit', $role->id) }}"><i class="fa fa-edit"></i> Edit</a>
												<a class="dropdown-item text-1" href="#">
													<i class="fa fa-trash-alt"></i> Delete
												</a>
											</div>
										</div>
										
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<div class="row mt-5">
						<div class="col">
							{{ $roles->links() }}
						</div>
						<div class="col text-right">
							<a href="{{ route('role.create') }}" class="btn btn-primary"><i class="fas fa-users-cog"></i> Add Role</a>
						</div>
					</div>

					
				</div>
			</section>


		</div>

	</div>
@endsection

@section('page-script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>


	let table = document.querySelector('.teamTable');
    //window.table1 = table1;

    function deleteData(event, email) {
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
            url  : "{{ url('/accounts' ) }}"+ '/' + email,
            type : "POST",
            data : {'_method' : 'DELETE', '_token' : csrf_token },
            cache: false,
            success: function (data) {
                $("#team-table").load(location.href + " #team-table"); 
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
            swal("Great your data is safe!");
        }
        });
        event.preventDefault(); 
        event.stopPropagation();
    }
</script>
@endsection