@extends('layouts.master')

@section('page-style')
	
	<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
	<style type="text/css">
		.card-header-ban .card-header {
		    padding: 10px;
		}
		.card-header-ban .card-header a {
		    font-size: 14px;
		}

		.invalid-feedback {
		    display: block !important;
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
	
    @if(Session::has('success'))
        <div class="alert alert-success alert-size">
          <strong>{{Session('success')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    @endif
	<div class="row justify-content-center">
		<div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
			<section class="card">
				<div class="card-body">
					<div class="thumb-info mb-3">
						@if(auth()->user()->account_role == 2)
							<img src="{{ auth()->user()->client && auth()->user()->client->profile_picture ? asset('uploads/profile_pic/'.auth()->user()->client->profile_picture) : asset('assets/img/!logged-user.jpg') }}" class="rounded img-fluid" alt="{{ ucfirst(auth()->user()->name) }}" >
						@else 
							<img src="{{ auth()->user()->profile && auth()->user()->profile->profile_picture ? asset('uploads/profile_pic/'.auth()->user()->profile->profile_picture) : asset('assets/img/!logged-user.jpg') }}" class="rounded img-fluid" alt="{{ ucfirst(auth()->user()->profile_picture) }}" >
						@endif

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
					{!! Form::model(Auth()->user(), ['method'=>'PATCH','action'=>['UserController@profile_update',Auth()->user()->email],'files'=>true]) !!}

						@csrf

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

							@if(auth()->user()->account_role == 2)
							<input type="text" class="form-control" placeholder="Enter your number." id="phone" name="phone" value="{{ auth()->user()->client ? auth()->user()->client->phone : '' }}" >
							@else 
							<input type="text" class="form-control" placeholder="Enter your number." id="phone" name="phone" value="{{ auth()->user()->profile ? auth()->user()->profile->contact_number : '' }}" >
							@endif

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
											@if(auth()->user()->account_role == 2)
												<img src="{{ auth()->user()->client && auth()->user()->client->profile_picture ? asset('uploads/profile_pic/'.auth()->user()->client->profile_picture) : asset('assets/img/!logged-user.jpg') }}" class="rounded img-fluid" alt="{{ ucfirst(auth()->user()->name) }}" width="100px" height="100px">
											@else 
												<img src="{{ auth()->user()->profile && auth()->user()->profile->profile_picture ? asset('uploads/profile_pic/'.auth()->user()->profile->profile_picture) : asset('assets/img/!logged-user.jpg') }}" class="rounded img-fluid" alt="{{ ucfirst(auth()->user()->name) }}" width="100px" height="100px">
											@endif
										</div>
										<div class="form-group col-md-8">
											<label for="profile_picture">Upload Photo</label>
											<input type="file" name="profile_picture" class="form-control" id="profile_picture" placeholder="">

											@if ($errors->has('profile_picture'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('profile_picture') }}</strong>
						                        </span>
						                    @endif
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Additional info satart -->
						@if(Auth()->user()->account_role==2)
							<div class="card card-default widget-toggle-expand card-header-ban">
								<div class="card-header">
									<h4 class="card-title m-0">
										<a class="widget-toggle" href="#">
											Additional Information
										</a>
									</h4>
								</div>
								<div id="change-password" class="widget-content-expanded" style="">
									<div class="card-body">
										<div class="row w-100">
										   <div class="col-md-12 mb-3">
										      <div class="form-group custom-size">
										         <label for="address">Address </label> 
										         <input type="text" name="address" 
										         value="{{ auth()->user()->client ? auth()->user()->client->address : '' }}" id="address" class="form-control"> <!---->
										      </div>
										   </div>
										   <div class="col-md-6 mb-3">
										      <div class="form-group custom-size">
										        <label for="country">Country </label> 
										   		@php
										   			$countries = \App\Country::all();
										   		@endphp
												<select name="country" data-plugin-selectTwo class="form-control populate" id="timeZone">
													<option {{ auth()->user()->client && auth()->user()->client->country_id==null ? 'selected disabled' : ''  }} >Select Country</option>
													@foreach($countries as $country)
														<option {{auth()->user()->client && auth()->user()->client->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->countryname }}</option>
													@endforeach
												</select>
										      </div>
										   </div>
										   <div class="col-md-6 mb-3">
										      <div class="form-group custom-size">
										      	<label for="state">State </label> 
										      	<input type="text" id="state" class="form-control" value="{{ auth()->user()->client ? auth()->user()->client->state : '' }}" name="state">
										      </div>
										   </div>
										   <div class="col-md-6 mb-3">
										      <div class="form-group custom-size">
										      	<label for="city">City </label> 
										      	<input type="text" id="city" name="city" value="{{ auth()->user()->client ? auth()->user()->client->state : '' }}" class="form-control">
										      </div>
										   </div>
										   <div class="col-md-6 mb-3">
										      <div class="form-group custom-size">
										      	<label for="post_code">Postal / Zip Code </label> 
										      	<input type="text" id="post_code" value="{{ auth()->user()->client ? auth()->user()->client->post_code : '' }}" name="post_code" class="form-control"></div>
										   </div>
										   <div class="col-md-12 mt-3 mb-3">
										      <div class="custom-control custom-checkbox">
										      	<input {{auth()->user()->client && auth()->user()->client->company_name ? 'checked' : ''}} type="checkbox" id="action-2" class="custom-control-input"> 
										      	<label for="action-2" class="custom-control-label">I'm purchasing for a company</label>
										      </div>
										   </div>
										   <div id="company" style=";width:100%;display:{{ auth()->user()->client && auth()->user()->client->company_name ? 'flex' : 'none' }}">
											   <div class="col-md-6 mb-3">
											      <div class="form-group custom-size">
											      	<label for="city">Company Name </label> 
											      	<input type="text" id="city" name="company_name" value="{{ auth()->user()->client ? auth()->user()->client->company_name : '' }}" class="form-control">
											      </div>
											   </div>
											   <div class="col-md-6 mb-3">
											      <div class="form-group custom-size">
											      	<label for="city">Tax ID </label> 
											      	<input type="text" id="city" name="tax_id" value="{{ auth()->user()->client ? auth()->user()->client->tax_id : '' }}" class="form-control">
											      </div>
											   </div>
										</div>
									</div>
								</div>
							</div>
						@endif
						<!-- Additional info end -->

						<!-- password change satart -->
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
											<label for="current-password">Old Password</label>
											<input type="password" class="form-control" id="password" name="old_password" autocomplete="new-password">
											@if ($errors->has('old_password'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('old_password') }}</strong>
						                        </span>
						                    @endif
										</div>
										<div class="form-group col-md-12">
											<label for="password">New Password</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="">
											@if ($errors->has('password'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('password') }}</strong>
						                        </span>
						                    @endif
										</div>
										<div class="form-group col-md-12">
											<label for="password_confirmation">Confirm Password</label>
											<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="">
											@if ($errors->has('password_confirmation'))
						                        <span class="invalid-feedback" role="alert">
						                            <strong>{{ $errors->first('password_confirmation') }}</strong>
						                        </span>
						                    @endif
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- password change end -->
						<div class="form-row">
							<div class="col-md-12 text-right mt-3">
								<button type="submit" class="btn btn-primary modal-confirm">Save Changes</button>
							</div>
						</div>
					{!! Form::close() !!}
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

	</div>
@endsection



@section('page-script')
<script src="{{ asset('assets/vendor/select2/js/select2.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function(){
        $('#action-2').click(function(){
            if($(this).is(":checked")){
                $('#company').css('display','flex');
            }
            else if($(this).is(":not(:checked)")){
                $('#company').css('display','none');
            }
        });
    });
    
</script>
</script>
@endsection