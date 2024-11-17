@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
           @include('user.user_dashboard_sidebar')
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
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
                            <span class="badge badge-success">Order Done</span>
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
                <div class="card-body">
                   <h4>My Order</h4>
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
                             <td>{{ $setting->currency }} {{ $row->single_price }}</td>
                             <td>{{ $setting->currency }} {{ $row->subtotal_price }}</td>
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

@endsection
