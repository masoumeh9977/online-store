@extends('website.layouts.master')
@section('title', 'Cart')

@section('styles')
    <style>
        .empty-state {
            padding: 80px 20px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9ff 0%, #fff5f5 100%);
            border-radius: 20px;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }

        .empty-state::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.03) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }

        .empty-cart-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
            animation: bounce 2s infinite;
        }

        .empty-cart-icon i {
            font-size: 50px;
            color: white;
        }

        .empty-cart-icon::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            background: #ff6b6b;
            border-radius: 50%;
            top: -5px;
            right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }

        .empty-state h3 {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 35px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .shop-now-btn {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }

        .shop-now-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .shop-now-btn:hover::before {
            left: 100%;
        }

        .shop-now-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .floating-item {
            position: absolute;
            opacity: 0.1;
            animation: float-items 8s infinite ease-in-out;
        }

        .floating-item:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-item:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-item:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes float-items {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
            }
            33% {
                transform: translateY(-15px) translateX(10px);
            }
            66% {
                transform: translateY(10px) translateX(-10px);
            }
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="container">
            @if(!count($items))
                @include('website.cart.partials.empty')
            @else
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
                                        <td>
                                            <button class="btn btn-icon btn-pills btn-danger delete-item-btn"
                                                    data-id="{{$item->id}}"
                                                    title="delete">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 ms-3">{{$item->product->name}}</h6>
                                            </div>
                                        </td>
                                        <td class="text-center">{{$item->product->price}}$</td>
                                        <td class="text-center qty-icons">
                                            <button class="btn btn-icon btn-soft-primary update-cart minus">-</button>
                                            <input min="0" name="quantity" value="{{$item->quantity}}" type="number"
                                                   class="btn btn-icon btn-soft-primary qty-btn quantity">
                                            <button class="btn btn-icon btn-soft-primary plus update-cart">+</button>
                                        </td>
                                        <td class="text-center fw-bold">{{$item->total_item_price}}$</td>
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
                                    <td class="text-center fw-bold">{{$total}}$</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pt-2 text-end">
                            <a href="" class="btn btn-primary">Save as order</a>
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
                        let url = '{{route('api.v1.product.remove', ':itemId')}}';
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
        });
    </script>
@endsection
