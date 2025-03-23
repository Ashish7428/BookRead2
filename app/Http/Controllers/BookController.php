<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;  // Add this at the top with other use statements
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = auth('author')->user()->books()->latest()->get();
        return view('author.books.index', compact('books'));
    }

    public function create()
    {
        $genres = Category::orderBy('name')->get();
        return view('author.books.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'genres' => 'required|array|exists:categories,id',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'cover_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'pdf_file' => 'required|mimes:pdf|max:20480'
        ]);

        $book = new Book();
        $book->author_id = auth()->id();
        $book->title = $validatedData['title'];
        $book->slug = Str::slug($validatedData['title']);
        $book->description = $validatedData['description'];
        $book->publication_year = $validatedData['publication_year'];

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $coverPath;
        }

        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
            $book->pdf_path = $pdfPath;
        }

        $book->save();
        $book->genres()->attach($request->genres);

        return redirect()->route('author.books.index')
            ->with('success', 'Book uploaded successfully!');
    }

    public function edit(Book $book)
    {
        // Check if the logged-in author owns this book
        if (auth('author')->id() !== $book->author_id) {
            abort(403);
        }

        $genres = Category::orderBy('name')->get();
        return view('author.books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        // Check if the logged-in author owns this book
        if (auth('author')->id() !== $book->author_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genres' => 'required|array|exists:categories,id',  // Updated validation
            'cover_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'publication_year' => 'nullable|date_format:Y|before_or_equal:' . date('Y'),
        ]);

        $data = $request->only(['title', 'description', 'publication_year']);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        $book->update($data);
        $book->genres()->sync($request->genres);  // Update genres relationship

        return redirect()->route('author.books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        // Check if the logged-in author owns this book
        if (auth('author')->id() !== $book->author_id) {
            abort(403);
        }

        // Delete the physical files first
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        Storage::disk('public')->delete($book->pdf_path);

        // Delete the database record
        $book->delete();

        return redirect()->route('author.books.index')
            ->with('success', 'Book deleted successfully.');
    }
}