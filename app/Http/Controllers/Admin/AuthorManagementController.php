<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;


class AuthorManagementController extends Controller
{
    //
    public function index(){
        $authors = Author :: all();
        return view('admin.author',compact('authors'));
    }
}
