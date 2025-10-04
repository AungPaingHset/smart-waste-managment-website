<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

class AdminUserController extends Controller
{   

    public function index()
    {
        $users = User::with(['articles', 'comments'])
                    ->latest()
                    ->paginate(5);

         foreach ($users as $user) {
            $user->articles_count = $user->articles->count();
            $user->comments_count = $user->comments->count();
        }

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
       $user->load([
            'articles.comments', // eager load comments for articles
            'comments.article'
        ]);

        // Add comments_count to each article
        foreach ($user->articles as $article) {
            $article->comments_count = $article->comments->count();
        }

        return view('admin.users.show', compact('user'));
    }

    public function articles()
    {
        $articles = Article::with(['user', 'comments'])
                    ->latest()
                    ->paginate(5);

        foreach ($articles as $article) {
            $article->comments_count = $article->comments->count();
        }

        return view('admin.articles.index', compact('articles'));
    }

    public function showArticle(Article $article)
    {
        $article->load(['user', 'comments.user']);

        return view('admin.articles.show', compact('article'));
    }

    public function comments()
    {
        $comments = Comment::with(['user', 'article'])
                          ->latest()
                          ->paginate(5);

        return view('admin.comments.index', compact('comments'));
    }

     public function showComment(Comment $comment)
    {
        $comment->load(['user', 'article']);

        return view('admin.comments.show', compact('comment'));
    }

    public function deleteArticle(Article $article)
    {   
        $article->comments()->delete();
        $article->delete();
        return redirect()->route('admin.articles')->with('success', 'Article deleted successfully.');
    }

//     public function bulkDelete(Request $request)
//     {
//     $ids = $request->input('ids');

//     if (!$ids || !is_array($ids)) {
//         return redirect()->back()->with('error', 'No articles selected.');
//     }

//     Article::whereIn('id', $ids)->delete();

//     return redirect()->back()->with('success', 'Selected articles have been deleted successfully.');
// }


    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}