<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class BookController extends Controller
{
    public function browse(Request $request)
    {
        $query = Book::with(['categories', 'author'])
                     ->where('status', 'approved');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $books = $query->latest()->paginate(6)->withQueryString();
        $categories = Category::all();
                         
        return view('user.books.browse', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book = Book::with(['categories', 'author'])
            ->where('id', $book->id)
            ->first();
        
        return view('user.books.show', compact('book'));
    }

    public function read(Book $book)
    {
        $pdfPath = base_path('public/storage/' . $book->pdf_path);
        $currentPage = max(1, request()->query('page', 1));
        
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($pdfPath);
        
        // Ensure current page doesn't exceed total pages
        $currentPage = min($currentPage, $pageCount);
        
        return view('user.books.read', compact('book', 'currentPage', 'pageCount'));
    }

    public function getPage(Book $book, $page)
    {
        // Update PDF path with absolute path
        $pdfPath = base_path('public/storage/' . $book->pdf_path);
        
        // Ensure page number is valid
        $page = max(1, min($page, $this->getPageCount($pdfPath)));
        
        // Create PDF instance
        $pdf = new Fpdi();
        $pdf->setSourceFile($pdfPath);
        $pdf->AddPage();
        $pdf->useTemplate($pdf->importPage($page));
        
        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf');
    }

    private function getPageCount($pdfPath)
    {
        $pdf = new Fpdi();
        return $pdf->setSourceFile($pdfPath);
    }
    public function saveProgress(Request $request, Book $book)
    {
        $user = auth()->user();
        $user->bookProgress()->updateOrCreate(
            ['book_id' => $book->id],
            ['last_page' => $request->page]
        );
        return response()->json(['success' => true]);
    }

}