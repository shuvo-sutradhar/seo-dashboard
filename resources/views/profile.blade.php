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
					<form class="p-3">
						<h4 class="mb-3">Personal Information</h4>
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" class="form-control" id="email" value="{{ auth()->user()->email }}" required>
						</div>
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" required value="{{ auth()->user()->name }}">
						</div>
						<div class="form-group">
							<label for="name">Phone</label>
							<input type="text" class="form-control" id="name" required value="{{ auth()->user()->name }}">
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
											<input type="file" class="form-control" id="new-photo" placeholder="" required>
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
										<div class="form-group col-md-6">
											<label for="inputPassword4">Current Password</label>
											<input type="password" class="form-control" id="inputPassword4" placeholder="Required to change password" required>
										</div>
										<div class="form-group col-md-6">
											<label for="inputPassword4">New Password</label>
											<input type="password" class="form-control" id="inputPassword4" placeholder="" required>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-12 text-right mt-3">
								<button class="btn btn-primary modal-confirm">Save Changes</button>
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