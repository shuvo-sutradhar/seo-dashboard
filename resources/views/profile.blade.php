@extends('layouts.master')

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

					<div class="widget-toggle-expand mb-3">
						<div class="widget-header">
							<h5 class="mb-2">Profile Completion</h5>
							<div class="widget-toggle">+</div>
						</div>
						<div class="widget-content-collapsed">
							<div class="progress progress-xs light">
								<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
									60%
								</div>
							</div>
						</div>
						<div class="widget-content-expanded">
							<ul class="simple-todo-list mt-3">
								<li class="completed">Update Profile Picture</li>
								<li class="completed">Change Personal Information</li>
								<li>Update Social Media</li>
								<li>Follow Someone</li>
							</ul>
						</div>
					</div>

					<hr class="dotted short">

					<h5 class="mb-2 mt-3">About</h5>
					<p class="text-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis vulputate quam. Interdum et malesuada</p>
					<div class="clearfix">
						<a class="text-uppercase text-muted float-right" href="#">(View All)</a>
					</div>

					<hr class="dotted short">

					<div class="social-icons-list">
						<a rel="tooltip" data-placement="bottom" target="_blank" href="http://www.facebook.com" data-original-title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
						<a rel="tooltip" data-placement="bottom" href="http://www.twitter.com" data-original-title="Twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
						<a rel="tooltip" data-placement="bottom" href="http://www.linkedin.com" data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
					</div>

				</div>
			</section>
			
		</div>
		<div class="col-lg-8 col-xl-6">
			

			@if (auth()->user()->isAdmin())
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

							
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title m-0">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#change-photo" aria-expanded="false">
											Change Photo
										</a>
									</h4>
								</div>
								<div id="change-photo" class="collapse" style="">
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
							
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title m-0">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#change-password" aria-expanded="false">
											Change Password
										</a>
									</h4>
								</div>
								<div id="change-password" class="collapse" style="">
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
			@endif
			{{-- <div class="tabs">
				<ul class="nav nav-tabs tabs-primary">
					<li class="nav-item active">
						<a class="nav-link" href="#overview" data-toggle="tab">Overview</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#edit" data-toggle="tab">Edit</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="overview" class="tab-pane active">

						<div class="p-3">

							<h4 class="mb-3">Update Status</h4>

							<section class="simple-compose-box mb-3">
								<form method="get" action="/">
									<textarea name="message-text" data-plugin-textarea-autosize placeholder="What's on your mind?" rows="1"></textarea>
								</form>
								<div class="compose-box-footer">
									<ul class="compose-toolbar">
										<li>
											<a href="#"><i class="fas fa-camera"></i></a>
										</li>
										<li>
											<a href="#"><i class="fas fa-map-marker-alt"></i></a>
										</li>
									</ul>
									<ul class="compose-btn">
										<li>
											<a href="#" class="btn btn-primary btn-xs">Post</a>
										</li>
									</ul>
								</div>
							</section>

							<h4 class="mb-3 pt-4">Timeline</h4>

							<div class="timeline timeline-simple mt-3 mb-3">
								<div class="tm-body">
									<div class="tm-title">
										<h5 class="m-0 pt-2 pb-2 text-uppercase">November 2017</h5>
									</div>
									<ol class="tm-items">
										<li>
											<div class="tm-box">
												<p class="text-muted mb-0">7 months ago.</p>
												<p>
													It's awesome when we find a good solution for our projects, Porto Admin is <span class="text-primary">#awesome</span>
												</p>
											</div>
										</li>
										<li>
											<div class="tm-box">
												<p class="text-muted mb-0">7 months ago.</p>
												<p>
													What is your biggest developer pain point?
												</p>
											</div>
										</li>
										<li>
											<div class="tm-box">
												<p class="text-muted mb-0">7 months ago.</p>
												<p>
													Checkout! How cool is that!
												</p>
												<div class="thumbnail-gallery">
													<a class="img-thumbnail lightbox" href="img/projects/project-4.jpg" data-plugin-options='{ "type":"image" }'>
														<img class="img-fluid" width="215" src="img/projects/project-4.jpg">
														<span class="zoom">
															<i class="fas fa-search"></i>
														</span>
													</a>
												</div>
											</div>
										</li>
									</ol>
								</div>
							</div>
						</div>

					</div>
					<div id="edit" class="tab-pane">

						<form class="p-3">
							<h4 class="mb-3">Personal Information</h4>
							<div class="form-group">
								<label for="inputAddress">Address</label>
								<input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
							</div>
							<div class="form-group">
								<label for="inputAddress2">Address 2</label>
								<input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputCity">City</label>
									<input type="text" class="form-control" id="inputCity">
								</div>
								<div class="form-group col-md-4">
									<label for="inputState">State</label>
									<select id="inputState" class="form-control">
										<option selected>Choose...</option>
										<option>...</option>
									</select>
								</div>
								<div class="form-group col-md-2">
									<label for="inputZip">Zip</label>
									<input type="text" class="form-control" id="inputZip">
								</div>
							</div>

							<hr class="dotted tall">

							<h4 class="mb-3">Change Password</h4>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputPassword4">New Password</label>
									<input type="password" class="form-control" id="inputPassword4" placeholder="Password">
								</div>
								<div class="form-group col-md-6">
									<label for="inputPassword4">Re New Password</label>
									<input type="password" class="form-control" id="inputPassword4" placeholder="Password">
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12 text-right mt-3">
									<button class="btn btn-primary modal-confirm">Save</button>
								</div>
							</div>

						</form>

					</div>
				</div>
			</div> --}}
		</div>
		<div class="col-xl-3">

			<h4 class="mb-3 mt-0">Sale Stats</h4>
			<ul class="simple-card-list mb-3">
				<li class="primary">
					<h3>488</h3>
					<p class="text-light">Nullam quris ris.</p>
				</li>
				<li class="primary">
					<h3>$ 189,000.00</h3>
					<p class="text-light">Nullam quris ris.</p>
				</li>
				<li class="primary">
					<h3>16</h3>
					<p class="text-light">Nullam quris ris.</p>
				</li>
			</ul>

			

			<h4 class="mb-3 mt-4 pt-2">Messages</h4>
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