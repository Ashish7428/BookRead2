@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Browse Books</h2>
            <p class="text-muted">Discover your next favorite book</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filters</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sort By</label>
                            <select class="form-select">
                                <option value="latest">Latest</option>
                                <option value="popular">Most Popular</option>
                                <option value="rating">Highest Rated</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="col-md-9">
            <div class="row">
                @forelse($books as $book)
                    <div class="col-md-4 mb-4">
                        @include('components.book-card', ['book' => $book])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No books available at the moment.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .book-card {
        transition: transform 0.3s ease;
    }
    .book-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
@endsection