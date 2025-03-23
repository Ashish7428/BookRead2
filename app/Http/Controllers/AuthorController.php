<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'username' => 'required|string|max:255|unique:authors',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $author = Author::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('author.login')
            ->with('success', 'Registration successful! Please login with your credentials.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('author')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/author/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('author')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function dashboard()
    {
        $author = Auth::guard('author')->user();
        $totalBooks = $author->books()->count();
        $pendingBooks = $author->books()->where('status', 'pending')->count();
        $recentBooks = $author->books()->with('author')->latest()->take(5)->get();
        $totalViews = 0; // We'll implement view counting later
        
        return view('author.dashboard', compact('author', 'totalBooks', 'pendingBooks', 'totalViews', 'recentBooks'));
    }

    public function profile()
    {
        $author = Auth::guard('author')->user();
        return view('author.profile.show', compact('author'));
    }

    public function edit()
    {
        $author = Auth::guard('author')->user();
        return view('author.profile.edit', compact('author'));
    }

    public function update(Request $request)
    {
        $author = Auth::guard('author')->user();
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors,email,' . $author->id,
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'username' => 'required|string|max:255|unique:authors,username,' . $author->id,
            'bio' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        $author->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'bio' => $request->bio,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
        ]);

        return redirect()->route('author.profile')
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        return view('author.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $author = Auth::guard('author')->user();
    
        if (!Hash::check($request->current_password, $author->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        $author->update([
            'password' => Hash::make($request->password)
        ]);
    
        return redirect()->route('author.profile')
            ->with('success', 'Password changed successfully.');
    }
}
