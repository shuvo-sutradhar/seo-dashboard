
@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong><i class="fa fa-fw fa-check"></i> Well done!</strong> {{ $message }}! 
	</div>
@endif


@if ($message = Session::get('error'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong><i class="fa fa-fw fa-check"></i> Oh snap!</strong> {{ $message }}! 
	</div>
@endif


@if ($message = Session::get('warning'))
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong><i class="fa fa-fw fa-check"></i> Oh snap!</strong> {{ $message }}! 
	</div>
@endif


@if ($message = Session::get('info'))
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong><i class="fa fa-fw fa-check"></i> Oh snap!</strong> {{ $message }}! 
	</div>
@endif

@if ($message = Session::get('cartInfo'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong><i class="fas fa-shopping-basket"></i> Well done!</strong> {{ $message }}! 
		<a class="class btn btn-default view-cart btn-xs float-right" href="{{ route('cart.index') }}"> View Cart </a>
	</div>
@endif



