@extends('website.layouts.master')
@section('title', 'Product')
@section('styles')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
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
                            @if(!$itemCount)
                                <button class="btn btn-soft-primary update-cart ms-2">Add To Cart</button>
                            @else
                                <td class="text-center qty-icons">
                                    <button class="btn btn-icon btn-soft-primary update-cart minus">-</button>
                                    <input min="0" name="quantity" type="number" value="{{$itemCount}}"
                                           class="btn btn-icon btn-soft-primary qty-btn quantity" readonly>
                                    <button class="btn btn-icon btn-soft-primary plus update-cart">+</button>
                                </td>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.update-cart').on('click', function () {
                let quantity = 1;
                if ($(this).siblings('input[type=number]').length) {
                    if ($(this).hasClass('plus')) {
                        $(this).siblings('input[type=number]').get(0).stepUp();
                    } else {
                        $(this).siblings('input[type=number]').get(0).stepDown();
                    }
                    quantity = $(this).siblings('input[type=number]').val();
                }

                $.ajax({
                    url: '{{route('website.api.v1.product.add')}}',
                    method: 'POST',
                    data: {
                        product_id: {{$product->id}},
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            });
        });
    </script>
@endsection
