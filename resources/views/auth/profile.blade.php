@extends('layouts.app')

@section('title', 'My Profile - Vilo Gelato')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-muted mb-4">{{ auth()->user()->email }}</p>
                    
                    <hr class="my-4">
                    
                    <div class="text-start">
                        <label class="small text-uppercase fw-bold text-muted">Username</label>
                        <p class="mb-3">{{ auth()->user()->name }}</p>
                        
                        <label class="small text-uppercase fw-bold text-muted">Email Address</label>
                        <p class="mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="mt-5">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                        <button class="btn btn-primary rounded-pill px-4 ms-2">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection