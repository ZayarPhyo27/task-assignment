
@extends('layout.app')
@section('main-content')
<div class="container mt-5">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Order #{{ $order->id }} - {{ $order->payment_method }}
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Address:</strong> {{ $order->customer_address }}</p>

            <p><strong>Payment Type:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
        </div>
    </div>

    <!-- Ordered Products -->
    <h4 class="mb-3">Ordered Products</h4>
    <div class="table-responsive">
        <table class="table table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price ($)</th>
                    <th>Quantity</th>
                    <th>Subtotal ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderProducts as $product)
                    <tr>
                        <td><img src="{{ $product->image }}" alt="{{ $product->product_name }}" width="60"></td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->price }}$</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price * $product->quantity }}</td>
                    </tr>
                @endforeach
                 <tfoot>
                    <tr>
                    <td colspan="4" class="text-end fw-bold">Shipping Fees</td>
                    <td class="fw-bold">20</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Total Amount</td>
                    <td class="fw-bold">{{ number_format($order->total, 2) }}</td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
</div>
@endsection

