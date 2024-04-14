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
    <h1 class="h2">Products</h1>
    <a href="/dashboard/products/create" class="btn tombol">Tambah</a>
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
            <th scope="col">Merk</th>
            <th scope="col">Perusahaan/Distributor</th>
            <th scope="col">Code</th>
            <th scope="col">Nama</th>
            <th class="col">Harga Beli</th>
            <th class="col">Harga Jual</th>
            <th class="col">Stok</th>
            <th class="col">Kategori</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $prod)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $prod->merk }}</td>
                <td>{{ $prod->supplier->company_name }}</td>
                <td>{{ $prod->code }}</td>
                <td>{{ $prod->name }}</td>
                <td>{{ $prod->buy_price }}</td>
                <td>{{ $prod->sell_price }}</td>
                <td>{{ $prod->stock }}</td>
                <td>{{ $prod->category }}</td>
                <td>
                    <a href="/dashboard/products/{{ $prod->id }}/edit" class="badge bg-warning"><i class="bi bi-pencil"></i></a>
                    <form action="/dashboard/products/{{ $prod->id }}" method="post" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection