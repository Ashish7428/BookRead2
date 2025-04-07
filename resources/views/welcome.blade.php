@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="display-4">Welcome to Book Reader</h1>
        <p class="lead text-muted">Your gateway to endless knowledge and reading pleasure</p>
    </div>

    <div class="row">
        @foreach($books as $book)
            <div class="col-md-3 mb-4">
                @include('components.book-card', ['book' => $book])
            </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
.book-card {
    transition: transform 0.3s ease;
    height: 100%;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.book-card .card-img-top {
    height: 200px;
    object-fit: cover;
}
.book-card .card-body {
    padding: 1rem;
}
.categories {
    margin-top: 0.5rem;
}
.categories .badge {
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
}
</style>
@endpush
@endsection