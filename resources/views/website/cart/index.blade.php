@extends('website.layouts.master')
@section('title', 'Cart')

@section('styles')
    <link href="/css/cart-styles.min.css" rel="stylesheet" type="text/css" id="theme-opt"/>
@endsection

@section('content')
    <section class="section">
        <div class="container">
            @if(!count($items))
                @include('website.cart.partials.empty')
            @else

                <div class="cart-container">
                    <div class="cart-header">
                        <h2>
                            <div class="cart-icon">
                                <i class="mdi mdi-shopping"></i>
                            </div>
                            Shopping Cart
                        </h2>
                    </div>
                    <table class="table modern-table">
                        <thead>
                        <tr>
                            <th style="min-width:70px"></th>
                            <th style="min-width: 300px;">Product</th>
                            <th class="text-center" style="min-width: 160px;">Price</th>
                            <th class="text-center" style="min-width: 200px;">Quantity</th>
                            <th class="text-center" style="min-width: 160px;">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr class="shop-list" data-id="{{$item->product_id}}">
                                <td class="text-center">
                                    <button class="delete-btn delete-item-btn" data-id="{{$item->id}}"
                                            title="Remove item">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </td>
                                <td>
                                    <div class="product-info">
                                        <div class="product-image">
                                            <i class="mdi mdi-laptop"></i>
                                        </div>
                                        <div class="product-details">
                                            <h6>{{$item->product->name}}</h6>
                                            <span class="product-category">{{$item->product->category->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="price-display">${{$item->product->price}}</div>
                                </td>
                                <td class="text-center">
                                    <div class="quantity-controls">
                                        <button class="control-btn update-cart minus">−</button>
                                        <input type="number" class="qty-input" value="{{$item->quantity}}" min="1">
                                        <button class="control-btn update-cart plus">+</button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="total-price">${{$item->total_item_price}}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="discount-section">
                        <div class="discount-header">
                            <h5>
                                <i class="mdi mdi-ticket-percent"></i>
                                Have a discount code?
                            </h5>
                        </div>
                        <div class="discount-form">
                            <div class="discount-input-group">
                                <input type="text"
                                       name="discount_code"
                                       class="discount-input"
                                       placeholder="Enter discount code"
                                       id="discountCode">
                            </div>
                        </div>
                    </div>
                    <div class="cart-summary">
                        <div class="summary-row">
                            <span class="summary-label">Total</span>
                            <span class="summary-value total-value">${{$total}}</span>
                        </div>
                    </div>
                    <div class="checkout-section">
                        <div class="checkout-actions">
                            <button class="checkout-btn" id="checkout-btn">
                                <i class="mdi mdi-credit-card"></i>
                                Proceed to Checkout
                                <span class="checkout-amount" id="checkoutAmount">${{$total}}</span>
                            </button>
                        </div>
                    </div>
                </div>

            @endif

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
                    url: '{{route('website.api.v1.product.add')}}',
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
            $('.delete-item-btn').on('click', function () {
                let itemId = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '{{route('website.api.v1.product.remove', ':itemId')}}';
                        url = url.replace(':itemId', itemId);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function () {
                                Swal.fire('Deleted!', 'Item removed.', 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });
            $('#checkout-btn').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{route('website.api.v1.order.store')}}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                discount_code: $('.discount-input').val()
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('Congratulations!', 'Order has been added.', 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }

                            },
                            error: function () {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
