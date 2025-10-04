<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Comment;

class AdminDashboardController extends Controller
{   
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => Admin::count(),
            'total_posts' => Article::count(),
            'total_comments' => Comment::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_articles' => Article::with('user')->latest()->take(5)->get(),
            'recent_comments' => Comment::with(['user', 'article'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}