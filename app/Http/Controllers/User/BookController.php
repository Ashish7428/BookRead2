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
    public function browse()
    {
        $books = Book::with(['categories', 'author'])
                     ->where('status', 'approved')
                     ->latest()
                     ->paginate(12);
                     
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
}