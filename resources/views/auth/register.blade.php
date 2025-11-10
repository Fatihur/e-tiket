@extends('layouts.auth')

@section('title', 'Register - Modernize Free')

@section('content')
<div class="card mb-0">
  <div class="card-body">
    <a href="{{ route('dashboard') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
      <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
    </a>
    <p class="text-center">Your Social Campaigns</p>
    <form>
      <div class="mb-3">
        <label for="exampleInputtext1" class="form-label">Name</label>
        <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="mb-4">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
      </div>
      <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</a>
      <div class="d-flex align-items-center justify-content-center">
        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
        <a class="text-primary fw-bold ms-2" href="{{ route('auth.login') }}">Sign In</a>
      </div>
    </form>
  </div>
</div>
@endsection

