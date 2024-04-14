@extends('layouts.main')
@section('content')
<div class="vh-100 d-flex align-items-center justify-content-center">
    <div class="mx-auto border border-2 p-5 rounded shadow" style="width: 20rem; border-color: #00A7E1; background-color: #FFFFFF">
        @if (session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form class="form-signin" method="POST" action="/">
            @csrf
            <h1 class="h3 mb-3 fw-normal space-1 text-center">Please sign in</h1>
        
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username">
                <label for="floatingInput">name</label>
            </div>
            <div class="form-floating mt-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>
        
            <div class="mt-3">
                <button class="btn w-100 py-2" type="submit" style="background-color: #48b26d; color: #FFFFFF" onmouseover="this.style.backgroundColor='#3e9a5e';" onmouseout="this.style.backgroundColor='#48b26d'">Sign in</button>
            </div>
        </form>
    </div>
</div>
@endsection
