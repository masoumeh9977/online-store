@extends('website.layouts.master')
@section('title', 'Home')

@section('content')
    <section class="section">
        <div class="container">
            <div class="col-12 mt-5 pt-2 mt-sm-0 pt-sm-0">
                <div id="product-list" class="row">

                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                            <div class="card shop-list border-0 position-relative">
                                <div class="shop-image position-relative overflow-hidden rounded shadow">
                                    <a href="{{route('website.product.show', $product)}}"><img src="/images/s1.jpg"
                                                                                               class="img-fluid" alt=""></a>
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
                                        <h6 class="text-muted small fst-italic mb-0 mt-1">
                                            $ {{$product->price}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        let currentPage = 1;
        let loadingNextPage = false;
        $(document).ready(function () {
            $(window).on('scroll', function () {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    if (!loadingNextPage) {
                        currentPage++;
                        loadProducts(currentPage);
                    }
                }
            })
        });

        function loadProducts(currentPage) {
            loadingNextPage = true;
            let url = '{{route('api.v1.product.fetch')}}';
            url = url + '?page=' + currentPage;
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    setProducts(response.data);
                    loadingNextPage = false;
                },
                error: function (xhr) {
                    loadingNextPage = false;
                }
            });
        }

        function setProducts(items) {

            $.each(items, function (i, product) {
                let url = '{{route('website.product.show', ':itemId')}}';
                url = url.replace(':itemId', product.id)
                $('#product-list').append(`
                <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                            <div class="card shop-list border-0 position-relative">
                                <div class="shop-image position-relative overflow-hidden rounded shadow">
                                    <a href="${url}"><img src="/images/s1.jpg"
                                                                                               class="img-fluid" alt=""></a>
                                    <ul class="list-unstyled shop-icons">
                                        <li class="mt-2">
                                            <a href="${url}"
                                               class="btn btn-icon btn-pills btn-soft-primary">
                                                <i data-feather="eye" class="icons"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body content pt-4 p-2">
                                    <a href="${url}"
                                       class="text-dark product-name h6">${product.name}</a>
                                    <div class="d-flex justify-content-between mt-1">
                                        <h6 class="text-muted small fst-italic mb-0 mt-1">
                                            $ ${product.price}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                </div>
            `);
            });
        }
    </script>
@endsection
