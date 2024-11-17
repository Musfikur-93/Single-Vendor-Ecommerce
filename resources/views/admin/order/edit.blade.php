<form action="{{ route('order.status.update') }}" method="post" id="edit_form">
  @csrf
  <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
          <input type="text" class="form-control" name="c_name" value="{{ $order->c_name }}" required="">
          <input type="hidden" name="id" value="{{ $order->id }}">
      </div>
      <div class="form-group">
        <label for="address">Address</label>
          <input type="text" class="form-control" name="c_address" value="{{ $order->c_address }}" required="">
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
          <input type="text" class="form-control" name="c_phone" value="{{ $order->c_phone }}" required="">
      </div>
      <div class="form-group">
        <label for="address">Email</label>
          <input type="text" class="form-control" name="c_email" value="{{ $order->c_email }}" required="">
      </div>
      <div class="form-group">
        <label for="status">Status</label>
          <select class="form-control" name="status">
            <option value="0" @if($order->status==0) selected @endif>Pending</option>
            <option value="1" @if($order->status==1) selected @endif>Received</option>
            <option value="2" @if($order->status==2) selected @endif>Shipped</option>
            <option value="3" @if($order->status==3) selected @endif>Completed</option>
            <option value="4" @if($order->status==4) selected @endif>Return</option>
            <option value="5" @if($order->status==5) selected @endif>Cancel</option>
         </select>
      </div>

  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary"><span class="d-none loader"><i class="fas fa-spinner">loading..</i></span> <span class="submit_btn"> Update </span></button>
  </div>
</form>

<script type="text/javascript">

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
