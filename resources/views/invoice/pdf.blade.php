<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        h2, h3 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            padding: 8px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        .total-price {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Invoice # {{ $order['id'] }}</h1>
    <ul>
        <li><strong>Client Name:</strong> {{ $order['client_name'] }}</li>
        <li><strong>Phone:</strong> {{ $order['phone'] }}</li>
        <li><strong>Address:</strong> {{ $order['address'] }}</li>

        @if ($order['discount'] > 0)
            <li><strong>Discount:</strong> {{ $order['discount'] }}%</li>
        @endif

        <li><strong>Total Price:</strong> {{ number_format($order['price'], 2) }} AED</li>
    </ul>

    <h2>Order Items</h2>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Price (per unit)</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item['name_en'] }}</td>
                <td>{{ number_format($item['price'], 2) }} AED</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'] * $item['quantity'], 2) }} AED</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="total-price">Total: {{ number_format($order['price'], 2) }} AED</h3>
</div>

</body>
</html>
