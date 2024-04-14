@extends('dashboard.layouts.main')
@section('content')
<style>
    .tombol{
        background-color: #168aad;
        color: white
    }
    .tombol:hover{
        background-color: #0e5a71;
        color: white;
    }
</style>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Order</h1>
    <a href="/dashboard/orders/create" class="btn tombol">Tambah</a>
</div>
@if (session()->has('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close alert-close align-items-right" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Invoice</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Total</th>
            <th scope="col">Nama Kasir</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $ord)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $ord->invoice }}</td>
                <td>{{ $ord->date }}</td>
                <td>{{ $ord->total }}</td>
                <td>{{ $ord->cashier }}</td>
                <td>
                    <a href="/dashboard/orders/detail/{{ $ord->id }}" class="badge bg-warning"><i class="bi bi-eye"></i></a>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection