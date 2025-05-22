@extends('website.layouts.master')
@section('title', 'Cart')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive bg-white shadow">
                        <table class="table table-center table-padding mb-0">
                            <thead>
                            <tr>
                                <th class="border-bottom py-3" style="min-width:20px "></th>
                                <th class="border-bottom py-3" style="min-width: 300px;">Product</th>
                                <th class="border-bottom text-center py-3" style="min-width: 160px;">Price</th>
                                <th class="border-bottom text-center py-3" style="min-width: 160px;">Quantity</th>
                                <th class="border-bottom text-center py-3" style="min-width: 160px;">Total</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($items as $item)
                                <tr class="shop-list" data-id="{{$item->product_id}}">
                                    <td class="h6"><a href="javascript:void(0)" class="text-danger">X</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 ms-3">{{$item->product->name}}</h6>
                                        </div>
                                    </td>
                                    <td class="text-center">{{$item->product->price}}</td>
                                    <td class="text-center qty-icons">
                                        <button class="btn btn-icon btn-soft-primary update-cart minus">-</button>
                                        <input min="0" name="quantity" value="{{$item->quantity}}" type="number"
                                               class="btn btn-icon btn-soft-primary qty-btn quantity">
                                        <button class="btn btn-icon btn-soft-primary plus update-cart">+</button>
                                    </td>
                                    <td class="text-center fw-bold">{{$item->quantity * $item->product->price}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 ms-auto mt-4 pt-2">
                    <div class="table-responsive bg-white rounded shadow">
                        <table class="table table-center table-padding mb-0">
                            <tbody>
                            <tr class="bg-light">
                                <td class="h6">Total</td>
                                <td class="text-center fw-bold">{{2}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 pt-2 text-end">
                        <a href="shop-checkouts.html" class="btn btn-primary">Save as order</a>
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
                let productId = $(this).closest('.shop-list').attr('data-id');
                if ($(this).siblings('input[type=number]').length) {
                    if ($(this).hasClass('plus')) {
                        $(this).siblings('input[type=number]').get(0).stepUp();
                    } else {
                        $(this).siblings('input[type=number]').get(0).stepDown();
                    }
                    quantity = $(this).siblings('input[type=number]').val();
                }

                $.ajax({
                    url: '{{route('api.v1.product.add')}}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
@endsection
