<!-- page loading cara insert,delete & update -->
@extends('layouts.admin')

@section('admin_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Coupon</h1>
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
            <h3 class="card-title">All Coupon List Here</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped table-sm ytable">
              <thead>
              <tr>
                <th>SL</th>
                <th>Coupon Code</th>
                <th>Coupon Amount</th>
                <th>Coupon Date</th>
                <th>Coupon Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
            <!-- sadhronoto delete kori amra form submit korar por, er jonno ai from ti hocce delete korar jonno. -->
            <form id="deleted_form" action="" method="delete">
                @csrf @method('DELETE')
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
      <h5 class="modal-title" id="exampleModalLabel">Add New Coupon</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form action="{{ route('coupon.store') }}" method="post" id="add_form">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="coupon_code">Coupon Code</label>
              <input type="text" class="form-control" name="coupon_code" required="">
            <small id="emailHelp" class="form-text text-muted">This is your Coupons</small>
          </div>
          <div class="form-group">
            <label for="type">Coupon Type</label>
              <select class="form-control" name="type" required="">
                  <option value="1">Fixed</option>
                  <option value="2">Percentage</option>
              </select>
          </div>
          <div class="form-group">
            <label for="coupon_amount">Coupon Amount</label>
              <input type="text" class="form-control" name="coupon_amount" required="">
          </div>
          <div class="form-group">
            <label for="valid_date">Coupon Valid Date</label>
              <input type="date" class="form-control" name="valid_date" required="">
          </div>
          <div class="form-group">
            <label for="status">Coupon Status</label>
              <select class="form-control" name="status">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><span class="d-none loader"><i class="fas fa-spinner">loading..</i></span> <span class="submit_btn"> Submit </span></button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- Category edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Coupon</h5>
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
        ajax:"{{ route('coupon.index') }}",
        columns:[
          {data:'DT_RowIndex', name:'DT_RowIndex'},
          {data:'coupon_code', name:'coupon_code'},
          {data:'coupon_amount', name:'coupon_amount'},
          {data:'valid_date', name:'valid_date'},
          {data:'status', name:'status'},

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
        type:'post',
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
      $.get("coupon/edit/"+id, function(data){
        $("#modal_body").html(data);
      });
    });

</script>

@endsection