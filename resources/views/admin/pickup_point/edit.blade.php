<form action="{{ route('pickup.point.update') }}" method="post" id="edit_form">
  @csrf
  <div class="modal-body">
      <div class="form-group">
        <label for="pickup_point_name">Pickup Point Name</label>
          <input type="text" class="form-control" name="pickup_point_name" value="{{ $data->pickup_point_name }}" required="">
          <input type="hidden" name="id" value="{{ $data->id }}">
        <small id="emailHelp" class="form-text text-muted">This is your PickupPoint</small>
      </div>
      <div class="form-group">
        <label for="pickup_point_address">Pickup Point Address</label>
          <input type="text" class="form-control" name="pickup_point_address" value="{{ $data->pickup_point_address }}" required="">
      </div>
      <div class="form-group">
        <label for="pickup_point_phone">Pickup Point Phone</label>
          <input type="text" class="form-control" name="pickup_point_phone" value="{{ $data->pickup_point_phone }}" required="">
      </div>
      <div class="form-group">
        <label for="pickup_point_phntwo">Pickup Point Photwo</label>
          <input type="text" class="form-control" name="pickup_point_phntwo" value="{{ $data->pickup_point_phntwo }}" required="">
      </div>

  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary"><span class="d-none loader"><i class="fas fa-spinner">loading..</i></span> <span class="submit_btn"> Submit </span></button>
  </div>
</form>

<script type="text/javascript">
// pickup point ajax call for loading cara insert
 $('#edit_form').submit(function(e){
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
         $('#edit_form')[0].reset();
         $('.loader').addClass('d-none');
         $('#editModal').modal('hide');
         table.ajax.reload();
     }
   });
 });
</script>
