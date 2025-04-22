<div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach($books as $book)
            <div class="col">
                <x-book-card :book="$book" />
            </div>
        @endforeach
    </div>
</div>