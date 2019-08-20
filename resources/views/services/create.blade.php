@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" />
@endsection

@section('breadcrumb')
    <h2>Add Service</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{ route('service.index') }}"><i class="fas fa-cogs"></i>  Services </a></li>
            <li><span>Add Service</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">

			<section class="card card-horizontal mb-4">
				<div class="card-body">
					<form class="p-3" action="{{ route('service.store') }}" method="post" enctype="multipart/form-data">
						
						@csrf

						<h4 class="mb-3">Add new service</h4>
						<div class="form-group">

							<label for="serviceName">Service Name <span class="required">*</span></label>
							<input type="text" id="serviceName" name="serviceName"  class="form-control {{ $errors->has('serviceName') ? ' is-invalid' : '' }}" required placeholder="Name of the service" value="{{ old('serviceName') }}">

							@if ($errors->has('serviceName'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('serviceName') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="description">Description </label>
							<textarea id="description" name="description"  class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Description for the service" rows="3">{{ old('description') }}</textarea>

							@if ($errors->has('description'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('description') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="price">Price <span class="required">*</span></label>
							
							<div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text">
										<i class="fas fa-dollar-sign"></i>
									</span>
								</span>

								<input type="number" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="Service Price" required value="{{ old('price') }}" step="" min="0" name="price">

								@if ($errors->has('price'))
			                        <span class="invalid-feedback" role="alert">
			                            <strong>{{ $errors->first('price') }}</strong>
			                        </span>
			                    @endif

							</div>

							
						</div>

						<div class="form-group">

							<label for="serviceThumbnail">Service Thumbnail</label>
							<input type="file"  name="serviceThumbnail"  class="form-control {{ $errors->has('serviceThumbnail') ? ' is-invalid' : '' }}"  id="serviceThumbnail">
								
							@if ($errors->has('serviceThumbnail'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('serviceThumbnail') }}</strong>
		                        </span>
		                    @endif


		                    <div class="profilePic-preview">
		                    	<img src="{{ asset('/uploads/service_pic/') }}/default.png" alt="Profile Picture" id="preview-image">
		                    </div>

						</div>
						<h4 class="mb-3">Service variants</h4>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="variantName">Variant Name</label>
									<input type="text" class="form-control" placeholder="Service Varient (e.g. Size, Color, Number of links, Word count)" name="variantName[]" value="{{ old('variantName') }}">

									{{-- @if ($errors->has('variantName[]'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('variantName[]') }}</strong>
				                        </span>
				                    @endif --}}
								</div>

								<div class="col-md-6">
									<label for="variantValues[]">Variant Values</label>
									
									<select id="tags-input-multiple" multiple data-role="tagsinput" data-tag-class="badge badge-primary" name="variantValues[0][]">
										<option value="Small">Small</option>
										<option value="Large">Large</option>
									</select>

									{{-- @if ($errors->has('variantValues[]'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('variantValues[]') }}</strong>
				                        </span>
				                    @endif --}}
								</div>
							</div>

						</div>

						<a href="javascript:void(0);" class="add_variant float-right" title="Add variants">
							<i class="fas fa-plus"></i> Add variants
						</a>

						<div class="variant_wrapper form-group" id="content">
						</div>
						
						<div class="form-group">
							<div class="checkbox-custom checkbox-primary">
								<input type="checkbox" checked="" id="showinServicePage" value="1" name="showinServicePage">
								<label for="showinServicePage">Show in services page</label>
							</div>
						</div>

						<div class="form-group">
							<div class="checkbox-custom checkbox-primary">
								<input type="checkbox"  id="deadline" value="1" name="deadline" onclick="addDeadline();">
								<label for="deadline">Set a deadline</label>
							</div>
						</div>

						<div class="form-group" id="deadline-html">
						</div>

						<div class="form-group">
							<div class="checkbox-custom checkbox-primary">
								<input type="checkbox" checked="" id="serviceRequirments" name="serviceRequirments" value="1">
								<label for="serviceRequirments">Required service requirments</label>
							</div>
						</div>

						<br/>

						<button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary"><i class="fab fa-searchengin"></i> Add Service</button>

						
					</form>
				</div>
			</section>
		</div>
	</div>
@endsection


@section('page-script')
	<script src="{{ asset('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
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
	    
	    $("#serviceThumbnail").change(function(){
	        readURL(this);
	    });
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
		    var maxField = 10; //Input fields increment limitation
		    var addVariant = $('.add_variant'); //Add button selector
		    var wrapper = $('.variant_wrapper'); //Input field wrapper
		    var x = 1; //Initial field counter is 1
		    
		    //Once add button is clicked
		    $(addVariant).click(function(){
		        //Check maximum number of input fields
		        if(x < maxField){ 
		            

		            //$(wrapper).append(fieldHTML); //Add field html
		            var div = document.getElementById('content');
		            div.insertAdjacentHTML('beforeend', '<div class="row" id="remove"><div class="col-md-6"><label for="variantName">Variant Name</label><input type="text" class="form-control" placeholder="Service Varient (e.g. Size, Color, Number of links, Word count)" name="variantName[]" required></div><div class="col-md-6"><label for="variantValues[]">Variant Values</label><select id="tags-input-multiple" multiple data-role="tagsinput" data-tag-class="badge badge-primary" name="variantValues['+x+'][]" required><option value="Small" >Small</option><option value="Large">Large</option></select></div><div class="removebtn"><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times"></i> Remove variant</a></div></div>');
		            $("select[multiple][data-role=tagsinput]").tagsinput();

		            x++; //Increment field counter

		        }
		    });
		    
		    //Once remove button is clicked
		    $(wrapper).on('click', '.remove_button', function(e){
		        e.preventDefault();

		        var pDiv =  document.getElementById("remove");
		        pDiv.remove(); //Remove field html
		        x--; //Decrement field counter
		    });
		});
	</script>

	<script type="text/javascript">
		function addDeadline()
		{
			
			var deadlineHtml = '<div class="row" id="remove-deadline"><div class="col-md-8"><label for="variantName">Number of Hours / Days</label><input type="number" min="0" class="form-control " placeholder="Number of days of hours include in the deadline" name="numOfDeadline" required></div><div class="col-md-4"><label for="deadlineType">Select Hours/Days</label><select id="deadlineType" class="form-control"  name="deadlineType" required><option value="">Select a option</option><option value="Hours">Hours</option><option value="Days">Days</option></select></div></div>';

			if (document.getElementById('deadline').checked) 
			{
			    var div = document.getElementById('deadline-html');
		        div.insertAdjacentHTML('beforeend', deadlineHtml);  

			}
			else
			{
				
				var div = document.getElementById('remove-deadline');
				div.remove();
			}
		}
	</script>
@endsection