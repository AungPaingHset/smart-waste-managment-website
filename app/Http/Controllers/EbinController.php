<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class EbinController extends Controller
{
    public function index()
    {   
         
        $news = News::latest()->paginate(10);
        return view('ebin.index', compact('news'));
      
    }
}
