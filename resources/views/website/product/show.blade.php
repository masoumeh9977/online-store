@extends('website.layouts.master')
@section('title', 'Product')

@section('content')
    <section class="section pb-0" style="margin-top: 4.6%;margin-bottom: 8%;">
        <div class="container mt-5 mb-5">
            <div class="row align-items-center mt-5 mb-5">
                <div class="col-md-5">
                    <div class="tiny-single-item">
                        <div class="tiny-slide">
                            <img src="{{$product->getFirstMediaUrlSafe('images') ?? '/images/default-product.png'}}"
                                 class="img-fluid rounded" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <div class="section-title ms-md-4">
                        <h4 class="title">{{$product->name}}</h4>
                        <h5 class="text-muted">Price: {{$product->price}} $</h5>

                        <h5 class="mt-4 py-2">Description</h5>
                        <p class="text-muted">{{$product->description}}</p>

                        <div class="mt-4 pt-2">
                            <a href="shop-cart.html" class="btn btn-soft-primary ms-2">Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
