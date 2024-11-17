@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_responsive.css">
@include('layouts.frontend_partial.collaps_nav')

	<!-- Cart -->
	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Your Wishlist Item</div>
						<div class="cart_items">
							<ul class="cart_list">
								@foreach($wishlist as $row)
								<li class="cart_item clearfix">
									<div class="cart_item_image"><img src="{{ asset('public/files/product/'.$row->thumbnail) }}" alt="{{ $row->product_name }}"></div>
									<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_title">Name</div>
											<div class="cart_item_text">{{ substr($row->product_name, 0,20) }}..</div>
										</div>
										<div class="cart_item_quantity cart_info_col">
											<div class="cart_item_title">Date</div>
											<div class="cart_item_text">
												{{ $row->wishlist_date }}
											</div>
										</div>
										<div class="cart_item_total cart_info_col">
											<a href="{{ route('product.details',$row->slug) }}"><button type="button" class="button cart_button_clear">Add To Cart</button></a>
											<a href="{{ route('wishlistproduct.delete', $row->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
						<!-- Order Total -->
						<div class="cart_buttons">
							<a href="{{ route('wishlist.empty') }}"><button type="button" class="button cart_button_checkout">Wishlist Empty</button></a>
							<a href="{{ url('/') }}"><button type="button" class="button cart_button_checkout">Back Home</button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
@endsection 