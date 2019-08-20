@extends('layouts.master')

@section('breadcrumb')
    <h2>Edit Tag</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href=""><i class="fas fa-cogs"></i>  Tags Settings </a></li>
            <li><span> Edit Tag</span></li>
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
					<form class="p-3" action="{{ route('tag.update', $tag->slug) }}" method="post" >
						
						@csrf
						@method('PUT')

						<h4 class="mb-3">Edit tag {{ $tag->name }}</h4>
						<div class="form-group">

							<label for="tagName">Tag Name <span class="required">*</span></label>
							<input type="text" id="tagName" name="tagName" class="form-control {{ $errors->has('tagName') ? ' is-invalid' : '' }}" value="{{ $tag->name }}" required placeholder="Tag Name">

							@if ($errors->has('tagName'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('tagName') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group">

							<label for="tagNote">Tag Note </label>
							<textarea  id="tagNote" name="tagNote" class="form-control {{ $errors->has('tagNote') ? ' is-invalid' : '' }}" placeholder="Write note for the tag">{{ $tag->note }}</textarea>

							@if ($errors->has('tagNote'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('tagNote') }}</strong>
		                        </span>
		                    @endif

						</div>


						<br/>
						<button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary"><i class="fas fa-tags"></i> Save Changes</button>

						
					</form>
				</div>
			</section>

		</div>

	</div>
@endsection



@section('page-script')

@endsection