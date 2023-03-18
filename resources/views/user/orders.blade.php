@section('content')
    <h1>Merchant Orders</h1>
    <p>Here you can view your orders:</p>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Subtotal</th>
                <th>Commission Owed</th>
                <th>Payout Status</th>
                <th>Discount Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->subtotal }}</td>
                    <td>{{ $order->commission_owed }}</td>
                    <td>{{ $order->payout_status }}</td>
                    <td>{{ $order->discount_code ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
