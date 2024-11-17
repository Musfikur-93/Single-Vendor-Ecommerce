<form action="{{ route('coupon.update') }}" method="post" id="edit_form">
  @csrf
  <div class="modal-body">
      <div class="form-group">
        <label for="coupon_code">Coupon Code</label>
          <input type="text" class="form-control" name="coupon_code" value="{{ $data->coupon_code }}" required="">
          <input type="hidden" name="id" value="{{$data->id}}">
        <small id="emailHelp" class="form-text text-muted">This is your Coupons</small>
      </div>
      <div class="form-group">
        <label for="type">Coupon Type</label>
          <select class="form-control" name="type" required="">
              <option value="1" @if($data->type==1) selected @endif>Fixed</option>
              <option value="2" @if($data->type==2) selected @endif>Percentage</option>
          </select>
      </div>
      <div class="form-group">
        <label for="coupon_amount">Coupon Amount</label>
          <input type="text" class="form-control" name="coupon_amount" value="{{ $data->coupon_amount }}" required="">
      </div>
      <div class="form-group">
        <label for="valid_date">Coupon Valid Date</label>
          <input type="date" class="form-control" name="valid_date" value="{{ $data->valid_date }}" required="">
      </div>
      <div class="form-group">
        <label for="status">Coupon Status</label>
          <select class="form-control" name="status">
              <option value="Active" @if($data->status=="Active") selected @endif>Active</option>
              <option value="Inactive" @if($data->status=="Inactive") selected @endif>Inactive</option>
          </select>
      </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary"><span class="d-none loader"><i class="fas fa-spinner">loading..</i></span> <span class="submit_btn"> Update </span></button>
  </div>
</form>


<script type="text/javascript">
// coupon ajax call for loading cara update/edit
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
