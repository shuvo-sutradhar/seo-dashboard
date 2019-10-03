@extends('layouts.master')

@section('breadcrumb')
    <h2>Add Role</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{ route('account.index') }}"><i class="fas fa-cogs"></i>  Team Settings </a></li>
            <li><span>Add Role</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">

			<section class="card card-horizontal mb-4">

				@include('includes.alert')

	            <div class="card_header">
	                <h3 class="font-weight-semibold mt-3 dark">Add Role</h3>
	                <a href="{{ route('role.index') }}" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> Go back
	                </a>
	            </div>
				<div class="card-body">
					<form class="p-3" action="{{ route('role.store') }}" method="post" >
						

						@csrf

						<div class="form-group">

							<label for="name">Name <span class="required">*</span></label>
							<input type="text" id="name" name="name"  class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required placeholder="Manager">

							@if ($errors->has('name'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif

						</div>

						<div class="form-group assign-permission mt-5" style="background: #f9f9f9;padding: 0px 15px;box-shadow: 0px 1px 5px #0000002e;">

							<table class="table table-responsive-md mb-0">
								<thead>
									<tr>

										<th>Permission Name</th>
										<th class="text-right">Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($permissions as $key => $permission)
										<tr>
											<td>
												<label class="control-label text-lg-right pt-2">{{ $permission->name }}</label>
											</td>
											<td>
												<div class="switch switch-sm switch-primary switch-status">
													<input type="checkbox" name="permissions[]" data-plugin-ios-switch value="{{ $permission->id }}" checked />
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>						
						</div>
						<br/>

						<button type="submit" class="mb-1 mt-1 mr-1 btn btn-primary"><i class="fas fa-plus"></i> Add Role</button>
					</form>
				</div>
			</section>


		</div>

	</div>
@endsection


@section('page-script')
<script src="{{ asset('assets/vendor/ios7-switch/ios7-switch.js') }}"></script>
@endsection
