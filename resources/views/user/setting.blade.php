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
                    <a href="{{ route('review.write') }}" style="float:right;"><i class="fas fa-pencil-alt"></i> Write a review</a>
                </div>

                <div class="card-body">
                   <h4>Your Default Shipping Credentials</h4><br>
                   <div>
                       <form action="{{ route('store.website.review') }}" method="post">
                       	@csrf
						  <div class="form-group">
						    <label for="name">Shipping Name</label>
						    <input type="text" class="form-control" name="shipping_name" value=""  placeholder="Enter Name">
						  </div>
						  <div class="row">
							  	<div class="form-group col-lg-6">
							    <label for="name">Shipping Phone</label>
							    <input type="text" class="form-control" name="shipping_phone" value=""  placeholder="Enter Phone">
							  </div>
							  <div class="form-group col-lg-6">
							    <label for="name">Shipping Email</label>
							    <input type="text" class="form-control" name="shipping_email" value=""  placeholder="Enter Email">
							  </div>
						  </div>
						  <div class="form-group">
						    <label for="name">Shipping Address</label>
						    <input type="text" class="form-control" name="shipping_address" value=""  placeholder="Enter Address">
						  </div>
						  <div class="row">
							  	<div class="form-group col-lg-4">
							    <label for="name">Shipping Country</label>
							    <input type="text" class="form-control" name="shipping_country" value=""  placeholder="Enter Country">
							  </div>
							  <div class="form-group col-lg-4">
							    <label for="name">Shipping City</label>
							    <input type="text" class="form-control" name="shipping_city" value=""  placeholder="Enter City">
							  </div>
							  <div class="form-group col-lg-4">
							    <label for="name">Shipping ZipCode</label>
							    <input type="text" class="form-control" name="shipping_zipcode" value=""  placeholder="Enter ZipCode">
							  </div>
						  </div>

						  	<button type="submit" class="btn btn-primary col-md-12">Submit</button>
						</form>
                   </div>
                </div>

                <div class="card-body">
                   <h4>Change Your Password</h4><br>
                   <div>
                       <form action="{{ route('customer.password.change') }}" method="post">
                       	@csrf
						  <div class="form-group">
						    <label for="name">Old Password</label>
						    <input type="password" class="form-control" name="old_password" required=""  placeholder="Enter Old Password">
						  </div>
						  
						  <div class="form-group">
						    <label for="name">New Password</label>
						    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required=""  placeholder="Enter New Password">
						     @error('password')
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $message }}</strong>
		                        </span>
		                      @enderror
						  </div>
						  <div class="form-group">
						    <label for="name">Confirm Password</label>
						    <input type="password" class="form-control" name="password_confirmation" required=""  placeholder="Enter Confirm Password">
						  </div>

						   <button type="submit" class="btn btn-primary col-md-12">Change Password</button>
						</form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div><hr>

@endsection
