{{-- @extends("layouts.app")
@section("content")
    <div class="container" style="max-width:800px">
        
            <div class="card mb-2">
                <div class="card-body border-primary">
                    <div class="text-muted">
                        <b class="text-success">{{ $article->user->name }}</b>
                            {{ $article->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div style="font-size: 1.1em"> 
                        {{ $article->body }}
                    </div>
                    @auth
                        @can('delete-article', $article)
                        <div class="mt-2">
                            <a href="{{ url("/articles/delete/$article->id")}}" class="btn btn-sm btn-outline-danger">Delete</a>
                            <a href="{{ url("/articles/edit/$article->id")}}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </div>
                        @endcan
                    @endauth
                </div>
            </div>
        
            <ul class="list-group mt-4">
                <li class="list-group-item active">
                    Comments ({{ count($article->comments )}})
                </li>
                @foreach($article->comments as $comment)
                    <li class="list-group-item">

                        @auth
                            @can('delete-comment', $comment)
                            <a href="{{ url("/comments/delete/$comment->id")}}" class="btn-close float-end"></a>
                            @endcan
                        @endauth
                        <b class="text-success">{{ $comment->user->name }}</b> -
                        {{ $comment->content }}
                    </li>
                @endforeach
            </ul>

            @auth
            <form action="{{ url("/comments/add")}}" method="post">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <textarea name="content" id="" class="form-control mb-2"></textarea>
                <button class="btn btn-secondary">Add Comment</button>
            </form>
            @endauth
    </div>
    @endsection --}}


@extends("layouts.app")
@section("content")

<style>
    #glass-btn {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.141) !important;
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
</style>
<div class="main-container my-5 py-5">
<div class="post-card">
    <div class="post-header">
        <div class="user-info">
            <a href="#" class="user-name">{{ $article->user->name }}</a>
            <span class="post-time">{{ $article->created_at->diffForHumans() }}</span>
        </div>

        @auth
        @can('delete-article', $article)
        <div class="dropdown">
            <a class="text-success fw-bolder" href="#" data-bs-toggle="dropdown" style="text-decoration: none;">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-start" id="glass-btn">
                <li>
                    <a class="dropdown-item delete" href="{{ url("/articles/delete/$article->id") }}">
                        Delete
                    </a>
                </li>
                <li>
                    <a class="dropdown-item edit" href="{{ url("/articles/edit/$article->id") }}">
                        Edit
                    </a>
                </li>
            </ul>
        </div>
        @endcan
        @endauth
    
</div>

        
        <div class="post-content">
            {{ $article->body }}
        </div>
        
        {{-- @auth
            @can('delete-article', $article)
            <div class="post-actions">
                <a href="{{ url("/articles/delete/$article->id")}}" class="action-btn delete">
                    Delete
                </a>
                <a href="{{ url("/articles/edit/$article->id")}}" class="action-btn edit">
                    Edit
                </a>
            </div>
            @endcan
        @endauth --}}
        
        
    </div>

    <div class="comments-section">
        <div class="comments-header">
            Comments ({{ count($article->comments )}})
        </div>
        
        @foreach($article->comments as $comment)
            <div class="comment-item">
                @auth
                    @can('delete-comment', $comment)
                    <a href="{{ url("/comments/delete/$comment->id")}}" class="comment-delete">×</a>
                    @endcan
                @endauth
                
                <div>
                    <span class="comment-author">{{ $comment->user->name }}</span>
                    <span class="comment-content">{{ $comment->content }}</span>
                </div>
            </div>
        @endforeach
    </div>

    
    @auth
    <div class="comment-form">
        <form action="{{ url("/comments/add")}}" method="post">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <textarea name="content" class="comment-textarea" placeholder="Write a comment..." required></textarea>
    @endauth
        <a href="{{ url('/articles') }}" class="action-btn" style="margin-bottom: 16px; display: inline-block;">
            ← Back to Articles
        </a>
    @auth
            <button type="submit" class="submit-btn">Post</button>
        </form>
    </div>
    @endauth
</div>
@endsection
    