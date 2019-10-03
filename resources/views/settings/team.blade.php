@extends('layouts.master')


@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

	<style type="text/css">

		.team-row-1{
			display: flex;
		    justify-content: center;
		    align-items: center;
		    max-width: none;
		    margin: 0 auto;
		    border: 0 !important;
		}
		.team-row-3{
			margin: 0 auto;
		    display: flex;
		    border: 0 !important;
		    justify-content: center;
		}


		@media only screen and (max-width: 991px){
			.team-row-1 {
			    max-width: 100% !important;
			}
			figure.image.rounded.img-60 {
			    width: 100%;
			        display: inline-block;
			}
			.team-row-2 {
			    max-width: 50% !important;
			    display: inline-block !important;
			}

			.team-row-3 {
				    border-top: 1px solid #dee2e6 !important;
			    border-bottom: 0 !important;
			    max-width: 50% !important;
			    float: right;
			}
			.actions .btn-group {
				float: initial !important;
			}

		}
	</style>
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
	                <h3 class="font-weight-semibold mt-3 dark">Team Accounts</h3>
	                @if (auth()->user()->isAdmin() || auth()->user()->can('team-create'))
	                <a href="{{ route('account.create') }}" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button text-light" >
	                  <i class="fas fa-users"></i> Add Team
	                </a>
	                @endif
	              </div>

				
				<div class="card-body p-4 team">
					<table class="table table-no-more table-bordered table-striped mb-0" id="team-table">

                        <thead>
                            <tr>
                              <th class="text-center">NAME</th>
                              <th class="text-center">Role</th>
                              <th class="text-center">ACTIONS</th>
                            </tr>
                        </thead>		
						<tbody class="team-table">

							@foreach($users as $user)
								<tr>
									<td class="team-row-1">
										<figure class="image rounded img-60">

											@if(!empty($user->profile->profile_picture))
												<img src="{{ asset('uploads/profile_pic/') }}/{{ $user->profile->profile_picture }}" alt="{{ $user->name }}" class="rounded-circle">
											@else
												<img src="{{ asset('assets/img/!sample-user.jpg') }}" alt="Joseph Doe Junior" class="rounded-circle">
											@endif
										</figure>

										<div class="user-info">
											<a href="{{ route('account.edit', $user->email) }}">{{ ucfirst($user->name) }}</a>
											<p>{{ $user->email }}</p>
										</div>
									</td>
									<td class="user-role text-center team-row-2">
										<h5>{{  $user->getRoleNames()->implode(' ') }}</h5>
									</td>
									<td class="actions text-center team-row-3">
										<div class="btn-group flex-wrap">
											<button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu" role="menu">

	                							@if (auth()->user()->isAdmin() || auth()->user()->can('team-edit'))
												<a class="dropdown-item text-1" href="{{ route('account.edit', $user->email) }}">
													<i class="fa fa-edit"></i> Edit
												</a>
												@endif

	                							@if (auth()->user()->isAdmin() || auth()->user()->can('team-delete'))
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
												@endif
												
											</div>
										</div>
									</td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</section>
			<div class="row mt-5">
				<div class="col">
					{{ $users->links() }}
				</div>
			</div>

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
            url  : "{{ url('settings/accounts' ) }}"+ '/' + email,
            type : "DELETE",
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