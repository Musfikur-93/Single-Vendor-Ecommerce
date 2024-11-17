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
          <h1 class="m-0">Campaing</h1>
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
            <h3 class="card-title">All Campaing List Here</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="" class="table table-bordered table-striped table-sm ytable">
              <thead>
              <tr>
                <th>Start Date</th>
                <th>Title</th>
                <th>Image</th>
                <th>Discount (%)</th>
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

<!-- Category insert Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New Campaing</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form action="{{ route('campaing.store') }}" method="post" id="add-form" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="Campaing-title">Campaing Title<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="title" required="">
            <small id="emailHelp" class="form-text text-muted">This is your Campaing</small>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="Start-date">Start Date</label>
                    <input type="date" class="form-control" name="start_date" required="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="End-date">End Date</label>
                    <input type="date" class="form-control" name="end_date" required="">
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="Status">Status<span class="text-danger">*</label>
                    <select class="form-control" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="Discount">Discount (%)<span class="text-danger">*</label>
                    <input type="number" class="form-control" name="discount" required="">
                     <small id="emailHelp" class="form-text text-danger">Discount Percentage are apply for all product selling price</small>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label for="Campain-Image">Campaing Image<span class="text-danger">*</span></label>
              <input type="file" class="dropify" data-height="140" id="input-file-now" name="image" required="">
            <small id="emailHelp" class="form-text text-muted">This is your Campaing Image</small>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><span class="d-none">loading....</span> Submit</button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- Category edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Campaing</h5>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

<script type="text/javascript">
    $('.dropify').dropify({
      message: {
        'default': 'Click Here',
        'replace': 'Drag and Drop to replace',
        'remove': 'Remove',
        'error': 'Opps, something wrong'
      }
    });
</script>
<!-- datatable script -->
<script type="text/javascript">
    $(function childcategory(){
        var table=$('.ytable').DataTable({
          processing:true,
          serverSide:true,
          ajax:"{{ route('campaing.index') }}",
          columns:[
            {data:'start_date', name:'start_date'},
            {data:'title', name:'title'},
            {data:'image', name:'image', render: function(data,type,full,meta,){
                return "<img src=\"" +data+ "\" height=\"30\" />";
            }},
            {data:'discount', name:'discount'},
            {data:'status', name:'status'},

            {data:'action', name:'action', orderable:true, searchable:true},
          ]
        });
    });

// edit modal script
$('body').on('click','.edit', function(){
  let id=$(this).data('id');
  $.get("campaing/edit/"+id, function(data){
    $("#modal_body").html(data);
  });
});

</script>

@endsection
