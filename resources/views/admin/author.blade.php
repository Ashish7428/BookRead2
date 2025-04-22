@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Authors List</h3>
        </div>
        <div class="card-body">
            @if ($authors->isEmpty())
                <div class="alert alert-info">No authors found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Bio</th>
                                <th scope="col">Social Links</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->id }}</td>
                                <td class="fw-bold">{{ $author->full_name }}</td>
                                <td>{{ $author->email }}</td>
                                <td>{{ Str::limit($author->bio, 100) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($author->facebook_url)
                                            <a href="{{ $author->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if($author->twitter_url)
                                            <a href="{{ $author->twitter_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if($author->instagram_url)
                                            <a href="{{ $author->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if($author->linkedin_url)
                                            <a href="{{ $author->linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush
@endsection
