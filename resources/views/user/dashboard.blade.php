@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="display-4">Welcome, {{ Auth::user()->first_name }}! 👋</h2>
                            <p class="lead mb-4">Ready to continue your reading journey?</p>
                            @if(isset($lastBook) && $lastBook)
                                <a href="#" class="btn btn-light btn-lg">
                                    <i class="fas fa-book-open me-2"></i>
                                    Continue Reading "{{ $lastBook->title }}"
                                </a>
                            @else
                                <a href="{{ route('books.browse') }}" class="btn btn-light btn-lg">
                                    <i class="fas fa-book me-2"></i>
                                    Start Reading
                                </a>
                            @endif
                        </div>
                        {{-- <div class="col-md-4 text-center">
                            <img src="{{ asset('images/reading-illustration.svg') }}" alt="Reading" class="img-fluid" style="max-height: 200px;">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-book-reader fa-2x text-primary mb-2"></i>
                    <h3 class="h2 mb-0">{{ $currentlyReading ?? 0 }}</h3>
                    <p class="text-muted">Currently Reading</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="h2 mb-0">{{ $completedBooks }}</h3>
                    <p class="text-muted">Books Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3 class="h2 mb-0">{{ $readingHours }}</h3>
                    <p class="text-muted">Reading Hours</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x text-danger mb-2"></i>
                    <h3 class="h2 mb-0">{{ $reviewsCount }}</h3>
                    <p class="text-muted">Reviews Written</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Library Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>My Library 📚</h3>
                <a href="#" class="btn btn-outline-primary">View All</a>
            </div>
            <div class="row">
                @forelse($myBooks ?? [] as $book)
                <div class="col-md-3 mb-3">
                    <div class="card h-100 border-0 shadow-sm book-card">
                        <img src="{{ $book->cover_image }}" class="card-img-top" alt="{{ $book->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text text-muted">{{ $book->author }}</p>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $book->progress }}%"></div>
                            </div>
                            <small class="text-muted">{{ $book->progress }}% completed</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-books fa-3x text-muted mb-3"></i>
                            <h4>Your library is empty</h4>
                            <p class="text-muted">Start your reading journey by adding some books!</p>
                            <a href="{{ route('books.browse') }}" class="btn btn-primary mt-2">
                                Browse Books
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Trending Books -->
    <div class="row mb-4">
        <div class="col-12">
            <h3>Trending Now 🚀</h3>
            @if(isset($trendingBooks) && count($trendingBooks) > 0)
                <div class="row">
                    @foreach($trendingBooks as $book)
                        <div class="col-md-3 mb-4">
                            @include('components.book-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <p class="text-muted">No trending books available at the moment.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <h3>Browse Categories 🎭</h3>
            <div class="row g-3">
                @foreach($categories as $category)
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="#" class="text-decoration-none">
                        <div class="card bg-light border-0 shadow-sm category-card text-center">
                            <div class="card-body">
                                <i class="{{ $category->icon }} fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title mb-0">{{ $category->name }}</h5>
                                <small class="text-muted">{{ $category->books_count }} Books</small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Categories section ends -->
    
    {{-- Commenting out Notifications section
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Notifications 🔔</h5>
                </div>
                <div class="card-body">
                    @forelse($notifications as $notification)
                        <div class="d-flex align-items-center mb-3">
                            <div class="notification-icon me-3">
                                <i class="{{ $notification->icon }} fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $notification->title }}</h6>
                                <p class="text-muted small mb-0">{{ $notification->message }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No new notifications</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    --}}

    {{-- Reading Goals section remains commented out --}}
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<style>
    .book-card {
        transition: transform 0.3s ease;
    }
    .book-card:hover {
        transform: translateY(-5px);
    }
    .category-card {
        transition: all 0.3s ease;
    }
    .category-card:hover {
        background-color: #f8f9fa;
        transform: translateY(-3px);
    }
    .progress-circle {
        width: 150px;
        height: 150px;
        position: relative;
        /* Add more styling for circular progress */
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){
    $('.trending-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 4 }
        }
    });
});
</script>
@endpush
@endsection