@extends('frontend.master.master')
@section('title','Danh sách sản phẩm')

@section('content')
    <!-- main -->
		<div class="colorlib-shop">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-md-push-3">
						<div class="row row-pb-lg">
							@foreach ($products as $product)
                                <div class="col-md-4 text-center">
                                    <div class="product-entry">
                                        <div class="product-img" style="background-image: url(../backend/img/{{ $product->img }});">

                                            <div class="cart">
                                                <p>
                                                    <span class="addtocart"><a href="/product/detail/{{$product->id}}"><i class="icon-shopping-cart"></i></a></span>
                                                    <span><a href="/product/detail/{{$product->id}}"><i class="icon-eye"></i></a></span>


                                                </p>
                                            </div>
                                        </div>
                                        <div class="desc">
                                            <h3><a href="/product/detail/{{$product->id}}">{{ $product->name }}</a></h3>
                                            <p class="price"><span>{{ number_format($product->price,0,'','.') }} VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


						</div>
						<div class="row">
							<div class="col-md-12">
								{{ $products->links() }}
							</div>
						</div>
					</div>
					<div class="col-md-3 col-md-pull-9">
						<div class="sidebar">
							<div class="side">
								<h2>Danh mục</h2>
								<div class="fancy-collapse-panel">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        @foreach ($categories as $category)
                                            @if ($category->parent==0)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#menu{{ $category->id }}" aria-expanded="true" aria-controls="collapseOne">
                                                                {{ $category->name }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="menu{{ $category->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            <ul>
                                                                @foreach ($categories as $cate)
                                                                    @if ($cate->parent==$category->id)
                                                                        <li><a href="/product?category={{$cate->id}}">{{ $cate->name }}</a></li>
                                                                    @endif
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach




									</div>
								</div>
							</div>
							<div class="side">
								<h2>Khoảng giá</h2>
								<form method="get" class="colorlib-form-2">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="guests">Từ:</label>
												<div class="form-field">
													<i class="icon icon-arrow-down3"></i>
													<select name="start" id="people" class="form-control">
														<option @if(request()->start == 100000) selected @endif value="100000">100.000 VNĐ</option>
														<option @if(request()->start == 200000) selected @endif value="200000">200.000 VNĐ</option>
														<option @if(request()->start == 300000) selected @endif value="300000">300.000 VNĐ</option>
														<option @if(request()->start == 500000) selected @endif value="500000">500.000 VNĐ</option>
														<option @if(request()->start == 1000000) selected @endif value="1000000">1.000.000 VNĐ</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="guests">Đến:</label>
												<div class="form-field">
													<i class="icon icon-arrow-down3"></i>
													<select name="end" id="people" class="form-control">
														<option @if(request()->end == 2000000) selected @endif value="2000000">2.000.000 VNĐ</option>
														<option @if(request()->end == 4000000) selected @endif value="4000000">4.000.000 VNĐ</option>
														<option @if(request()->end == 6000000) selected @endif value="6000000">6.000.000 VNĐ</option>
														<option @if(request()->end == 8000000) selected @endif value="8000000">8.000.000 VNĐ</option>
														<option @if(request()->end == 10000000) selected @endif value="10000000">10.000.000 VNĐ</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<button type="submit" style="width: 100%;border: none;height: 40px;">Tìm kiếm</button>
								</form>
                            </div>
                            @foreach ($attrs as $attr)
                                <div class="side">
                                    <h2>{{ $attr->name }}</h2>
                                    <div class="size-wrap">
                                        <p class="size-desc">
                                            @foreach ($attr->values as $value)
                                            <a href="/product?value={{$value->id}}" class="attr">{{ $value->value }}</a>
                                            @endforeach


                                        </p>
                                    </div>
                                </div>
                            @endforeach


						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end main -->
@endsection
@section('script')
<script>
    $(document).ready(function () {

        var quantitiy = 0;
        $('.quantity-right-plus').click(function (e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function (e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>
@endsection


