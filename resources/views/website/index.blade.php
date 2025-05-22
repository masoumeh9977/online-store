@extends('website.layouts.master')
@section('title', 'Home')

@section('carousel')
    @include('website.partials.carousel')
@endsection

@section('content')
    <section class="section">
        <div class="container mt-100 mt-60">
            <div class="row">
                <div class="col-11">
                    <h5 class="mb-0">New Arrivals</h5>
                </div>
                <div class="col-1">
                    <a href="#">more</a>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-6 col-12 mt-4 pt-2">
                        <div class="card shop-list border-0 position-relative">
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="{{route('website.product.show', $product)}}">
                                    <img src="images/s1.jpg" class="img-fluid" alt="">
                                </a>
                                <a href="{{route('website.product.show', $product)}}" class="overlay-work">
                                    <img src="images/s-2.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li class="mt-2">
                                        <a href="{{route('website.product.show', $product)}}"
                                           class="btn btn-icon btn-pills btn-soft-primary">
                                            <i data-feather="eye" class="icons"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="{{route('website.product.show', $product)}}"
                                   class="text-dark product-name h6">{{$product->name}}</a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">{{$product->price}}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
