<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['message'] }}</p>

    <h2>Thông tin đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> {{ $data['order_id'] }}</p>
    <p><strong>Ngày đặt hàng:</strong> {{ $data['order_date'] }}</p>

    <h2>Thông tin giao hàng</h2>
    <p><strong>Họ và tên:</strong> {{ $data['customer_name'] }}</p>
    <p><strong>Số điện thoại:</strong> {{ $data['customer_phone'] }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $data['shipping_address'] }}</p>

    <h2>Chi tiết sản phẩm</h2>
    <ul>
        @foreach ($data['products'] as $product)
            <li>{{ $product['name'] }} - {{ $product['quantity'] }} x {{ number_format($product['price'], 0, ',', '.') }}đ</li>
        @endforeach
    </ul>

    <p><strong>Tạm tính:</strong> {{ number_format($data['subtotal'], 0, ',', '.') }}đ</p>
    <p><strong>Phí vận chuyển:</strong> {{ number_format($data['shipping_fee'], 0, ',', '.') }}đ</p>
    @if ($data['discount'] > 0)
        <p><strong>Giảm giá:</strong> -{{ number_format($data['discount'], 0, ',', '.') }}đ</p>
    @endif
    <p><strong>Tổng cộng:</strong> {{ number_format($data['total'], 0, ',', '.') }}đ</p>
</body>
</html>
