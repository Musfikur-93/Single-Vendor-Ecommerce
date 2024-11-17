@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_responsive.css">
@include('layouts.frontend_partial.collaps_nav')

	<!-- Cart -->
	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="cart_container card p-1">
					  <div class="cart_title text-center">Billing Address</div>
							<form action="{{ route('order.place') }}" method="post" id="order-place">
								@csrf
							  <div class="row p-4">
								<div class="form-group col-lg-6">
									<label>Customer Name <span class="text-danger">*</span> </label>
									<input type="text" class="form-control" value="{{ Auth::user()->name }}" name="c_name" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Customer Phone <span class="text-danger">*</span></label>
									<input type="text" class="form-control"  value="{{ Auth::user()->phone }}" name="c_phone" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Country <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="c_country" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Shipping Address <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="c_address" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Email</label>
									<input type="text" class="form-control" name="c_email">
								</div>
								<div class="form-group col-lg-6">
									<label>Zip Code</label>
									<input type="text" class="form-control" name="c_zipcode">
								</div>
								<div class="form-group col-lg-6">
									<label>City Name</label>
									<input type="text" class="form-control" name="c_city" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Extra Phone</label>
									<input type="text" class="form-control" name="c_extra_phone" required>
								</div>
							</div>
							<div class="text-center p-2"><strong>Payment Type</strong></div>
							<div class="row ml-4">
								<div class="form-group col-lg-4">
									<label>Paypal</label>
									<input type="radio" class="form-control" value="paypal" name="payment_type" style="margin-left: -85px;">
								</div>
								<div class="form-group col-lg-4">
									<label>Bkash/Nagad/Rocket/Upay</label>
									<input type="radio" class="form-control" value="aamarpay" name="payment_type" checked style="margin-left: -25px;">
								</div>
								<div class="form-group col-lg-4">
									<label>Cash on Delivery</label>
									<input type="radio" class="form-control" value="cash on delivery" name="payment_type" style="margin-left: -65px;">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info p-2">Order Place</button>
								</div>
							</div>
							   <span class="visually-hidden pl-2 d-none progress">Progressing.....</span>
						 </form>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="card">
						<div class="pl-4 pt-2">
							<p style="color: black;">Subtotal: <span style="float: right; padding-right: 5px;">{{ Cart::subtotal() }} {{ $setting->currency }}</span> </p>

							{{-- coupon apply --}}
							@if(Session::has('coupon'))
								<p style="color: black;">Coupon: <span style="padding: 10px;">{{ Session::get('coupon')['name'] }}</span><a href="{{ route('remove.coupon') }}" class="text-danger">(remove)</a> <span style="float: right; padding-right: 5px;">{{ Session::get('coupon')['discount'] }}</span></p>
							@else
							@endif

							<p style="color: black;">Tax: <span style="float: right; padding-right: 5px;">0.00 %</span></p>
							<p style="color: black;">Shipping: <span style="float: right; padding-right: 5px;">0.00 {{ $setting->currency }}</span></p>

							@if(Session::has('coupon'))
								<p style="color: black;"><b> Total: <span style="float: right; padding-right: 5px;"> {{ Session::get('coupon')['after_discount'] }} {{ $setting->currency }} </span></b></p>
							@else
								<p style="color: black;"><b> Total: <span style="float: right; padding-right: 5px;"> {{ Cart::total() }} {{ $setting->currency }} </span></b></p>
							@endif
						</div><hr>
						@if(!Session::has('coupon'))
						<form action="{{ route('apply.coupon') }}" method="post">
							@csrf
							<div class="p-4">
								<div class="form-group">
									<label>Coupon Apply</label>
									<input type="text" class="form-control" name="coupon" required placeholder="Coupon Apply" autocomplete="off">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info">Apply Coupon</button>
								</div>
							</div>
						</form>
						@endif
					</div>
					<div class="cart_buttons">
						<a href="{{ route('checkout') }}" class="button cart_button_checkout">Payment Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript">

		// remove product to cart ajax call for loading cara
		$('body').on('click','#removeproduct', function(){
		  let id=$(this).data('id');
		  // $.get("brand/edit/"+id, function(data){
		  //   $("#modal_body").html(data);
		  //});
			$.ajax({
		     url:"{{ url('cartproduct/remove/') }}/"+id,
		     type:'get',
		     async:false,
		     success:function(data){
		       toastr.success(data); 
		       location.reload();
		     }
		   });
		});

		// qunatity update to cart ajax call 
		$('body').on('blur','.qty', function(){
		  let qty=$(this).val();
		  let rowId=$(this).data('id');
			$.ajax({
		     url:"{{ url('cartproduct/updateqty/') }}/"+rowId+'/'+qty,
		     type:'get',
		     async:false,
		     success:function(data){
		       toastr.success(data); 
		       location.reload();
		     }
		   });
		});

		// color update to cart ajax call 
		$('body').on('change','.color', function(){
		  let color=$(this).val();
		  let rowId=$(this).data('id');
			$.ajax({
		     url:"{{ url('cartproduct/updatecolor/') }}/"+rowId+'/'+color,
		     type:'get',
		     async:false,
		     success:function(data){
		       toastr.success(data); 
		       location.reload();
		     }
		   });
		});

		// size update to cart ajax call 
		$('body').on('change','.size', function(){
		  let size=$(this).val();
		  let rowId=$(this).data('id');
			$.ajax({
		     url:"{{ url('cartproduct/updatesize/') }}/"+rowId+'/'+size,
		     type:'get',
		     async:false,
		     success:function(data){
		       toastr.success(data); 
		       location.reload();
		     }
		   });
		});
	</script>

@endsection 
