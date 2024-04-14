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
    <h1 class="h2">Supplier</h1>
    <a href="/dashboard/suppliers/create" class="btn tombol">Tambah</a>
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
            <th scope="col">Nama Perusahaan</th>
            <th scope="col">Email</th>
            <th scope="col">No Telepon</th>
            <th scope="col">Alamat</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($suppliers as $sup)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sup->company_name }}</td>
                <td>{{ $sup->email }}</td>
                <td>{{ $sup->phone }}</td>
                <td>{{ $sup->address }}</td>
                <td>
                    <a href="/dashboard/suppliers/{{ $sup->id }}/edit" class="badge bg-warning"><i class="bi bi-pencil"></i></a>
                    <form action="/dashboard/suppliers/{{ $sup->id }}" method="post" class="d-inline">
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