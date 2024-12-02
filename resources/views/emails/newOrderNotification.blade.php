<h1>New Order Notification</h1>
<p>A new order has been placed:</p>
<ul>
    <li><strong>Order ID:</strong> {{ $order['id'] }}</li>
    <li><strong>Client Name:</strong> {{ $order['client_name'] ?? 'Guest' }}</li>
    <li><strong>Phone:</strong> {{ $order['phone'] ?? 'N/A' }}</li>
    <li><strong>Address:</strong> {{ $order['address'] ?? 'N/A' }}</li>
    <li><strong>Preferred Pickup Time:</strong> {{ $order['preferred_pickup_time'] ?? 'N/A' }}</li>

    @if ($order->promoCode)
        <li><strong>Promo Code:</strong> {{ $order->promoCode->code }}</li>
        <li><strong>Promo Code Type:</strong> {{ ucfirst($order->promoCode->discount_type) }}</li>
        <li><strong>Promo Code Value:</strong> {{ $order->promoCode->value }}
            {{ $order->promoCode->discount_type == 'percentage' ? '%' : 'AED' }}</li>
        <!-- <li><strong>Maximum Discount:</strong> {{ number_format($order->promoCode->max_fixed_value, 2) }} AED</li> -->
        <li><strong>Discount Applied:</strong> {{ number_format($discountValue, 2) }} AED</li>
    @endif

    <li><strong>Total Price:</strong> {{ number_format($order['price'], 2) }} AED</li>
</ul>

<h2>Order Items</h2>
<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
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
                <td>{{ $item['name_en'] ?? $item['name_ar'] }}</td>
                <td>{{ number_format($item['price'], 2) }} AED</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'] * $item['quantity'], 2) }} AED</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Total Price : {{ number_format($order['price'], 2) }} AED</h3>
<p>Check the system for more details.</p>
