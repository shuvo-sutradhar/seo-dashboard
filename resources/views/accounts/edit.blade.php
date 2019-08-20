@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('breadcrumb')
    <h2>Edit User</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{ route('account.index') }}"><i class="fas fa-cogs"></i>  Team Settings </a></li>
            <li><span>Edit user</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">

			<section class="card card-horizontal mb-4">
				<div class="card-body">
					<form class="p-3" action="{{ route('account.update', $user->email) }}" method="post" enctype="multipart/form-data">
						
						@csrf
						@method('PUT')

						<h4 class="mb-3">Edit team member {{ ucfirst($user->name) }}</h4>
						<div class="form-group">

							<label for="email">Email <span class="required">*</span></label>
							<input type="email" id="email" name="email"  class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required placeholder="example@gmail.com" value="{{ $user->email }}">

							@if ($errors->has('email'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('email') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="name"> Name <span class="required">*</span></label>
							<input type="text" id="name" name="name"  class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required placeholder="John Doe" value="{{ $user->name }}">

							@if ($errors->has('name'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="phone"> Phone </label>
							<input type="text" id="phone" name="phone"  class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"  placeholder="+880 1754218741" value="{{ $user->profile->contact_number }}">

							@if ($errors->has('phone'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('phone') }}</strong>
		                        </span>
		                    @endif

						</div>


						<div class="form-group">

							<label for="role">Role <span class="required">*</span></label>
						
							<select data-plugin-selectTwo class="form-control populate {{ $errors->has('role') ? ' is-invalid' : '' }}"  id="role" name="role"  required>
								
								@foreach ($roles as $role)

									<option value="{{ $role->id }}" {{ $role->name == $user->getRoleNames()->implode(' ') ? 'selected' : '' }}>{{ $role->name }}</option>
									
								@endforeach

							</select>

							@if ($errors->has('role'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('role') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="profilePic">Profile Picture</label>
							<input type="file"  name="profilePic"  class="form-control {{ $errors->has('profilePic') ? ' is-invalid' : '' }}"  id="profilePic">
								
							@if ($errors->has('profilePic'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('profilePic') }}</strong>
		                        </span>
		                    @endif


		                    <div class="profilePic-preview">
		                    	@if(!empty($user->profile->profile_picture))
		                    		<img src="{{ asset('/uploads/profile_pic/') }}/{{ $user->profile->profile_picture }}" alt="Profile Picture" id="preview-image">
		                    	@else
									<img src="{{ asset('/uploads/profile_pic/') }}/avatar.png" alt="Profile Picture" id="preview-image">
		                    	@endif
		                    </div>
						</div>

						<div class="form-group">
							<div class="checkbox-custom checkbox-primary">
								<input type="checkbox" checked="" id="mailNotification" name="changePassword">
								<label for="mailNotification">Change Password & Notification in Email</label>
							</div>
						</div>

						<div class="form-group" id="password-area">

							<div id="remove">
								<label for="password">Password <span class="required">*</span></label><input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="New password" required>

								@if ($errors->has('password'))
			                        <span class="invalid-feedback" role="alert">
			                            <strong>{{ $errors->first('password') }}</strong>
			                        </span>
			                    @endif
							</div>
						</div>

						<br/>

						<button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary"><i class="fas fa-edit"></i> Save Changes</button>

						
					</form>
				</div>
			</section>


		</div>

	</div>
@endsection



@section('page-script')
<script src="{{ asset('assets/vendor/select2/js/select2.js') }}"></script>
<script type="text/javascript">
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#profilePic").change(function(){
        readURL(this);
    });
</script>
<script type="text/javascript">
	
    var checkbox = document.getElementById('mailNotification');

	checkbox.addEventListener( 'change', function() {
	    if(this.checked) {
	        // Checkbox is checked..
	        var passwordArea = '<div id="remove"><label for="password">Password <span class="required">*</span></label><input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="New password" required>@if ($errors->has('password'))<span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>@endif</div>';
        	var div = document.getElementById('password-area');
        	
        	div.insertAdjacentHTML('beforeend', passwordArea);
	    } else {
	        // Checkbox is not checked..
	        var pDiv =  document.getElementById("remove");
		    pDiv.remove(); //Remove field html
	    }
	});
</script>
@endsection

