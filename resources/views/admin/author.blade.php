@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1>Authors List</h1>

    @if ($authors->isEmpty())
        <p>No authors found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Bio</th>
                    <th>Profile Image</th>
                    <th>Social Links</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->full_name }}</td>
                    <td>{{ $author->email }}</td>
                    <td>{{ $author->bio }}</td>
                    <td>
                        @if($author->profile_image)
                            <img src="{{ asset('storage/' . $author->profile_image) }}" width="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ $author->facebook_url }}" target="_blank">FB</a> |
                        <a href="{{ $author->twitter_url }}" target="_blank">Twitter</a> |
                        <a href="{{ $author->instagram_url }}" target="_blank">Instagram</a> |
                        <a href="{{ $author->linkedin_url }}" target="_blank">LinkedIn</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
