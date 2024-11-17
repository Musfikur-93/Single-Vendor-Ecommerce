@extends('layouts.admin')

@section('admin_content')

<!-- dropify css link for file uploaded design -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">All Orders</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          
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
            <h3 class="card-title">All Order List</h3>
          </div>
          <div class="row">
             <div class="form-group col-3">
                <label for="status">Status</label>
                <select class="form-control submitable" name="payment_type" id="payment_type">
                      <option value="">All</option>
                      <option value="Cash On Delivery">Cash On Delivery</option>
                      <option value="Aamarpay">Aamarpay</option>
                      <option value="Paypal">Paypal</option>
                </select>
              </div>
              <div class="form-group col-3">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control submitable_input">
              </div>
              <div class="form-group col-3">
                <label for="status">Status</label>
                <select class="form-control submitable" name="status" id="status">
                      <option value="0">Pending</option>
                      <option value="1">Received</option>
                      <option value="2">Shipped</option>
                      <option value="3">Completed</option>
                      <option value="4">Return</option>
                      <option value="5">Cancel</option>
                </select>
              </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="" class="table table-bordered table-striped table-sm ytable">
              <thead>
              <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Subtotal ({{ $setting->currency }})</th>
                <th>Total ({{ $setting->currency }})</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<!-- Order edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Order</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div id="modal_body">

    </div>
  </div>
</div>
</div>

<!-- Order view Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">View Order</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div id="view_modal_body">

    </div>
  </div>
</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- datatable script -->
<script type="text/javascript">
    $(function products(){
      table=$('.ytable').DataTable({
          // processing:true,
          // serverSide:true,
          // ajax:"{{ route('product.index') }}",
          processing: true,
          serverSide: true,
          searching: true,
          ajax:{
            url: "{{ route('admin.order.index') }}",
            data: function(e){
              e.status = $("#status").val();
              e.date = $("#date").val();
              e.payment_type = $("#payment_type").val();
            }
          },
          columns:[
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'c_name', name:'c_name'},
            {data:'c_phone', name:'c_phone'},
            {data:'c_email', name:'c_email'},
            {data:'subtotal', name:'subtotal'},
            {data:'total', name:'total'},
            {data:'payment_type', name:'payment_type'},
            {data:'date', name:'date'},
            {data:'status', name:'status'},

            {data:'action', name:'action', orderable:true, searchable:true},
          ]
        });
    });

   
    //order edit
    $('body').on('click','.edit', function(){
      var id=$(this).data('id');
      var url="{{ url('order/admin/edit') }}/"+id;
      $.ajax({
        url:url,
        type:'get',
        success:function(data){
          $("#modal_body").html(data);
        }
      });
    });

    //order view
    $('body').on('click','.view', function(){
      var id=$(this).data('id');
      var url="{{ url('order/admin/view') }}/"+id;
      $.ajax({
        url:url,
        type:'get',
        success:function(data){
          $("#view_modal_body").html(data);
        }
      });
    });

   
    //submitable class call for every change in filtering on product manage.
    $(document).on('change','.submitable',function(){
      $('.ytable').DataTable().ajax.reload();
    });

    //submitable_input class call for every change in filtering on product manage.
    $(document).on('blur','.submitable_input',function(){
      $('.ytable').DataTable().ajax.reload();
    });

</script>

@endsection
