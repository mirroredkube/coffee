<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice { width: 80%; margin: 0 auto; }
        .header { background-color: #6F4E37; color: white; padding: 10px; }
        .item { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .total { font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>Invoice from Coffee Shop</h1>
        </div>
        <p>Thank you for your order, {{ $order['user_name'] }}!</p>
        <p>Order Date: {{ $order['order_date'] }}</p>
        <div class="items">
            @foreach($order['items'] as $item)
                <div class="item">
                    <span>{{ $item['name'] }}</span>
                    <span>Quantity: {{ $item['quantity'] }}</span>
                    <span>Price: ${{ number_format($item['price'], 2) }}</span>
                </div>
            @endforeach
        </div>
        <div class="total">
            Total: ${{ number_format($order['total'], 2) }}
        </div>
    </div>
</body>
</html>
