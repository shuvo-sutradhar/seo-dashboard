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
				<div class="card-body p-4">
					<h3 class="font-weight-semibold mt-3">Roles</h3>
					<br/>
					<table class="table table-responsive-md mb-0">
											
						<tbody>

							@foreach($roles as $key => $role)
								
								<tr>
									<td style="width: 100%">
										@if($role->name == 'Admin')
											<p>{{ $role->name }}</p>
										@else
											<a href="{{ route('role.edit', $role->id) }}">{{ $role->name }}</a>
										@endif	
										
									</td>
									
									<td class="actions">


										@if($role->name == 'Admin')
											<div class="btn-group flex-wrap">
												
											</div>
										@else
											<div class="btn-group flex-wrap">
												<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
												<div class="dropdown-menu" role="menu">
													<a class="dropdown-item text-1" href="{{ route('role.edit', $role->id) }}"><i class="fa fa-edit"></i> Edit</a>
													<a class="dropdown-item text-1" href="#">
														<i class="fa fa-trash-alt"></i> Delete
													</a>
												</div>
											</div>
										@endif	
										
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

			<section class="card card-horizontal mb-4">
				
				<div class="card-body p-4 team">
					<h3 class="font-weight-semibold mt-3">Team Accounts</h3>
					<br/>
					<table class="table teamTable table-responsive-md mb-0" id="team-table">
											
						<tbody>

							@foreach($users as $user)
								<tr>
									<td>
										<div class="row">
											<div class="col-lg-2 col-xl-2 ">
												<figure class="image rounded img-60">

													@if(!empty($user->profile->profile_picture))
														<img src="{{ asset('uploads/profile_pic/') }}/{{ $user->profile->profile_picture }}" alt="{{ $user->name }}" class="rounded-circle">
													@else
														<img src="{{ asset('assets/img/!sample-user.jpg') }}" alt="Joseph Doe Junior" class="rounded-circle">
													@endif
												</figure>
											</div>

											<div class="col-lg-10 col-xl-10">
												<div class="user-info">
													<a href="{{ route('account.edit', $user->email) }}">{{ ucfirst($user->name) }}</a>
													<p>{{ $user->email }}</p>
												</div>
											</div>
										</div>
										
									</td>
									<td class="user-role text-left">
										<h5>{{  $user->getRoleNames()->implode(' ') }}</h5>
									</td>
									<td class="actions">
										<div class="btn-group flex-wrap">
											<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu" role="menu">
												<a class="dropdown-item text-1" href="{{ route('account.edit', $user->email) }}">
													<i class="fa fa-edit"></i> Edit
												</a>

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
					<div class="row mt-5">
						<div class="col">
							{{ $users->links() }}
						</div>
						<div class="col text-right">
							<a href="{{ route('account.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add User</a>
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