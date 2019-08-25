@extends('layouts.master')

@section('breadcrumb')
    <h2>Invoices</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>All Invoices</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-12">
			
			@include('includes.alert')

			<div id="app">
				<invoice></invoice>
				<!-- set progressbar -->
        		<vue-progress-bar></vue-progress-bar>
			</div>

		</div>

	</div>
@endsection