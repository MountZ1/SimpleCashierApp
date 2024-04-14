@extends('dashboard.layouts.main')
@section('content')
    <div class="mt-3 row g-3 align-items-center" style="width: 40rem">
        <form action="/dashboard/suppliers" method="POST">
            @csrf
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> --}}
            <div class="col-auto">
                <label for="companyname" class="form-label">Nama Perusahaan</label>
                <input type="text" class="form-control" id="companyname" placeholder="nama perusahaan" name="company_name">
            </div>
            <div class="col-auto">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
            </div>
            <div class="col-auto">
                <label for="nomor" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="nomor" placeholder="Nomor Telephone" name="phone">
            </div>
            <div class="col-auto">
                <label for="addres" class="form-label">Alamat</label>
                <textarea class="form-control" id="addres" rows="3" name="address"></textarea>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3 mt-3 align-items-right">Simpan</button>
            </div>
        </form>
    </div>
@endsection