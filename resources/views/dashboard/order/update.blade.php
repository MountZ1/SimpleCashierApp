@extends('dashboard.layouts.main')
@section('content')
    <div class="container-fluid mt-3 border border-black ps-3" style="width: 60%">
        <h1 class="text-center">{{ $order->invoice }}</h1>
        <br>
        <br>
        <p>{{ $order->date }}</p>
        {{-- <p>{{ $order->detailpembelian }}</p> --}}
        <table class="table table-borderless">
            <thead>
                <tr class="border-bottom">
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->detailpembelian as $detail)
                    <tr>
                        <td>{{ $detail->Product->pluck('merk')->implode(', ') . ' ' . $detail->Product->pluck('name')->implode(', ')}}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>{{ $detail->Product->pluck('sell_price')->implode(', ') }}</td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
        <hr class="mt-5">
        <div class="text-end me-5">
            <p>Total : {{ $order->total }}</p>
            <p>Pembayaran : {{ $order->payment }}</p>
            <p>Tunai : {{ $order->pay_amount }}</p>
            <p>Kembalian : {{ $order->change }}</p>
            <p>Kasir : {{ $order->cashier }}</p>
        </div>
    </div>
@endsection