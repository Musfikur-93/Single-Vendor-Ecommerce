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
            <li class="breadcrumb-item active">OnPage SEO</li>
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
                  <h3 class="card-title">Your SEO Settings</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              <form role="form" action="{{ route('seo.setting.update',$data->id) }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $data->meta_title }}" placeholder="Meta Title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Meta Author</label>
                        <input type="text" class="form-control" name="meta_author" value="{{ $data->meta_author }}" placeholder="Meta Author">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Meta Tag</label>
                        <input type="text" class="form-control" name="meta_tag" value="{{ $data->meta_tag }}" placeholder="Meta Tag">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Meta Keyword</label>
                        <input type="text" class="form-control" name="meta_keyword" value="{{ $data->meta_keyword }}" placeholder="Meta Keyword">
                        <small>Example: ecommerce, online shop, online market</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Meta Description</label>
                        <textarea class="form-control" name="meta_description">{{ $data->meta_description }}</textarea>
                    </div>
                    <div class="text-center text-success">
                        <strong> -- Other Options -- </strong><br>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Google Verification</label>
                        <input type="text" class="form-control" name="google_verification" value="{{ $data->google_verification }}" placeholder="Google Verification">
                        <small>Put here only verification code.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alexa Verification</label>
                        <input type="text" class="form-control" name="alexa_verification" value="{{ $data->alexa_verification }}" placeholder="Alexa Verification">
                        <small>Put here only verification code.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Google Analytics</label>
                        <input type="text" class="form-control" name="google_analytics" value="{{ $data->google_analytics }}" placeholder="Google Analytics">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Google Adsense</label>
                        <input type="text" class="form-control" name="google_adsense" value="{{ $data->google_adsense }}" placeholder="Google Adsense">
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
