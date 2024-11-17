
<form action="{{ route('blog.category.update') }}" method="post">
      @csrf
      <div class="form-group">
        <label for="category_name">Blog Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $data->category_name }}" required>
        <small id="emailHelp" class="form-text text-muted">This is your main blog category</small>
      </div>
      <input type="hidden" name="id" value="{{ $data->id }}">
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
</form>

