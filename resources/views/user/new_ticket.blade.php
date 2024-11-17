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
                   <h4>Submit your ticket we will reply</h4><br>
                   <div>
                       <form action="{{ route('store.ticket') }}" method="post" enctype="multipart/form-data">
                       	@csrf
						  <div class="form-group">
						    <label for="subject">Subject</label>
						    <input type="text" class="form-control" name="subject" required="" placeholder="Enter Subject">
						  </div>
						  <div class="row">
						  		<div class="form-group col-6">
								    <label for="priority">Priority</label>
								    <select class="form-control" name="priority" style="min-width: 220px;">
								    	<option value="low">Low</option>
								    	<option value="medium">Medium</option>
								    	<option value="high">High</option>
								    </select> 
							  </div>
							  <div class="form-group col-6">
								    <label for="service">Service</label>
								    <select class="form-control" name="service" required="" style="min-width: 220px;">
								    	<option value="technical">Technical</option>
								    	<option value="payment">Payment</option>
								    	<option value="affiliate">Affiliate</option>
								    	<option value="return">Return</option>
								    	<option value="refund">Refund</option>
								    </select> 
							  </div>

						  </div>
						  <div class="form-group">
						  	<label for="message">Message</label><br>
						  	<textarea class="form-control" name="message" required placeholder="Write your message here"></textarea>
						  </div>
						  <div class="form-group">
						  	<label for="image">Image</label><br>
						  	<input type="file" name="image" class="form-control">
						  </div>
						  	<button type="submit" class="btn btn-primary">Submit Ticket</button>
						</form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div><hr>

@endsection
