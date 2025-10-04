<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use App\Models\Article;


class ArticleController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {
        $data = Article::latest()->paginate(3);

        return view("articles.index", [
            "articles" => $data,
        ]);
    }

    public function detail($id)
    {
       $article = Article::find($id);

       return view("articles.detail", [
        "article" => $article,
    ]);


    }

    public function edit($id)
    {
        return view("articles.edit", [
            "article" => Article::find($id)
        ]);
    }


    public function delete($id)
    {
       $article = Article::find($id);
       
       if( Gate::allows('delete-comment', $article) ) {
            $article->delete();
            return redirect("/articles")->with("info", "Article Deleted");
       }
       return back()->with('info', 'Unauthorize');
    }

    public function add(){
        
        return view("articles.add");
    }

    public function create(){
        $validator = validator(request()->all() ,
        [
           'body' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $article = new Article;
        $article->body = request()->body;
        $article->user_id = auth()->id();
        $article->save();

        return redirect("/articles");
    }

    public function update($id){
        $validator = validator(request()->all() ,
        [
           'body' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $article = Article::find($id);
        $article->body = request()->body;
        $article->user_id = auth()->id();
        $article->save();

        return redirect("/articles")->with("info", "Article Edited");;
    }


}
