<div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderModalContent">
                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>Order ID:</strong> <span id="order-id"></span></li>
                    <li class="list-group-item"><strong>Tracking Code:</strong> <span id="order-tracking"></span></li>
                    <li class="list-group-item"><strong>Status:</strong> <span id="order-status"></span></li>
                    <li class="list-group-item"><strong>Shipping Address:</strong> <span id="order-address"></span></li>
                    <li class="list-group-item"><strong>Discount:</strong> <span id="order-discount"></span></li>
                    <li class="list-group-item"><strong>Total Amount:</strong> <span id="order-total"></span> $</li>
                    <li class="list-group-item"><strong>Created At:</strong> <span id="order-created-at"></span></li>
                </ul>

                <h6>Products</h6>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody id="order-products-body">
                    <!-- Filled dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
