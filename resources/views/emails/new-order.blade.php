<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received.</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #dadada;
        }

        table {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            border-spacing: 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        td {
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        p {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        .order-details {
            margin: 20px 0;
            font-size: 15px;
            text-align: left;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table th,
        .products-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .products-table th {
            background-color: #f4f4f4;
        }

        .footer {
            background-color: #4CAF50;
            color: white !important;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <h1>Order Created Successfully!</h1>
                <p>Hello <strong>{{ $name }}</strong>,</p>
                <p>Thank you for your order! Your order has been placed successfully.</p>

                <div class="order-details">
                    <p><strong>Order Number:</strong> {{ "#".$id }}</p>
                    <p><strong>Order Date:</strong> {{ $order_date }}</p>
                    <p><strong>Your Email:</strong> {{ $email }}</p>
                    <p><strong>Your Mobile:</strong> {{ $mobile }}</p>
                </div>

                <h2>Order Summary</h2>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Product Brand</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($items))
                            @foreach ($items as $item)
                                @if (is_array($item))
                                    <tr>
                                        <td>{{ $item['product_name'] ?? "-" }}</td>
                                        <td>{{ $item['brand'] ?? "-" }}</td>
                                        <td>{{ $item['quantity'] ?? "-" }}</td>
                                        <td>{{ $item['selling_price'] ?? 'N/A' }}</td>
                                    </tr>
                                @else
                                    <li>Invalid item format</li>
                                @endif
                            @endforeach
                        @endif

                    </tbody>
                </table>

                <p>If you have any questions, feel free to contact us at <a
                        href="mailto:{{ $company_email }}">{{ $company_email }}</a>.</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Thank you for choosing our service!</p>
                <p>&copy; {{ date('Y') }} {{ ucfirst($company_name) }}. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>

</html>
