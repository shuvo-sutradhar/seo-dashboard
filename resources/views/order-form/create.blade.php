@extends('layouts.master')

@section('page-style')

	<style type="text/css">
		.form-top {
		    display: flex;
		    justify-content: space-between;
		    align-items: center;
		    background: #08c;
		    padding: 10px;
		    border-radius: 5px;
		    margin-bottom: 20px;
		}

		.form-top h4{
			color: #fff;
		}
	</style>


@endsection

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
			
			<section class="mb-4">
				<div id="app">
				
					<formbuilder></formbuilder>
					<!-- set progressbar -->
	        		<vue-progress-bar></vue-progress-bar>
				</div>
			</section>
			
		</div>

	</div>

@endsection



@section('page-script')
	
	<script type="text/javascript">
		$(window).on('scroll', function() {
	        if ($(window).scrollTop() > 300) {
	            $('.sticky-area').addClass('sticky-div');
	        } else {
	            $('.sticky-area').removeClass('sticky-div');
	        }
	    });
	</script>

@endsection