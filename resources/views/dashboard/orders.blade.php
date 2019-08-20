@extends('layouts.master')

@section('page-style')
<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
<script>
	tinymce.init({ 

		selector: '#message-editor',
		toolbar: 'bold italic underline strikethrough  justifyleft justifycenter justifyright justifyfull | ', 
		menubar: false,

	});
</script>
@endsection

@section('breadcrumb')
    <h2>Order Details</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><a href="{{ route('home') }}">Orders</a></li>
            <li><span>Order number</span></li>
        </ol>
		<a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
    </div>
@endsection

@section('page-content')
	<div class="row">
		
		<div class="col-lg-12 col-xl-12">
			
			@include('includes.alert')
			
			<div class="row">
				
				<ul>
					@foreach ($orders as $key => $order)
						<li>
							<a href="{{ route('order.single', $order->order_number) }}">
								{{ $order->order_number }} 
							</a><br/>
						</li>
						
					@endforeach
				</ul>

			</div>

		</div>

	</div>

@endsection



@section('page-script')
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>



<script type="text/javascript">
	


	$(document).ready(function(){
	    var maxField = 2; //Input fields increment limitation
	    var editNote = $('.edit-note'); //Add button selector
	    var wrapper = $('.editor'); //Input field wrapper
	    var x = 1; //Initial field counter is 1
	    
	    //Once add button is clicked
	    $(editNote).click(function(){
	        //Check maximum number of input fields
	        if(x < maxField){ 
	            //$(wrapper).append(fieldHTML); //Add field html
	            var div = document.getElementById('note-editor');
	            div.insertAdjacentHTML('beforeend', '<div id="remove-note-editor"><textarea name="orderNote" id="editor" class="form"><h3>Here goes the initial content of the editor.</h3></textarea><button type="sumit" class="mb-1 mt-1 mr-1 btn btn-primary  btn-sm">Save Change</button><a class="mb-1 mt-1 mr-1 btn btn-danger btn-sm cancele-note" href="">Cancel</a></div>');
	            ClassicEditor
				    .create( document.querySelector( '#editor' ),{
				    	
						toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedlist', 'numberedlist', 'blockquote', '|', 'undo', 'redo' ]
				    } )
				    .then( editor => {
				        console.log( editor );
				    } )
				    .catch( error => {
				        console.error( error );
				    } );

	            x++; //Increment field counter

	        }
	    });
	    
	    //Once remove button is clicked
	    $(wrapper).on('click', '.cancele-note', function(e){
	        e.preventDefault();
	        var pDiv =  document.getElementById("remove-note-editor");
	        pDiv.remove(); //Remove field html
	        x--; //Decrement field counter
	    });
	});



	

</script>
@endsection