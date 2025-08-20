<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body>
  <h2>Your order is successfully confirmed 🎉</h2>

    <p><strong>Order_ID:</strong> {{ $order_id }}</p>
    <p><strong>Name:</strong> {{ $customer_name }}</p>
    <p><strong>Phone:</strong> {{ $customer_phone }}</p>
    <p><strong>Email:</strong> {{ $customer_email }}</p>
    <p><strong>Address:</strong> {{ $customer_address }}</p>
    <p><strong>Total:</strong> {{ number_format($total, 0) }} $</p>
</body>
</html>
