@extends('layouts.master')

@section('page-style')

	<link rel="stylesheet" href="{{ asset('assets/css/messanger.css') }}">

@endsection

@section('breadcrumb')
    <h2>Add form</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Chat room</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-12">
			
			@include('includes.alert')

			<div id="app">
				<message :user="{{ Auth::user() }}"></message>
				<!-- set progressbar -->
        		<vue-progress-bar></vue-progress-bar>
			</div>

		</div>

	</div>
@endsection



@section('page-script')

<script>

	$(document).ready(function(){
		$('#action_menu_btn').click(function(){
			$('.action_menu').toggle();
		});
	});

</script>
@endsection