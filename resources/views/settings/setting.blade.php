@extends('layouts.master')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
<style type="text/css">
	.card-body-wrap{
		background: transparent;;
		border-right: 1px solid #ddd;
		border-left: 1px solid #ddd;
	}
	a.single-card {
	    display: block;
	    background: #fff;
	    overflow: hidden;
	    padding: 0px 15px;
	    text-decoration: none !important;
	    transition: .5s;
	    height: 145px;
	}
	a.single-card:hover {
		box-shadow: 1px 2px 3px #ddd;
    	transform: scale(1.02);
	}
</style>
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

			<section class="card mb-2">
				<div class="card-header" style="background: transparent;">
					<h3 class="font-weight-semibold dark">Settings</h3>
				</div>	
				<div class="card-body card-body-wrap" style="background: transparent;">
					<div class="row">
						@if(auth()->user()->isAdmin() || auth()->user()->can('company-setting'))
						<div class="col-md-4 mb-4">
							<a href="{{ route('settings.general') }}" class="single-card">
								<h2>General settings</h2>
								<p>Set your brand name and colors, upload your logo, connect your domain.</p>
							</a>
						</div><!-- /. single card -->
						@endif
						@if(auth()->user()->isAdmin() || auth()->user()->can('team'))
						<div class="col-md-4 mb-4">
							<a href="{{ route('account.index') }}" class="single-card">
								<h2>Team</h2>
								<p>Add team member & invite your team.</p>
							</a>
						</div><!-- /. single card -->
						@endif
						@if(auth()->user()->isAdmin() || auth()->user()->can('role-permission'))
						<div class="col-md-4 mb-4">
							<a href="{{ route('role.index') }}" class="single-card">
								<h2>Role & Permissions</h2>
								<p>Create and assign roles, update permissions.</p>
							</a>
						</div><!-- /. single card -->
						@endif
						@if(auth()->user()->isAdmin() || auth()->user()->can('tag'))
						<div class="col-md-4 mb-4">
							<a href="{{route('tag.index')}}" class="single-card">
								<h2>Tags</h2>
								<p>Add or delete order tags to help organize orders internally.</p>
							</a>
						</div><!-- /. single card -->
						@endif
						@if(auth()->user()->isAdmin() || auth()->user()->can('payment-setting'))
						<div class="col-md-4 mb-4">
							<a href="#" class="single-card">
								<h2>Payment Settings</h2>
								<p>Add or delete order tags to help organize orders internally.</p>
							</a>
						</div><!-- /. single card -->
						@endif
						@if(auth()->user()->isAdmin() || auth()->user()->can('system-log'))
						<div class="col-md-4 mb-4">
							<a href="{{ route('log.index') }}" class="single-card">
								<h2>Symtem Logs</h2>
								<p>View event and payment logs.</p>
							</a>
						</div><!-- /. single card -->
						@endif
					</div>
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