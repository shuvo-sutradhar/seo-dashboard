@extends('layouts.master')

@section('page-style')

	<style type="text/css">
		img.profile-img{
			width: 100%;
		}
	</style>

@endsection

@section('breadcrumb')
    <h2>Clients</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Clients</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
		<div id="app">
			<clients-show></clients-show>
		</div>

@endsection

