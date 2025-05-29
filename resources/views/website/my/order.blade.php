@extends('website.layouts.master')
@section('title', 'Profile')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="/css/my-orders-styles.min.css" rel="stylesheet" type="text/css" id="theme-opt"/>

@endsection
@section('content')
    <div class="section">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Orders
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-hover w-100">
                            <thead>
                            <tr>
                                <th>Tracking Code</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="empty-state d-none">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>No Orders Yet</h3>
                        <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                        <a href="{{ route('website.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('website.my.partials.modal.order-details')
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function () {
            $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('website.my.order.list') }}',
                columns: [
                    {data: 'tracking_code', name: 'tracking_code'},
                    {data: 'status', name: 'status'},
                    {data: 'amount', name: 'amount'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });

            $(document).on('click', '.view-order', function () {
                let orderId = $(this).data('id');
                loadOrderDetails(orderId);
            });
        });

        function loadOrderDetails(orderId) {
            $('#orderModal').modal('show');
            let url = '{{route('website.api.v1.order.show', ':itemId')}}';
            url = url.replace(':itemId', orderId);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    showOrderDetailModal(response.data);
                },
                error: function (xhr) {
                    $('#orderModalContent').html('<div class="alert alert-danger">Error loading order details</div>');
                }
            });
        }

        function showOrderDetailModal(order) {

            $('#order-tracking').text(order.tracking_code);
            $('#order-status').text(order.status);
            $('#order-address').text(order.shipping_address);
            $('#order-discount').text(order.discount_code ? order.discount_code + ' (-' + order.discount_amount + '$)' : 'No discount');
            $('#order-total').text(order.total_amount);
            $('#order-created-at').text(order.created_at);

            // Fill products
            let $tbody = $('#order-products-body');
            $tbody.empty();

            if (Array.isArray(order.products)) {
                order.products.forEach((item, index) => {
                    $tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.product.name}</td>
                    <td>${item.product.price}$</td>
                    <td>${item.quantity}</td>
                    <td>${item.quantity * item.product.price}$</td>
                </tr>
            `);
                });
            }
        }
    </script>
@endsection
