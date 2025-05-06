<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        /* Reset styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eaeaea;
        }

        .logo {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .title {
            color: #4a6cf7;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .content {
            padding: 30px 20px;
        }

        .order-info {
            background-color: #f7fbff;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            border-left: 4px solid #4a6cf7;
        }

        .order-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            background-color: #e6f0ff;
            color: #4a6cf7;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #5d6778;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        .items-table th {
            background-color: #f5f7ff;
            text-align: left;
            padding: 12px;
            font-weight: 600;
            color: #4a6cf7;
            font-size: 14px;
            border-bottom: 1px solid #eaeaea;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eaeaea;
            font-size: 14px;
        }

        .summary {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .summary-label {
            font-weight: 600;
            color: #5d6778;
        }

        .summary-value {
            font-weight: 600;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #eaeaea;
        }

        .total-label {
            font-weight: 700;
            font-size: 16px;
            color: #333;
        }

        .total-value {
            font-weight: 700;
            font-size: 16px;
            color: #4a6cf7;
        }

        .shipping-info {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }

        .cta-button {
            display: block;
            text-align: center;
            margin: 30px auto;
            padding: 14px 24px;
            background-color: #4a6cf7;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            font-size: 16px;
            width: 200px;
            transition: background-color 0.2s;
        }

        .cta-button:hover {
            background-color: #3a5bd9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            border-top: 1px solid #eaeaea;
            color: #7c8495;
            font-size: 14px;
        }

        .social-links {
            margin: 15px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 8px;
            color: #4a6cf7;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                border-radius: 0;
            }

            .content {
                padding: 20px 15px;
            }

            .items-table th, .items-table td {
                padding: 8px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="title">Thank You for Your Order!</h1>
    </div>

    <div class="content">
        <p>Hi {{ $order->cart->user->name ?? 'Valued Customer' }},</p>

        <p>Your order has been received and is now being processed. We'll send you another notification once your order
            has been shipped.</p>

        <div class="order-info">
            <span class="order-status">{{ $order->status }}</span>

            <p class="info-label">Order Number:</p>
            <p class="info-value">#{{ $order->tracking_code }}</p>

            <p class="info-label">Order Date:</p>
            <p class="info-value">{{ $order->created_at->format('F j, Y, g:i A') }}</p>
        </div>

        <h2>Order Summary</h2>

        <table class="items-table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->product->price, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span class="summary-label">Subtotal:</span>
                <span class="summary-value">${{ number_format($order->total_amount + $order->discount_amount, 2) }}</span>
            </div>

            @if($order->discount_amount > 0)
                <div class="summary-row">
                    <span class="summary-label">Discount:</span>
                    <span class="summary-value">-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
            @endif

            <div class="summary-row">
                <span class="summary-label">Shipping:</span>
                <span class="summary-value">Free</span>
            </div>

            <div class="total-row">
                <span class="total-label">Total:</span>
                <span class="total-value">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="shipping-info">
            <h3>Shipping Address</h3>
            <p>{{ $order->shipping_address }}</p>
        </div>

        <p>If you have any questions or concerns about your order, please don't hesitate to <a
                style="color: #4a6cf7; text-decoration: none;">contact our customer
                service team</a>.</p>

        <p>Thanks for shopping with us!</p>

        <p>Best regards,<br>The Team</p>
    </div>

    <div class="footer">
        <div class="social-links">
            <a href="#" class="social-link">Facebook</a>
            <a href="#" class="social-link">Instagram</a>
            <a href="#" class="social-link">Twitter</a>
        </div>

        <p>&copy; {{ date('Y') }} Your Store. All rights reserved.</p>
        <p>123 Commerce Street, City, Country</p>
    </div>
</div>
</body>
</html>
