@extends('admin.layouts.navbar')

@section('title', 'Article Details - ' . $article->name)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-newspaper me-2"></i>
            Article Details: {{ $article->name }}
        </h1>
        <a href="{{ route('admin.articles') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Articles
        </a>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column: Article Info -->
        <div class="col-md-4 mb-4 " style="max-height: 250px;">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="mb-0">Article Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Author:</strong> {{ $article->user->name }}</p>
                    <p><strong>Published:</strong> {{ $article->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $article->updated_at->format('M d, Y') }}</p>
                    <p><strong>Total Comments:</strong> {{ $article->comments->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Content and Comments -->
        <div class="col-md-8">
            <!-- Article Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Content</h5>
                </div>
                <div class="card-body">
                    <div class="article-content">
                        {!! nl2br(e($article->body)) !!}
                    </div>
                </div>
            </div>

            <!-- Comments Card -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Comments ({{ $article->comments->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($article->comments as $comment)
                        <div class="border-bottom pb-3 mb-3">
                            <p>{{ Str::limit($comment->content, 150) }}</p>
                            <small class="text-muted">
                                By:
                                @if($comment->user)
                                    <a href="{{ route('admin.users.show', $comment->user) }}">
                                        {{ $comment->user->name }}
                                    </a> • 
                                @endif
                                {{ $comment->created_at->format('M d, Y') }}
                            </small>
                        </div>
                    @empty
                        <p class="text-muted">No comments found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
