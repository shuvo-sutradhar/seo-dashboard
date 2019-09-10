@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('breadcrumb')
    <h2>Edit Client</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{ route('client.index') }}"><i class="fas fa-cogs"></i>  Clients </a></li>
            <li><span>Edit Client</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">

			<section class="card card-horizontal mb-4">
				<div class="card-body">
					<form class="p-3" action="{{ route('client.update', $user->email) }}" method="post" enctype="multipart/form-data">
						
						@csrf
						@method('PUT')

						<h4 class="mb-3">Edit client {{ ucfirst($user->name) }}</h4>
						<div class="form-group">

							<label for="clientName">Client Name <span class="required">*</span></label>
							<input type="text" id="clientName" name="clientName"  class="form-control {{ $errors->has('clientName') ? ' is-invalid' : '' }}" required placeholder="John Einarson" value="{{ $user->name }}">

							@if ($errors->has('clientName'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('clientName') }}</strong>
		                        </span>
		                    @endif
						</div>

						<div class="form-group">

							<label for="clientEmail">Client Email <span class="required">*</span></label>
							<input type="email" id="clientEmail" name="clientEmail"  class="form-control {{ $errors->has('clientEmail') ? ' is-invalid' : '' }}" required placeholder="john@example.com" value="{{ $user->email }}" disabled>

							@if ($errors->has('clientEmail'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('clientEmail') }}</strong>
		                        </span>
		                    @endif
						</div>

						<div class="form-group">

							<label for="clientPhone">Client Phone </label>
							<input type="text" id="clientPhone" name="clientPhone"  class="form-control {{ $errors->has('clientPhone') ? ' is-invalid' : '' }}"  placeholder="+880 1754218741" value="{{ $user->client ? $user->client->phone : '' }}">

							@if ($errors->has('clientPhone'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('clientPhone') }}</strong>
		                        </span>
		                    @endif

						</div>
					
						<div class="form-group">

							<label for="profilePicture">Profile Picture</label>
							<input type="file"  name="profilePicture"  class="form-control {{ $errors->has('profilePicture') ? ' is-invalid' : '' }}"  id="profilePicture">
								
							@if ($errors->has('profilePicture'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('profilePicture') }}</strong>
		                        </span>
		                    @endif
	

		                    <div class="profilePic-preview">
		                    	@if (!is_null($user->client) && !empty($user->client->profile_picture))
		                    		<img src="{{ asset('/uploads/profile_pic/') }}/{{ $user->client->profile_picture }}" alt="Profile Picture" id="preview-image">
		                    	@else
		                    		<img src="{{ asset('/uploads/profile_pic/') }}/avatar.png" alt="Profile Picture" id="preview-image">
		                    	@endif
		                    </div>
						</div>

						<h4 class="mb-3">Billing information</h4>

						<div class="form-group">

							<label for="address">Address </label>
							<input type="text" id="address" name="address"  class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"  placeholder="Mirpur-10, Benarossi Polli" value="{{ $user->client ? $user->client->address : '' }}">

							@if ($errors->has('address'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('address') }}</strong>
		                        </span>
		                    @endif
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="city">City</label>
									<input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Dhaka" name="city" value="{{ $user->client ? $user->client->city : '' }}" >

									@if ($errors->has('city'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('city') }}</strong>
				                        </span>
				                    @endif
								</div>

								<div class="col-md-6">
									<label for="country">Country</label>
									
									<select data-plugin-selectTwo class="form-control populate {{ $errors->has('country') ? ' is-invalid' : '' }}"  id="country" name="country"  required>
									    <option value="AF">Afghanistan</option>
									    <option value="AX">Åland Islands</option>
									    <option value="AL">Albania</option>
									    <option value="DZ">Algeria</option>
									    <option value="AS">American Samoa</option>
									    <option value="AD">Andorra</option>
									    <option value="AO">Angola</option>
									    <option value="AI">Anguilla</option>
									    <option value="AQ">Antarctica</option>
									    <option value="AG">Antigua and Barbuda</option>
									    <option value="AR">Argentina</option>
									    <option value="AM">Armenia</option>
									    <option value="AW">Aruba</option>
									    <option value="AU">Australia</option>
									    <option value="AT">Austria</option>
									    <option value="AZ">Azerbaijan</option>
									    <option value="BS">Bahamas</option>
									    <option value="BH">Bahrain</option>
									    <option value="BD" selected="">Bangladesh</option>
									    <option value="BB">Barbados</option>
									    <option value="BY">Belarus</option>
									    <option value="BE">Belgium</option>
									    <option value="BZ">Belize</option>
									    <option value="BJ">Benin</option>
									    <option value="BM">Bermuda</option>
									    <option value="BT">Bhutan</option>
									    <option value="BO">Bolivia</option>
									    <option value="BA">Bosnia and Herzegovina</option>
									    <option value="BW">Botswana</option>
									    <option value="BV">Bouvet Island</option>
									    <option value="BR">Brazil</option>
									    <option value="IO">British Indian Ocean Territory</option>
									    <option value="BN">Brunei Darussalam</option>
									    <option value="BG">Bulgaria</option>
									    <option value="BF">Burkina Faso</option>
									    <option value="BI">Burundi</option>
									    <option value="KH">Cambodia</option>
									    <option value="CM">Cameroon</option>
									    <option value="CA">Canada</option>
									    <option value="CV">Cape Verde</option>
									    <option value="KY">Cayman Islands</option>
									    <option value="CF">Central African Republic</option>
									    <option value="TD">Chad</option>
									    <option value="CL">Chile</option>
									    <option value="CN">China</option>
									    <option value="CX">Christmas Island</option>
									    <option value="CC">Cocos (Keeling) Islands</option>
									    <option value="CO">Colombia</option>
									    <option value="KM">Comoros</option>
									    <option value="CG">Congo</option>
									    <option value="CD">Congo, The Democratic Republic of The</option>
									    <option value="CK">Cook Islands</option>
									    <option value="CR">Costa Rica</option>
									    <option value="CI">Cote D'ivoire</option>
									    <option value="HR">Croatia</option>
									    <option value="CU">Cuba</option>
									    <option value="CY">Cyprus</option>
									    <option value="CZ">Czech Republic</option>
									    <option value="DK">Denmark</option>
									    <option value="DJ">Djibouti</option>
									    <option value="DM">Dominica</option>
									    <option value="DO">Dominican Republic</option>
									    <option value="EC">Ecuador</option>
									    <option value="EG">Egypt</option>
									    <option value="SV">El Salvador</option>
									    <option value="GQ">Equatorial Guinea</option>
									    <option value="ER">Eritrea</option>
									    <option value="EE">Estonia</option>
									    <option value="ET">Ethiopia</option>
									    <option value="FK">Falkland Islands (Malvinas)</option>
									    <option value="FO">Faroe Islands</option>
									    <option value="FJ">Fiji</option>
									    <option value="FI">Finland</option>
									    <option value="FR">France</option>
									    <option value="GF">French Guiana</option>
									    <option value="PF">French Polynesia</option>
									    <option value="TF">French Southern Territories</option>
									    <option value="GA">Gabon</option>
									    <option value="GM">Gambia</option>
									    <option value="GE">Georgia</option>
									    <option value="DE">Germany</option>
									    <option value="GH">Ghana</option>
									    <option value="GI">Gibraltar</option>
									    <option value="GR">Greece</option>
									    <option value="GL">Greenland</option>
									    <option value="GD">Grenada</option>
									    <option value="GP">Guadeloupe</option>
									    <option value="GU">Guam</option>
									    <option value="GT">Guatemala</option>
									    <option value="GG">Guernsey</option>
									    <option value="GN">Guinea</option>
									    <option value="GW">Guinea-bissau</option>
									    <option value="GY">Guyana</option>
									    <option value="HT">Haiti</option>
									    <option value="HM">Heard Island and Mcdonald Islands</option>
									    <option value="VA">Holy See (Vatican City State)</option>
									    <option value="HN">Honduras</option>
									    <option value="HK">Hong Kong</option>
									    <option value="HU">Hungary</option>
									    <option value="IS">Iceland</option>
									    <option value="IN">India</option>
									    <option value="ID">Indonesia</option>
									    <option value="IR">Iran, Islamic Republic of</option>
									    <option value="IQ">Iraq</option>
									    <option value="IE">Ireland</option>
									    <option value="IM">Isle of Man</option>
									    <option value="IL">Israel</option>
									    <option value="IT">Italy</option>
									    <option value="JM">Jamaica</option>
									    <option value="JP">Japan</option>
									    <option value="JE">Jersey</option>
									    <option value="JO">Jordan</option>
									    <option value="KZ">Kazakhstan</option>
									    <option value="KE">Kenya</option>
									    <option value="KI">Kiribati</option>
									    <option value="KP">Korea, Democratic People's Republic of</option>
									    <option value="KR">Korea, Republic of</option>
									    <option value="KW">Kuwait</option>
									    <option value="KG">Kyrgyzstan</option>
									    <option value="LA">Lao People's Democratic Republic</option>
									    <option value="LV">Latvia</option>
									    <option value="LB">Lebanon</option>
									    <option value="LS">Lesotho</option>
									    <option value="LR">Liberia</option>
									    <option value="LY">Libyan Arab Jamahiriya</option>
									    <option value="LI">Liechtenstein</option>
									    <option value="LT">Lithuania</option>
									    <option value="LU">Luxembourg</option>
									    <option value="MO">Macao</option>
									    <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
									    <option value="MG">Madagascar</option>
									    <option value="MW">Malawi</option>
									    <option value="MY">Malaysia</option>
									    <option value="MV">Maldives</option>
									    <option value="ML">Mali</option>
									    <option value="MT">Malta</option>
									    <option value="MH">Marshall Islands</option>
									    <option value="MQ">Martinique</option>
									    <option value="MR">Mauritania</option>
									    <option value="MU">Mauritius</option>
									    <option value="YT">Mayotte</option>
									    <option value="MX">Mexico</option>
									    <option value="FM">Micronesia, Federated States of</option>
									    <option value="MD">Moldova, Republic of</option>
									    <option value="MC">Monaco</option>
									    <option value="MN">Mongolia</option>
									    <option value="ME">Montenegro</option>
									    <option value="MS">Montserrat</option>
									    <option value="MA">Morocco</option>
									    <option value="MZ">Mozambique</option>
									    <option value="MM">Myanmar</option>
									    <option value="NA">Namibia</option>
									    <option value="NR">Nauru</option>
									    <option value="NP">Nepal</option>
									    <option value="NL">Netherlands</option>
									    <option value="AN">Netherlands Antilles</option>
									    <option value="NC">New Caledonia</option>
									    <option value="NZ">New Zealand</option>
									    <option value="NI">Nicaragua</option>
									    <option value="NE">Niger</option>
									    <option value="NG">Nigeria</option>
									    <option value="NU">Niue</option>
									    <option value="NF">Norfolk Island</option>
									    <option value="MP">Northern Mariana Islands</option>
									    <option value="NO">Norway</option>
									    <option value="OM">Oman</option>
									    <option value="PK">Pakistan</option>
									    <option value="PW">Palau</option>
									    <option value="PS">Palestinian Territory, Occupied</option>
									    <option value="PA">Panama</option>
									    <option value="PG">Papua New Guinea</option>
									    <option value="PY">Paraguay</option>
									    <option value="PE">Peru</option>
									    <option value="PH">Philippines</option>
									    <option value="PN">Pitcairn</option>
									    <option value="PL">Poland</option>
									    <option value="PT">Portugal</option>
									    <option value="PR">Puerto Rico</option>
									    <option value="QA">Qatar</option>
									    <option value="RE">Reunion</option>
									    <option value="RO">Romania</option>
									    <option value="RU">Russian Federation</option>
									    <option value="RW">Rwanda</option>
									    <option value="SH">Saint Helena</option>
									    <option value="KN">Saint Kitts and Nevis</option>
									    <option value="LC">Saint Lucia</option>
									    <option value="PM">Saint Pierre and Miquelon</option>
									    <option value="VC">Saint Vincent and The Grenadines</option>
									    <option value="WS">Samoa</option>
									    <option value="SM">San Marino</option>
									    <option value="ST">Sao Tome and Principe</option>
									    <option value="SA">Saudi Arabia</option>
									    <option value="SN">Senegal</option>
									    <option value="RS">Serbia</option>
									    <option value="SC">Seychelles</option>
									    <option value="SL">Sierra Leone</option>
									    <option value="SG">Singapore</option>
									    <option value="SK">Slovakia</option>
									    <option value="SI">Slovenia</option>
									    <option value="SB">Solomon Islands</option>
									    <option value="SO">Somalia</option>
									    <option value="ZA">South Africa</option>
									    <option value="GS">South Georgia and The South Sandwich Islands</option>
									    <option value="ES">Spain</option>
									    <option value="LK">Sri Lanka</option>
									    <option value="SD">Sudan</option>
									    <option value="SR">Suriname</option>
									    <option value="SJ">Svalbard and Jan Mayen</option>
									    <option value="SZ">Swaziland</option>
									    <option value="SE">Sweden</option>
									    <option value="CH">Switzerland</option>
									    <option value="SY">Syrian Arab Republic</option>
									    <option value="TW">Taiwan, Province of China</option>
									    <option value="TJ">Tajikistan</option>
									    <option value="TZ">Tanzania, United Republic of</option>
									    <option value="TH">Thailand</option>
									    <option value="TL">Timor-leste</option>
									    <option value="TG">Togo</option>
									    <option value="TK">Tokelau</option>
									    <option value="TO">Tonga</option>
									    <option value="TT">Trinidad and Tobago</option>
									    <option value="TN">Tunisia</option>
									    <option value="TR">Turkey</option>
									    <option value="TM">Turkmenistan</option>
									    <option value="TC">Turks and Caicos Islands</option>
									    <option value="TV">Tuvalu</option>
									    <option value="UG">Uganda</option>
									    <option value="UA">Ukraine</option>
									    <option value="AE">United Arab Emirates</option>
									    <option value="GB">United Kingdom</option>
									    <option value="US">United States</option>
									    <option value="UM">United States Minor Outlying Islands</option>
									    <option value="UY">Uruguay</option>
									    <option value="UZ">Uzbekistan</option>
									    <option value="VU">Vanuatu</option>
									    <option value="VE">Venezuela</option>
									    <option value="VN">Viet Nam</option>
									    <option value="VG">Virgin Islands, British</option>
									    <option value="VI">Virgin Islands, U.S.</option>
									    <option value="WF">Wallis and Futuna</option>
									    <option value="EH">Western Sahara</option>
									    <option value="YE">Yemen</option>
									    <option value="ZM">Zambia</option>
									    <option value="ZW">Zimbabwe</option>
									</select>

									@if ($errors->has('country'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('country') }}</strong>
				                        </span>
				                    @endif

								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								
								<div class="col-md-6">
									<label for="state">State </label>
									
									<input type="text" class="form-control" placeholder="Client State / Province / Region" name="state" value="{{ $user->client ? $user->client->state : ''}}">

									@if ($errors->has('state'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('state') }}</strong>
				                        </span>
				                    @endif
								</div>

								<div class="col-md-6">
									<label for="postalCode">Postal / Zip Code</label>
									<input type="text" class="form-control {{ $errors->has('postalCode') ? ' is-invalid' : '' }}" placeholder="Postal / Zip Code" name="postalCode" value="{{ $user->client ? $user->client->post_code : '' }}">

									@if ($errors->has('postalCode'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('postalCode') }}</strong>
				                        </span>
				                    @endif
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="companyName">Company Name </label>
									<input type="text" id="companyName" name="companyName"  class="form-control {{ $errors->has('companyName') ? ' is-invalid' : '' }}"  placeholder="Codeshaper" value="{{ $user->client ?  $user->client->company_name : '' }}">

									@if ($errors->has('companyName'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('companyName') }}</strong>
				                        </span>
				                    @endif
								</div>
								<div class="col-md-6">
									<label for="taxID">Tax ID </label>
									<input type="text" id="taxID" name="taxID"  class="form-control {{ $errors->has('taxID') ? ' is-invalid' : '' }}" placeholder="Tax ID" value="{{ $user->client ? $user->client->tax_id : '' }}">

									@if ($errors->has('taxID'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('taxID') }}</strong>
				                        </span>
				                    @endif
								</div>
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
								<label for="password">Password</label><input type="password" id="password" value="" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="New password" autocomplete="false">

								@if ($errors->has('password'))
			                        <span class="invalid-feedback" role="alert">
			                            <strong>{{ $errors->first('password') }}</strong>
			                        </span>
			                    @endif
							</div>
							<br>
							<div id="remove">
								<label for="password">Confirm Password</label>
                            	<input name="password_confirmation" type="password" class="form-control" />

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
	    
	    $("#profilePicture").change(function(){
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