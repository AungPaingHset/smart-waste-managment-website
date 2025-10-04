@extends('admin.layouts.navbar')

@section('title', 'Comment Details - ' . $comment->name)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-comment me-2"></i>
            Comment Details: {{ $comment->id}}
        </h1>
        <a href="{{ route('admin.comments') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to comments
        </a>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column: comment Info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="mb-0">Comment Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Author:</strong> {{ $comment->user->name }}</p>
                    <p><strong>Commented:</strong> {{ $comment->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $comment->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Content and Comments -->
        <div class="col-md-8">
            <!-- comment Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Content</h5>
                </div>
                <div class="card-body">
                    <div class="comment-content">
                        {!! nl2br(e($comment->content)) !!}
                    </div>
                </div>
            </div>

            <!-- Comments Card -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Article</h5>
                </div>
                <div class="card-body">
                    <div class=" pb-3 mb-3">
                       <p>{{ Str::limit($comment->article->body, 150) }}</p>
                        <small class="text-muted">
                            By: 
                            @if($comment->article)
                            <a href="{{ route('admin.users.show', $comment->user->id) }}">
                                {{ $comment->article->user->name }}
                            </a> • 
                            @endif
                            {{ $comment->article->created_at->format('M d, Y') }}
                        </small>

                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
