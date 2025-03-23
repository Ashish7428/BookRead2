@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Book</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('author.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Book Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Book Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Genres</label>
                            <div class="row g-3 border">
                                @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                name="genres[]" 
                                                value="{{ $category->id }}" 
                                                id="genre{{ $category->id }}"
                                                {{ in_array($category->id, $book->genres->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genre{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('genres')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publication_year" class="form-label">Publication Year</label>
                            <input type="number" class="form-control @error('publication_year') is-invalid @enderror" 
                                id="publication_year" name="publication_year" 
                                value="{{ old('publication_year', $book->publication_year) }}" 
                                min="1900" max="{{ date('Y') }}">
                            @error('publication_year')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Cover Image</label>
                            @if($book->cover_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($book->cover_image) }}" 
                                        alt="Current cover" class="img-thumbnail" style="height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                id="cover_image" name="cover_image" accept="image/jpeg,image/png">
                            <div class="form-text">Max size: 2MB. Formats: JPEG, PNG</div>
                            @error('cover_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <p class="mb-1">Current PDF: {{ basename($book->pdf_path) }}</p>
                            <div class="form-text mb-3">To change the PDF file, please upload a new book.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <a href="{{ route('author.books.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Books
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection