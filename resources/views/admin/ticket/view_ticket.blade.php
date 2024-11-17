@extends('layouts.admin')
@section('admin_content')
 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>New Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ticket Reply</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <div class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-8">
                  <strong>User: {{ $ticket->name }}</strong><br>
                  <strong>Subject: {{ $ticket->subject }}</strong><br>
                  <strong>Service: {{ $ticket->service }}</strong><br>
                  <strong>Priority: {{ $ticket->priority }}</strong><br>
                  <strong>Message: {{ $ticket->message }}</strong>
              </div>
              <div class="col-md-4">
                <a href="{{ asset($ticket->image) }}" target="_blank"><img src="{{ asset($ticket->image) }}" style="height: 80px; width:120px; margin-top: 20px;"></a>
            </div>
          </div>     
      </div>
   </div><br>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       <form action="{{ route('admin.store.ticket') }}" method="post" enctype="multipart/form-data">
         @csrf
       	<div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Reply Ticket Message</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-lg-12">
                      <label for="exampleInputEmail1">Message <span class="text-danger">*</span> </label>
                      <textarea type="text" class="form-control" name="message" required=""></textarea>
                      <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    </div>
                    <div class="form-group col-lg-12">
                      <label for="exampleInputPassword1">Image <span class="text-danger">*</span> </label>
                      <input type="file" class="form-control" name="image">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <button type="submit" class="btn btn-info ml-2 mb-3">Reply Ticket</button>
            <a href="{{ route('admin.close.ticket', $ticket->id) }}" class="btn btn-danger" style="float:right;"> Close Ticket </a>
           </div>
            <!-- /.card -->

          <!-- right column -->
          <!-- All reply message show here -->
          @php
            $replies=DB::table('replies')->where('ticket_id',$ticket->id)->orderBy('id','DESC')->get();
          @endphp
          <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="card card-primary">
              <div class="card-header">
                  <h3 class="card-title">All Replies</h3>
              </div>
              <div class="card-body" style="height: 700px; overflow-y: scroll;">
              @isset($replies)
                @foreach($replies as $row)
                  <div class="card mt-1 @if($row->user_id==0) ml-4 @endif">
                  <div class="card-header @if($row->user_id==0) bg-info @else bg-danger @endif" style="color:white;">
                    <i class="fa fa-user" style="color:white;"></i> @if($row->user_id==0) Admin @else {{$ticket->name}} @endif
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
          <!-- /.card-body -->
      </div>
        <!-- /.card -->
    </div>  
  </div>
</form>
</div><!-- /.container-fluid -->
</section>
  <!-- /.content -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@endsection
