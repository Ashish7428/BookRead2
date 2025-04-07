<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingProgress;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Reading Statistics
        $currentlyReading = ReadingProgress::where('user_id', $user->id)
            ->where('status', 'reading')
            ->count();
            
        $completedBooks = ReadingProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
            
        $readingHours = ReadingProgress::where('user_id', $user->id)
            ->sum('reading_time') ?? 0;
            
        $reviewsCount = $user->reviews()->count() ?? 0;
        
        // Last Book
        $lastBook = ReadingProgress::where('user_id', $user->id)
            ->where('status', 'reading')
            ->latest()
            ->first()?->book;
            
        // My Books
        $myBooks = ReadingProgress::where('user_id', $user->id)
            ->with('book')
            ->latest()
            ->take(4)
            ->get();
            
        // Trending Books
        $trendingBooks = Book::join('authors', 'books.author_id', '=', 'authors.id')
            ->select('books.*', 'authors.full_name as author_name')
            ->where('status', 'approved')
            ->orderBy('views', 'desc')
            ->take(6)
            ->get();
            
        // Categories
        $categories = Category::withCount('books')
            ->get();
            
        // Comment out Reading Goals section
        // $yearlyGoal = $user->reading_goal ?? 12;
        // $booksRead = $completedBooks;
        // $goalProgress = $yearlyGoal > 0 ? round(($booksRead / $yearlyGoal) * 100) : 0;

        // Remove or comment out this line
        // $notifications = collect([]);

        return view('user.dashboard', compact(
            'currentlyReading',
            'completedBooks',
            'readingHours',
            'reviewsCount',
            'lastBook',
            'myBooks',
            'trendingBooks',
            'categories'
            // 'notifications' removed from here
        ));
    }
}