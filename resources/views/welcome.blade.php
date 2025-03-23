@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Welcome to E-Library</h1>
            <p class="lead mb-4">Your gateway to endless knowledge and entertainment</p>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Vast Collection</h5>
                            <p class="card-text">Access thousands of books across various genres</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Easy Access</h5>
                            <p class="card-text">Read anywhere, anytime on any device</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Free Registration</h5>
                            <p class="card-text">Join our community of readers today</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mt-3">
    <a href="{{ route('author.login') }}" class="btn btn-outline-primary">
        <i class="fas fa-feather-alt me-2"></i>Author Login
    </a>
</div>
@endsection