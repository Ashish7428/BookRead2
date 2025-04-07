@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $book->title }}</h4>
                    <div class="page-info">
                        Page {{ $currentPage }} of {{ $pageCount }}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="pdf-container" style="height: 800px;">
                        <iframe src="{{ route('books.page', ['book' => $book->id, 'page' => $currentPage]) }}" 
                                frameborder="0" 
                                width="100%" 
                                height="100%"
                                id="pdfFrame">
                        </iframe>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/books/' . $book->id . '/read?page=' . max(1, $currentPage - 1)) }}" 
                           class="btn btn-secondary {{ $currentPage <= 1 ? 'disabled' : '' }}"
                           id="prevBtn">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                        <span class="mx-3">Page {{ $currentPage }} of {{ $pageCount }}</span>
                        <a href="{{ url('/books/' . $book->id . '/read?page=' . min($pageCount, $currentPage + 1)) }}" 
                           class="btn btn-primary {{ $currentPage >= $pageCount ? 'disabled' : '' }}"
                           id="nextBtn">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = {{ $currentPage }};
    const totalPages = {{ $pageCount }};
    const pageInfo = document.querySelector('.page-info');
    
    // Update page info when navigation occurs
    function updatePageInfo(page) {
        pageInfo.textContent = `Page ${page} of ${totalPages}`;
    }

    // Refresh iframe when page changes
    function refreshPdfView(page) {
        const iframe = document.getElementById('pdfFrame');
        iframe.src = "{{ route('books.page', ['book' => $book->id]) }}/" + page;
        updatePageInfo(page);
    }
});
</script>
@endpush

@push('styles')
<style>
.pdf-container {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}
.page-info {
    font-size: 1rem;
    font-weight: normal;
}
</style>
@endpush
@endsection