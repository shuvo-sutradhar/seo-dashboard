@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
@endsection

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
			
			@include('includes.alert')
			
			<section class="card card-horizontal mb-4">
				
				

				<div class="card-body">
					
					<h3 class="font-weight-semibold mt-3">Clients</h3>
					<a href="{{ route('client.create') }}" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button">
						<i class="fas fa-user"></i> Add Client
					</a>
					
					<br/>
					<table class="table table-responsive-md  mb-0" id="table">
						<thead>
							<tr>
								<th>Profile Pciture</th>
								<th>Cleint Name</th>
								<th>Cleint Email</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($users as $key => $user)
								<tr>
									<td>
										<figure class="image rounded img-60">
											<img src="uploads/profile_pic/{{$user->client && !empty($user->client->profile_picture) ? $user->client->profile_picture : 'avatar.png'}}" alt="{{ ucfirst($user->name) }}" class="rounded-circle">
										</figure>
									</td>

									<td>
										<a href="{{ route('client.show', $user->email) }}">{{ ucfirst($user->name) }}</a>
									</td>

									<td>
										<a href="mailto: {{ $user->email }}">{{ $user->email }}</a>
									</td>

									<td class="text-right">
										<div class="btn-group flex-wrap">
											<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu" role="menu">
												<a class="dropdown-item text-1" href="{{ route('client.show', $user->email) }}"><i class="far fa-eye"></i> View</a>

												<a class="dropdown-item text-1" href="{{ route('client.edit', $user->email) }}"><i class="fa fa-edit"></i> Edit</a>

												<a onclick="deleteData(event, '{{ $user->email }}')" class="dropdown-item text-1" href="#">
													<i class="fa fa-trash-alt"></i> Delete
												</a>

												<form action="{{ route('account.access') }}" method="post" class="access-account-form">

													@csrf

													<input type="hidden" name="email" value="{{ $user->email }}">
													<button type="submit" class="dropdown-item text-1">
													<i class="fas fa-sign-in-alt"></i> Access Account
													</button>
												</form>

												
											</div>
										</div>
									</td>
									
								</tr>
							@endforeach
						</tbody>
					</table>

					<div class="pull-right mt-4">
						{{ $users->links() }}
					</div>
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
                url  : "{{ url('/clients' ) }}"+ '/' + email,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token },
                cache: false,
                success: function (data) {
                    $("#table").load(location.href + " #table"); 
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
@endsection