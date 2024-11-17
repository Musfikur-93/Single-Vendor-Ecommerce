
<form action="{{ route('campaing.update') }}" method="post" id="add-form" enctype="multipart/form-data">
  @csrf
  <div class="modal-body">
      <div class="form-group">
        <label for="brand-name">Campaing Title</label>
          <input type="text" class="form-control" name="title" value="{{ $data->title }}" required="">
        <small id="emailHelp" class="form-text text-muted">This is your Campaing title</small>
      </div>
      <input type="hidden" name="id" value="{{ $data->id }}">
       <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="Start-date">Start Date</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $data->start_date }}" required="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="End-date">End Date</label>
                    <input type="date" class="form-control" name="end_date" value="{{ $data->end_date }}" required="">
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="Status">Status<span class="text-danger">*</label>
                    <select class="form-control" name="status">
                        <option value="1" @if($data->status==1) selected="" @endif>Active</option>
                        <option value="0" @if($data->status==0) selected="" @endif>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="Discount">Discount (%)<span class="text-danger">*</label>
                    <input type="number" class="form-control" name="discount" value="{{ $data->discount }}" required="">
                     <small id="emailHelp" class="form-text text-danger">Discount Percentage are apply for all product selling price</small>
                </div>
            </div>
          </div>
      <div class="form-group">
        <label for="brand-logo">Campaing Image</label>
          <input type="file" class="dropify" data-height="140" id="input-file-now" name="image">
        <small id="emailHelp" class="form-text text-muted">This is your Campaing Image</small>
        <input type="hidden" name="old_image" value="{{ $data->image }}">
      </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary"><span class="d-none">loading....</span> Update</button>
  </div>
</form>
