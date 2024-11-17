@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
           @include('user.user_dashboard_sidebar')
        </div>
        <div class="col-md-8">
        	<div class="card p-2">
        		<div class="card-header">
                    <h4>Your Ticket Details</h4>
                 </div>
        		<div class="row">
    			  <div class="card-body col-md-9">
    				<strong>Subject: {{ $showticket->subject }}</strong><br>
	        		<strong>Service: {{ $showticket->service }}</strong><br>
	        		<strong>Priority: {{ $showticket->priority }}</strong><br>
	        		<strong>Message: {{ $showticket->message }}</strong>
    			  </div>
    			  <div class="col-md-3">
    			  		<a href="{{ asset($showticket->image) }}" target="_blank"><img src="{{ asset($showticket->image) }}" style="height: 80px; width:120px; margin-top: 20px;"></a>
    			  </div>
    			</div>
        	</div>

        	<!-- All reply message show here -->
        	@php
        		$replies=DB::table('replies')->where('ticket_id',$showticket->id)->orderBy('id','DESC')->get();
        	@endphp

        	<div class="card mt-2">
        		<div class="card-header">
                    <h4>All Reply Message</h4>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: scroll;">
                	@isset($replies)
                	  @foreach($replies as $row)
                	<div class="card mt-1 @if($row->user_id==0) ml-4 @endif">
					  <div class="card-header @if($row->user_id==0) bg-info @else bg-danger @endif" style="color:white;">
					    <i class="fa fa-user" style="color:white;"></i> @if($row->user_id==0) Admin @else {{Auth::user()->name}} @endif
					  </div>
					  <div class="card-body">
					    <blockquote class="blockquote mb-0">
					      <p>{{ $row->message }}</p>
					      <footer class="blockquote-footer">{{ date('d F Y'), strtotime($row->reply_date) }}</footer>
					    </blockquote>
					  </div>
					</div>
					  @endforeach
					@endisset
                </div>
        	</div>

            <div class="card mt-2">
                <div class="card-header">
                    Reply Message
                </div>

                <div class="card-body">
                   <div>
                       <form action="{{ route('reply.ticket') }}" method="post" enctype="multipart/form-data">
                       	@csrf
						  <div class="form-group">
						  	<label for="message">Message</label><br>
						  	<textarea class="form-control" name="message" required placeholder="Write your message here"></textarea>
						  	<input type="hidden" name="ticket_id" value="{{ $showticket->id }}">
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
