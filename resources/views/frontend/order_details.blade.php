@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_responsive.css">
@include('layouts.frontend_partial.collaps_nav')

	<!-- Home -->
	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('public/frontend') }}/images/shop_background.jpg"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">Order Tracking</h2>
		</div>
	</div>

	<!-- Shop -->
	<div class="shop">
		<div class="container">
    		<div class="row justify-content-center">
	        <div class="col-md-4">
	       		<div class="card">
	       			<div class="card-header">
	                    <h4>Order Info</h4>
	                </div>
	       			<div class="card-body">
	                	<span><strong>Name:</strong> {{ $order->c_name }}</span><br>
	                	<span><strong>Phone:</strong> {{ $order->c_phone }}</span><br>
	                	<span><strong>OrderId:</strong> {{ $order->order_id }}</span><br>
	                	<span>
	                		<strong>Status:</strong> @if($order->status==0)
	                            <span class="badge badge-danger">Order Pending</span>
	                        @elseif($order->status==1)
	                            <span class="badge badge-info">Order Received</span>
	                        @elseif($order->status==2)
	                            <span class="badge badge-primary">Order Shipped</span>
	                        @elseif($order->status==3)
	                            <span class="badge badge-success">Order Completed</span>
	                        @elseif($order->status==4)
	                            <span class="badge badge-warning">Order Return</span>
	                        @elseif($order->status==5)
	                            <span class="badge badge-danger">Order Cancel</span>
	                        @endif
	          	      </span><br>
	                	<span><strong>Payment Type:</strong> {{ $order->payment_type }}</span><br>
	                	<span><strong>Date:</strong> {{ date('d F Y', strtotime($order->date))}}</span><br>
	                	<span><strong>Subtotal:</strong> {{ $order->subtotal }}</span><br>
	                	<span><strong>Total:</strong> {{ $order->total }}</span>
	                </div>
	       		</div>
	        </div>
	        <div class="col-md-8">
	            <div class="card">
	                <div class="card-header">
	                    <h4>My Order</h4>
	                </div>
	                <div class="card-body">
	                   <div>
	                       <table class="table">
	                         <thead>
	                           <tr>
	                             <th scope="col">SL</th>
	                             <th scope="col">Product</th>
	                             <th scope="col">Color</th>
	                             <th scope="col">Size</th>
	                             <th scope="col">Qty</th>
	                             <th scope="col">Price</th>
	                             <th scope="col">Subtotal</th>
	                           </tr>
	                         </thead>
	                         <tbody>
	                          @foreach($order_details as $key=>$row)
	                           <tr>
	                             <th scope="row">{{ ++$key }}</th>
	                             <td>{{ $row->product_name }}</td>
	                             <td>
	                             	@if($row->color==NULL)
	  								  <span>Not Set</span>
	  								@else
	  								   <span>{{$row->color}}</span>
	  								@endif
	                               </td>
	                               <td>
	                               	@if($row->size==NULL)
	  									<span>Not Set</span>
	  								@else
	  									<span>{{$row->size}}</span>
	  								@endif
	                             </td>
	                             <td>{{ $row->quantity }}</td>
	                             <td>{{ $row->single_price }} {{ $setting->currency }}</td>
	                             <td>{{ $row->subtotal_price }} {{ $setting->currency }}</td>
	                           </tr>
	                           @endforeach
	                         </tbody>
	                       </table>
	                   </div>
	                </div>
	            </div>
	        </div>
	    </div>
	 </div><hr>
	</div>
  </div>
</div>

@endsection