@extends('layouts.master')

@section('breadcrumb')
    <h2>Add form</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Add form</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-12">
			
			@include('includes.alert')

			<div id="app">
				<formindex route="{{ route('order-form.create') }}"></formindex>
				{{-- <router-view></router-view> --}}
				<!-- set progressbar -->
        		<vue-progress-bar></vue-progress-bar>
			</div>

		</div>

	</div>
@endsection
