@extends('layouts.master')

@section('page-style')

	<style type="text/css">
		.card-header-ban .card-header {
		    padding: 10px;
		}
		.card-header-ban .card-header a {
		    font-size: 14px;
		}
	</style>

@endsection

@section('breadcrumb')
    <h2>Dashboard</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Profile</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		<div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
			<section class="card">
				<div class="card-body">
					<div class="thumb-info mb-3">
						<img src="{{ asset('assets/img/!logged-user.jpg') }}" class="rounded img-fluid" alt="{{ ucfirst(auth()->user()->name) }}">
						<div class="thumb-info-title">
							<span class="thumb-info-inner">{{ ucfirst(auth()->user()->name) }}</span>

							@if(auth()->user()->isAdmin())
								<span class="thumb-info-type">ADMIN</span>
							@endif
						</div>
					</div>

				</div>
			</section>
			
		</div>
		<div class="col-lg-8 col-xl-6">
			
			<section class="card mb-4">
				<div class="card-body">
					<form class="p-3" action="{{ route('profile.update',auth()->user()->email) }}" method="patch" enctype="multipart/form-data" >

						@csrf
						@method('patch')
						<h4 class="mb-3">Personal Information</h4>
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" disabled>
						</div>
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" id="name" required value="{{ auth()->user()->name }}">

							@if ($errors->has('name'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('name.') }}</strong>
		                        </span>
		                    @endif
						</div>
						<div class="form-group">
							<label for="phone">Phone</label>
							<input type="text" class="form-control" placeholder="Enter your number." id="phone" name="phone" value="{{ auth()->user()->profile ? auth()->user()->profile->contact_number : '+' }}" >
							@if ($errors->has('phone'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('phone.') }}</strong>
		                        </span>
		                    @endif
						</div>
						<div class="card card-default widget-toggle-expand card-header-ban mt-4">
							<div class="card-header">
								<h4 class="card-title m-0">
									<a class="widget-toggle" href="#">
										Change Photo
									</a>
								</h4>
							</div>
							<div id="change-photo" class="widget-content-expanded" style="">
								<div class="card-body">
									<div class="form-row">
										<div class="form-group col-md-4">
											<img src="{{ asset('assets/img/!logged-user.jpg') }}" class="rounded img-fluid" alt="{{ ucfirst(auth()->user()->name) }}" width="100px" height="100px">
										</div>
										<div class="form-group col-md-8">
											<label for="new-photo">Upload Photo</label>
											<input type="file" class="form-control" id="new-photo" placeholder="">

											@if ($errors->has('new-photo'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('new-photo') }}</strong>
						                        </span>
						                    @endif
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card card-default widget-toggle-expand card-header-ban">
							<div class="card-header">
								<h4 class="card-title m-0">
									<a class="widget-toggle" href="#">
										Change Password
									</a>
								</h4>
							</div>
							<div id="change-password" class="widget-content-expanded" style="">
								<div class="card-body">
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="current_password">Current Password</label>
											<input type="password" class="form-control" id="current_password" name="current_password" autocomplete="new-password">
											@if ($errors->has('current_password'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('current_password') }}</strong>
						                        </span>
						                    @endif
										</div>
										<div class="form-group col-md-12">
											<label for="password">New Password</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="">
											@if ($errors->has('current_password'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('current_password') }}</strong>
						                        </span>
						                    @endif
										</div>
										<div class="form-group col-md-12">
											<label for="confirm-password">Confirm Password</label>
											<input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 text-right mt-3">
								<button type="submit" class="btn btn-primary modal-confirm">Save Changes</button>
							</div>
						</div>
					</form>
				</div>


				<br/><br/>
				<div class="card-body">
					<h4 class="mb-3">Recent login history</h4>
					<table class="table table-responsive-md table-hover mb-0">
						
						<tbody>
							<tr>
								<td>Feb 2nd at 10:11 am</td>
								<td><i class="fab fa-chrome"></i></td>
								<td>Bangladesh</td>
								<td>Active 2 hours ago</td>
							</tr>
							<tr>
								<td>Feb 2nd at 10:11 am</td>
								<td><i class="fab fa-chrome"></i></td>
								<td>Bangladesh</td>
								<td>Active 2 hours ago</td>
							</tr>
							<tr>
								<td>Feb 2nd at 10:11 am</td>
								<td><i class="fab fa-chrome"></i></td>
								<td>Bangladesh</td>
								<td>Active 2 hours ago</td>
							</tr>
						</tbody>
					</table>
				</div>
			</section>

		</div>
		<div class="col-xl-3">


			

			<h4 class="mb-3 mt-0 pt-2">Messages</h4>
			<ul class="simple-user-list mb-3">
				<li>
					<figure class="image rounded">
						<img src="{{ asset('assets/img/!sample-user.jpg') }}" alt="Joseph Doe Junior" class="rounded-circle">
					</figure>
					<span class="title">Joseph Doe Junior</span>
					<span class="message">Lorem ipsum dolor sit.</span>
				</li>
				<li>
					<figure class="image rounded">
						<img src="{{ asset('assets/img/!sample-user.jpg') }}" alt="Joseph Junior" class="rounded-circle">
					</figure>
					<span class="title">Joseph Junior</span>
					<span class="message">Lorem ipsum dolor sit.</span>
				</li>
				<li>
					<figure class="image rounded">
						<img src="{{ asset('assets/img/!sample-user.jpg') }}" alt="Joe Junior" class="rounded-circle">
					</figure>
					<span class="title">Joe Junior</span>
					<span class="message">Lorem ipsum dolor sit.</span>
				</li>
				<li>
					<figure class="image rounded">
						<img src="{{ asset('assets/img/!sample-user.jpg') }}" alt="Joseph Doe Junior" class="rounded-circle">
					</figure>
					<span class="title">Joseph Doe Junior</span>
					<span class="message">Lorem ipsum dolor sit.</span>
				</li>
			</ul>
		</div>
	</div>
@endsection