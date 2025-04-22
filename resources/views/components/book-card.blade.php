<div class="card h-100 book-card">
    <img src="{{ asset($book->cover_image ?? 'images/default-book-cover.jpeg') }}" 
         class="card-img-top"
         alt="{{ $book->title }}"
         style="height: 350px; object-fit: cover;">
    <div class="card-body">
        <h5 class="card-title">{{ $book->title }}</h5>
        <p class="card-text text-muted mb-2">
            @forelse($book->categories as $category)
                <span class="badge bg-secondary me-1">{{ $category->name }}</span>
            @empty
                <span class="badge bg-warning text-dark">
                    <i class="fas fa-exclamation-circle me-1"></i>No Category
                </span>
            @endforelse
        </p>
        <div class="description-container">
            <p class="card-text description-text mb-1">{{ Str::limit($book->description, 100) }}</p>
            @if(strlen($book->description) > 100)
                <a href="#" class="text-primary see-more" data-bs-toggle="modal" data-bs-target="#description-{{ $book->id }}">
                    See more...
                </a>
            @endif
        </div>
        <p class="card-text">
            <small class="text-muted">By {{ $book->author_name ?? ($book->author->full_name ?? 'Unknown Author') }}</small>
        </p>
    </div>
    <div class="card-footer d-flex gap-2">
        <a href="{{ route('books.show', $book) }}" class="btn btn-outline-light flex-grow-1 anchor-custom">
            Read Now
        </a>
        <button class="btn btn-outline-dark bookmark-btn {{ $book->bookmarks->where('user_id', auth()->id())->count() ? 'active' : '' }}" 
                onclick="toggleBookmark({{ $book->id }}, this)">
            <i class="bookmark-icon {{ $book->bookmarks->where('user_id', auth()->id())->count() ? 'fas' : 'far' }} fa-bookmark"></i>
        </button>
    </div>
</div>

@push('styles')
<style>
    .description-container {
        min-height: 60px;
    }
    .description-text {
        margin-bottom: 0.25rem;
    }
    .see-more {
        font-size: 0.875rem;
        text-decoration: none;
    }
    .see-more:hover {
        text-decoration: underline;
    }

    .anchor-custom {
           background-color: #000000; 
    }
    .anchor-custom:hover {
        color: rgb(0, 0, 0);
        background-color: #ffffff;
        outline:2px double #2c3e50;
   }
    .bookmark-btn {
        border-color: #000;
        color: #000;
    }
    .bookmark-btn:hover {
        background-color: transparent;
        color: #000;
    }
    .bookmark-btn.active .bookmark-icon {
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleBookmark(bookId, btn) {
        fetch(`/bookmark/${bookId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const icon = btn.querySelector('.bookmark-icon');
            btn.classList.toggle('active');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush

<!-- Description Modal -->
@if(strlen($book->description) > 100)
    <div class="modal fade" id="description-{{ $book->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $book->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $book->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endif