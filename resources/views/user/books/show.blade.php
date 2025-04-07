@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Book Cover and Primary Details -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="{{ asset($book->cover_image ?? 'images/default-book-cover.jpg') }}" 
                     class="card-img-top"
                     alt="{{ $book->title }}"
                     style="height: 400px; object-fit: cover;">
                <div class="card-body text-center">
                    <a href="{{ route('books.read', ['book' => $book->id]) }}" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="fas fa-book-reader me-2"></i>Read Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="col-md-8">
            <h2 class="mb-3">{{ $book->title }}</h2>
            
            <!-- Categories -->
            <div class="mb-3">
                @forelse($book->categories as $category)
                    <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                @empty
                    <span class="badge bg-warning text-dark">No Category</span>
                @endforelse
            </div>

            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">About this book</h5>
                    <p class="card-text">{{ $book->description }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Publication Year:</strong></p>
                            <p class="text-muted">{{ $book->publication_year }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author Details -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">About the Author</h5>
                    <div class="d-flex align-items-center mb-3">
                        @if($book->author->profile_image)
                            <img src="{{ asset('storage/' . $book->author->profile_image) }}" 
                                 alt="{{ $book->author->full_name }}"
                                 class="rounded-circle me-3"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $book->author->full_name }}</h5>
                            <p class="text-muted mb-0">Author</p>
                        </div>
                    </div>
                    <p class="card-text">{{ $book->author->bio ?: 'No biography available.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .book-details {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endpush
@endsection