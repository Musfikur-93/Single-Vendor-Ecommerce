@extends('layouts.admin')

@section('admin_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Website Setting</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Your Website Settings</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              <form role="form" action="{{ route('website.setting.update',$setting->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Currency</label>
                        <select class="form-control" name="currency">
                            <option value="৳" {{ ($setting->currency=='৳') ? 'selected' : '' }}>Taka(৳)</option>
                            <option value="$" {{ ($setting->currency=='$') ? 'selected' : '' }}>USD($)</option>
                            <option value="₹" {{ ($setting->currency=='₹') ? 'selected' : '' }}>Rupee(₹)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone One</label>
                        <input type="text" class="form-control" name="phone_one" value="{{ $setting->phone_one }}" placeholder="Phone One" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone Two</label>
                        <input type="text" class="form-control" name="phone_two" value="{{ $setting->phone_two }}" placeholder="Phone Two" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Main Email</label>
                        <input type="email" class="form-control" name="main_email" value="{{ $setting->main_email }}" placeholder="Main Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Support Email</label>
                        <input type="email" class="form-control" name="support_email" value="{{ $setting->support_email }}" placeholder="Support Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $setting->address }}" placeholder="Address">
                    </div>
                    <div class="text-center text-success">
                        <strong> -- Social Links -- </strong><br>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Facebook</label>
                        <input type="text" class="form-control" name="facebook" value="{{ $setting->facebook }}" placeholder="Facebook">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Twitter</label>
                        <input type="text" class="form-control" name="twitter" value="{{ $setting->twitter }}" placeholder="Twitter">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="{{ $setting->instagram }}" placeholder="Instagram">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Linkedin</label>
                        <input type="text" class="form-control" name="linkedin" value="{{ $setting->linkedin }}" placeholder="Linkedin">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Youtube</label>
                        <input type="text" class="form-control" name="youtube" value="{{ $setting->youtube }}" placeholder="Youtube">
                    </div>

                    <div class="text-center text-success">
                        <strong> -- Logo and Favicon -- </strong><br>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Main Logo</label>
                        <input type="file" class="form-control" name="logo">
                        <input type="hidden" name="old_logo" value="{{$setting->logo}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Favicon</label>
                        <input type="file" class="form-control" name="favicon">
                        <input type="hidden" name="old_favicon" value="{{$setting->favicon}}">
                    </div>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form> <!--/. form -->
         </div>
        </div>
      </div> <!--/. row -->
    </div><!--/. container-fluid -->
  </section>
</div>
<!-- /.content -->
@endsection
