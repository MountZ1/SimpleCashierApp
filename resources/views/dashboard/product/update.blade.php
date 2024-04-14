@extends('dashboard.layouts.main')
@section('content')
<div class="mt-3 row g-3 align-items-center" style="width: 40rem">
    <form action="/dashboard/products/{{ $product->id }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="col-auto">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" name="merk" id="merk" class="form-control" placeholder="Merk Barang" value="{{ $product->merk }}">
        </div>
        <div class="col-auto">
            <label for="" class="form-label">Perusahaan/Distributor</label>
            <select name="company_id" id="" class="form-select">
                @foreach ($suppliers as $sp)
                    <option value="{{ $sp->id }}" {{ $sp->id == $product->company_id ? 'selected' : '' }}>{{ $sp->company_name }}</option>
                @endforeach
            </select>
            {{-- <input type="text" name="" id="" class="form-control"> --}}
        </div>
        <div class="col-auto">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Code" value="{{ $product->code }}">
        </div>
        <div class="col-auto">
            <label for="name" class="form-label">Nama Product</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nama Product" value="{{ $product->name }}">
        </div>
        <div class="col-auto">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="text" name="buy_price" id="buy_price" class="form-control" placeholder="Harga Beli" value="{{ $product->buy_price }}">
        </div>
        <div class="col-auto">
            <label for="" class="form-label">Harga Jual</label>
            <input type="text" name="sell_price" id="sell_price" class="form-control" placeholder="Harga Jual" value="{{ $product->sell_price }}">
        </div>
        <div class="col-auto">
            <label for="" class="form-label">Stok</label>
            <input type="text" name="stock" id="stock" class="form-control" placeholder="Stok" value="{{ $product->stock }}">
        </div>
        <div class="col-auto">
            <label for="" class="form-label">Kategori</label>
            <input type="text" name="category" id="category" class="form-control" placeholder="Kategori" value="{{ $product->category }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3 mt-3 align-items-right">Simpan</button>
        </div>
    </form>
</div>
@endsection