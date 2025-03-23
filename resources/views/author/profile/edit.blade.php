@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('author.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                id="full_name" name="full_name" value="{{ old('full_name', $author->full_name) }}" required>
                            @error('full_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $author->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" name="phone" value="{{ old('phone', $author->phone) }}" 
                                pattern="[0-9]{10}" maxlength="10" required>
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username', $author->username) }}" required>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                id="bio" name="bio" rows="4" maxlength="500" 
                                placeholder="Tell readers about yourself (max 500 characters)">{{ old('bio', $author->bio) }}</textarea>
                            <div class="form-text">
                                <span id="bio-counter">0</span>/500 characters
                            </div>
                            @error('bio')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3">Social Media Links</h5>

                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">
                                <i class="fab fa-facebook text-primary me-2"></i>Facebook Profile URL
                            </label>
                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $author->facebook_url) }}">
                            @error('facebook_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">
                                <i class="fab fa-twitter text-info me-2"></i>Twitter Profile URL
                            </label>
                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $author->twitter_url) }}">
                            @error('twitter_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">
                                <i class="fab fa-instagram text-danger me-2"></i>Instagram Profile URL
                            </label>
                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $author->instagram_url) }}">
                            @error('instagram_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label">
                                <i class="fab fa-linkedin text-primary me-2"></i>LinkedIn Profile URL
                            </label>
                            <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $author->linkedin_url) }}">
                            @error('linkedin_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <a href="{{ route('author.profile') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');

    const updateCharacterCount = () => {
        const currentLength = bioTextarea.value.length;
        bioCounter.textContent = currentLength;
    };

    // Update on input
    bioTextarea.addEventListener('input', updateCharacterCount);
    bioTextarea.addEventListener('keyup', updateCharacterCount);
    bioTextarea.addEventListener('paste', updateCharacterCount);

    // Initial count on page load
    updateCharacterCount();
});
</script>
@endsection