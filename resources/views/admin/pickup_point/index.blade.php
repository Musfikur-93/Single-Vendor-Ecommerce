<!-- page loading cara insert,delete & update -->
@extends('layouts.admin')

@section('admin_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pickup Point</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"> + Add New</button>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All Pickup Point List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped table-sm ytable">
              <thead>
              <tr>
                <th>SL</th>
                <th>Pickup Point Name</th>
                <th>Pickup Point Address</th>
                <th>Phone</th>
                <th>Another Phone</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
            <!-- sadhronoto delete kori amra form submit korar por, er jonno ai from ti hocce delete korar jonno. -->
            <form id="deleted_form" action="" method="post">
                @csrf @method('POST') <!-- 'get' diye delete korte hole method a post dite hobe.-->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<!-- Category insert Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New PickupPoint</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form action="{{ route('pickup.point.store') }}" method="post" id="add_form">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="pickup_point_name">Pickup Point Name</label>
              <input type="text" class="form-control" name="pickup_point_name" required="">
            <small id="emailHelp" class="form-text text-muted">This is your PickupPoint</small>
          </div>
          <div class="form-group">
            <label for="pickup_point_address">Pickup Point Address</label>
              <input type="text" class="form-control" name="pickup_point_address" required="">
          </div>
          <div class="form-group">
            <label for="pickup_point_phone">Pickup Point Phone</label>
              <input type="text" class="form-control" name="pickup_point_phone" required="">
          </div>
          <div class="form-group">
            <label for="pickup_point_phntwo">Pickup Point Photwo</label>
              <input type="text" class="form-control" name="pickup_point_phntwo" required="">
          </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><span class="d-none loader"><i class="fas fa-spinner">loading..</i></span> <span class="submit_btn"> Submit </span></button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- pickup point edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Pickup Point</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div id="modal_body">

    </div>
  </div>
</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- datatable script -->
<script type="text/javascript">
  $(function childcategory(){
      table=$('.ytable').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('pickuppoint.index') }}",
        columns:[
          {data:'DT_RowIndex', name:'DT_RowIndex'},
          {data:'pickup_point_name', name:'pickup_point_name'},
          {data:'pickup_point_address', name:'pickup_point_address'},
          {data:'pickup_point_phone', name:'pickup_point_phone'},
          {data:'pickup_point_phntwo', name:'pickup_point_phntwo'},

          {data:'action', name:'action', orderable:true, searchable:true},
        ]
      });
  });

// loading cara data delete korar javascript code.
$(document).ready(function(){
  $(document).on('click','#delete_coupon',function(e){
   	e.preventDefault();
   	var url = $(this).attr('href');
   	  $('#deleted_form').attr('action',url);
   	  swal({
   	      title: "Are you want to delete?",
   	      text: "Once Delete, This will be Permanently Delete!",
   	      icon: "warning",
   	      buttons: true,
   	      dangerMode: true,
   	})
   	.then((willDelete)=>{
   	  if(willDelete){
   	    $('#deleted_form').submit();
   	  }else{
   	    swal("Your imaginary file is safe!");
   	 }
      });
   });

   //data passed through here for delete
    $('#deleted_form').submit(function(e){
      e.preventDefault();
      var url = $(this).attr('action');
      var request = $(this).serialize();
      $.ajax({
        url:url,
        type:'get', // route a 'get' diye delete korte hole type a post er jaigai get dite hobe.
        async:false,
        data:request,
        success:function(data){
          toastr.success(data);
          $('#deleted_form')[0].reset();
            table.ajax.reload();
        }
      });
    });
});

// store coupon ajax call for loading cara insert
 $('#add_form').submit(function(e){
   e.preventDefault();
   $('.loader').removeClass('d-none');
   var url = $(this).attr('action');
   var request = $(this).serialize();
   $.ajax({
     url:url,
     type:'post',
     async:false,
     data:request,
     success:function(data){
       toastr.success(data);
         $('#add_form')[0].reset();
         $('.loader').addClass('d-none');
         $('#addModal').modal('hide');
         table.ajax.reload();
     }
   });
 });

  // Edit modal script loading cara edit
    $('body').on('click','.edit', function(){
      let id=$(this).data('id');
      $.get("pickup-point/edit/"+id, function(data){
        $("#modal_body").html(data);
      });
    });

</script>

@endsection
