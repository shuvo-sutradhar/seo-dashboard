@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('breadcrumb')
    <h2>General Settings</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href=""><i class="fas fa-cogs"></i>  Settings </a></li>
            <li><span>General Settings</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">

			<section class="card mb-4">

				@include('includes.alert')
				
				<div class="card-body">
					<form class="p-3" action="{{ route('general.updadate') }}" method="post" enctype="multipart/form-data">
						
						@csrf
						@method('PUT')

						<h4 class="mb-3">General Settings</h4>
						<div class="form-group">

							<label for="companyName">Company Name <span class="required">*</span></label>
							<input type="text" id="companyName" name="companyName" value="{{ $companyData->appName }}" class="form-control {{ $errors->has('companyName') ? ' is-invalid' : '' }}" required placeholder="{{ $companyData->appDispalyName }}">

							@if ($errors->has('companyName'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('companyName') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="companyLogo">Company Logo </label>
							<input type="file"  name="companyLogo" value="" class="form-control {{ $errors->has('companyLogo') ? ' is-invalid' : '' }}"  id="companyLogo">
								
							@if ($errors->has('companyLogo'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('companyLogo') }}</strong>
		                        </span>
		                    @endif


		                    <div class="company-logo">
		                    	<img src="{{ asset('/uploads/company_logo/') }}/{{ $companyData->appLogo }}" alt="Logo" id="preview-image">
		                    </div>

		                   

						</div>

						<div class="form-group">

							<label for="companyTitle">Company Title</label>
							<input type="text" id="companyTitle" name="companyTitle" value="{{ $companyData->appTitle }}" class="form-control {{ $errors->has('companyTitle') ? ' is-invalid' : '' }}" placeholder="{{ $companyData->titleDisplayName }}">

							@if ($errors->has('companyTitle'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('companyTitle') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="comapnyEmail">Company Email <span class="required">*</span></label>
							<input type="text" id="comapnyEmail" name="comapnyEmail" value="{{ $companyData->appEmail }}" class="form-control {{ $errors->has('comapnyEmail') ? ' is-invalid' : '' }}" placeholder="{{ $companyData->emailDispalyName }}">

							@if ($errors->has('comapnyEmail'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('comapnyEmail') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="companyPhone">Company Phone <span class="required">*</span></label>
							<input type="text" id="companyPhone" name="companyPhone" value="{{ $companyData->appPhone }}" class="form-control {{ $errors->has('companyPhone') ? ' is-invalid' : '' }}" placeholder="{{ $companyData->phoneDispalyName }}">

							@if ($errors->has('companyPhone'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('companyPhone') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="companyAddress">Company Address </label>
							<textarea  id="companyAddress" name="companyAddress" class="form-control {{ $errors->has('companyPhone') ? ' is-invalid' : '' }}" placeholder="{{ $companyData->addressDispalyName }}">{{ $companyData->appAddress }}</textarea>

							@if ($errors->has('companyAddress'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('companyAddress') }}</strong>
		                        </span>
		                    @endif

						</div>

						

						<div class="form-group">

							<label for="timeZone">Time Zone </label>
						
							<select data-plugin-selectTwo class="form-control populate {{ $errors->has('timeZone') ? ' is-invalid' : '' }}"  id="timeZone" name="timeZone"  required>
								<optgroup label="Alaskan/Hawaiian Time Zone">
									<option value="AK">Alaska</option>
									<option value="HI">Hawaii</option>
								</optgroup>
								<optgroup label="Pacific Time Zone">
									<option value="CA">California</option>
									<option value="NV">Nevada</option>
									<option value="OR">Oregon</option>
									<option value="WA">Washington</option>
								</optgroup>
								<optgroup label="Mountain Time Zone">
									<option value="AZ">Arizona</option>
									<option value="CO">Colorado</option>
									<option value="ID">Idaho</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NM">New Mexico</option>
									<option value="ND">North Dakota</option>
									<option value="UT">Utah</option>
									<option value="WY">Wyoming</option>
								</optgroup>
								<optgroup label="Central Time Zone">
									<option value="AL">Alabama</option>
									<option value="AR">Arkansas</option>
									<option value="IL">Illinois</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="OK">Oklahoma</option>
									<option value="SD">South Dakota</option>
									<option value="TX">Texas</option>
									<option value="TN">Tennessee</option>
									<option value="WI">Wisconsin</option>
								</optgroup>
								<optgroup label="Eastern Time Zone">
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="IN">Indiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="OH">Ohio</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WV">West Virginia</option>
								</optgroup>
							</select>

							@if ($errors->has('contactLink'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('contactLink') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="contactLink">Contact Link </label>
							<input type="text" id="contactLink" name="contactLink" value="{{ $companyData->appContactLink }}" class="form-control {{ $errors->has('contactLink') ? ' is-invalid' : '' }}" placeholder="{{ $companyData->contactLinkDispalyName }}">

							@if ($errors->has('contactLink'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('contactLink') }}</strong>
		                        </span>
		                    @endif

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
    
    $("#companyLogo").change(function(){
        readURL(this);
    });
</script>
@endsection