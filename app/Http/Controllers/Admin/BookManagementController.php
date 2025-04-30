<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query()->with('author');
        
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('author', function($q) use ($searchTerm) {
                      $q->where('full_name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        $books = $query->latest()->get();
        return view('admin.books.index', compact('books'));
    }

    public function approve(Book $book)
    {
        $book->update(['status' => 'approved']);
        return redirect()->route('admin.books.index')
            ->with('success', 'Book has been approved successfully.');
    }

    public function reject(Book $book)
    {
        $book->update(['status' => 'rejected']);
        return redirect()->route('admin.books.index')
            ->with('success', 'Book has been rejected.');
    }
}