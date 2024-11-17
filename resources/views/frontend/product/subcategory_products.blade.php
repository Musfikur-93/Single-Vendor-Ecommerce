@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_responsive.css">
@include('layouts.frontend_partial.collaps_nav')

	<!-- Home -->

	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('public/frontend') }}/images/shop_background.jpg"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">{{ $subcategory->subcategory_name }}</h2>
		</div>
	</div>

<!-- Brands -->
		<div class="brands">
		  <div class="container">
			<div class="row">
			  <div class="col">
			    <div class="brands_slider_container">
			      <!-- Brands Slider -->
			      <div class="owl-carousel owl-theme brands_slider">
			        @foreach($brand as $row)
			        <div class="owl-item">
			          <div class="brands_item d-flex flex-column justify-content-center">
			            <a href="{{ route('brandwise.product', $row->id) }}" title="{{ $row->brand_name }}"><img src="{{ asset( $row->brand_logo ) }}" alt="{{ $row->brand_name }}" height="50" width="40"></a>
			          </div>
			        </div>
			        @endforeach
			      </div>
			      <!-- Brands Slider Navigation -->
			      <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
			      <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>
			    </div>
			  </div>
			</div>
		</div>
	</div>

<!-- Shop -->
	<div class="shop">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">

					<!-- Shop Sidebar -->
					<div class="shop_sidebar">
						<div class="sidebar_section">
							<div class="sidebar_title">Child categories</div>
							
							<ul class="sidebar_categories">
								@foreach($childcategory as $row)
									<li><a href="{{ route('childcategorywise.product', $row->id) }}">{{ $row->childcategory_name }}</a></li>
								@endforeach
							</ul>
							
						</div>
						<div class="sidebar_section filter_by_section">
							<div class="sidebar_title">Filter By</div>
							<div class="sidebar_subtitle">Price</div>
							<div class="filter_price">
								<div id="slider-range" class="slider_range"></div>
								<p>Range: </p>
								<p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
							</div>
						</div>
						<div class="sidebar_section">
							<div class="sidebar_subtitle color_subtitle">Color</div>
							<ul class="colors_list">
								<li class="color"><a href="#" style="background: #b19c83;"></a></li>
								<li class="color"><a href="#" style="background: #000000;"></a></li>
								<li class="color"><a href="#" style="background: #999999;"></a></li>
								<li class="color"><a href="#" style="background: #0e8ce4;"></a></li>
								<li class="color"><a href="#" style="background: #df3b3b;"></a></li>
								<li class="color"><a href="#" style="background: #ffffff; border: solid 1px #e1e1e1;"></a></li>
							</ul>
						</div>
						<!-- <div class="sidebar_section">
							<div class="sidebar_subtitle brands_subtitle">Brands</div>
							@foreach($brand as $row)
							<ul class="brands_list">
								<li class="brand"><a href="#">{{ $row->brand_name }}</a></li>
							</ul>
							@endforeach
						</div> -->
					</div>

				</div>

				<div class="col-lg-9">
					
					<!-- Shop Content -->

					<div class="shop_content">
						<div class="shop_bar clearfix">
							<div class="shop_product_count"><span>{{ count($product) }}</span> products found</div>
							<div class="shop_sorting">
								<span>Sort by:</span>
								<ul>
									<li>
										<span class="sorting_text">highest rated<i class="fas fa-chevron-down"></span></i>
										<ul>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
											<li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>

						<div class="product_grid row">
							<div class="product_grid_border"></div>
							@foreach($product as $row)
								<!-- Product Item -->
								<div class="product_item is_new col-lg-2">
									<div class="product_border"></div>
									<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset('public/files/product/'.$row->thumbnail) }}" alt=""></div>
									<div class="product_content">
										@if($row->discount_price==NULL)
											<div class="product_price">{{ $setting->currency }}{{ $row->selling_price }}</div>
										@else
											<div class="product_price">{{ $setting->currency }}{{ $row->discount_price }}<span>{{ $setting->currency }}{{ $row->selling_price }}</span></div>
										@endif
										<div class="product_name"><div><a href="{{ route('product.details',$row->slug) }}" tabindex="0">{{ $row->product_name }}</a></div></div>
									</div>
									<a href="{{ route('add.wishlist', $row->id) }}">
										<div class="product_fav">
											<i class="fas fa-heart"></i>
										</div>
									</a>
									 <ul class="product_marks quick_view" id="{{ $row->id }}" data-toggle="modal" data-target="#exampleModalCenter">
										<li class="product_mark product_new">
											<i class="fas fa-eye"></i>
										</li>
									</ul>
								</div>
							@endforeach

						</div>

						<!-- Shop Page Navigation -->

						<div class="shop_page_nav d-flex flex-row">
							<ul class="page_nav d-flex flex-row"> 
								{{ $product->links() }}
							</ul> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Recently Viewed -->

<div class="viewed">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="viewed_title_container">
          <h3 class="viewed_title">Recommanded For You</h3>
          <div class="viewed_nav_container">
            <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
            <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
          </div>
        </div>

        <div class="viewed_slider_container">

          <!-- Recently Viewed Slider -->

          <div class="owl-carousel owl-theme viewed_slider">
            @foreach($random_product as $row)
            <!-- Recently Viewed Item -->
            <div class="owl-item">
              <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                <div class="viewed_image"><img src="{{ asset('public/files/product/'.$row->thumbnail) }}" alt="{{ $row->product_name }}"></div>
                <div class="viewed_content text-center">
                   @if($row->discount_price==NULL)
                      <span class="text-danger">{{ $setting->currency }}{{ $row->selling_price }}</span>
                    @else
                      <span class="text-danger">{{$setting->currency}} {{$row->discount_price}}-</span> <del class="text-muted">{{ $setting->currency }} {{ $row->selling_price }}</del>
                    @endif
                  <div class="viewed_name"><a href="{{ route('product.details', $row->slug) }}">{{ substr($row->product_name, 0, 15) }}..</a></div>
                </div>
                <ul class="item_marks">
                  
                </ul>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- product quick view -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="quick_view_body">
        
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('public/frontend') }}/plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="{{ asset('public/frontend') }}/plugins/parallax-js-master/parallax.min.js"></script>
<script src="{{ asset('public/frontend') }}/js/shop_custom.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
  //ajax request send for collect childcategory value
     $(document).on('click', '.quick_view', function(){
       var id = $(this).attr("id");
       $.ajax({
         url: "{{ url("/product-quick-view/") }}/"+id,
         type: 'get',
         success: function(data){
            $("#quick_view_body").html(data);
         }
       });
     });
</script>

@endsection