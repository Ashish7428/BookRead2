@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Books</h2>
        <a href="{{ route('author.books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Upload New Book
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($books as $book)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 250px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="fas fa-book fa-4x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <!-- Replace the single genre display with -->
                        <p class="card-text text-muted mb-2">
                            @foreach($book->genres as $genre)
                                <span class="badge bg-secondary me-1">{{ $genre->name }}</span>
                            @endforeach
                        </p>
                        <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $book->status === 'approved' ? 'success' : ($book->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($book->status) }}
                            </span>
                            <small class="text-muted">{{ $book->publication_year }}</small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="{{ route('author.books.edit', $book) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('author.books.destroy', $book) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-books fa-3x text-muted mb-3"></i>
                    <p class="h5 text-muted">You haven't uploaded any books yet.</p>
                    <a href="{{ route('author.books.create') }}" class="btn btn-primary mt-3">
                        Upload Your First Book
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection