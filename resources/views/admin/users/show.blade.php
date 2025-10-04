@extends('admin.layouts.navbar')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user me-2"></i>
            User Details: {{ $user->name }}
        </h1>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Users
        </a>
    </div>

    <div class="row">
        <!-- User Info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5>User Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                    <p><strong>Total Articles:</strong> {{ $user->articles->count() }}</p>
                    <p><strong>Total Comments:</strong> {{ $user->comments->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Articles -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5>Articles ({{ $user->articles->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($user->articles as $article)
                    <div class="border-bottom pb-3 mb-3">
                        <h6>
                            <a href="{{ route('admin.articles.show', $article) }}">
                                {{ Str::limit($article->body, 60) }}
                            </a>
                        </h6>
                        <p class="text-muted mb-1">{{ Str::limit($article->content, 100) }}</p>
                        <small class="text-muted">
                            {{ $article->created_at->format('M d, Y') }} • 
                            {{ $article->comments_count ?? 0 }} comments
                        </small>
                    </div>
                    @empty
                    <p class="text-muted">No articles found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Comments -->
            <div class="card shadow">
                <div class="card-header">
                    <h5>Comments ({{ $user->comments->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($user->comments as $comment)
                    <div class="border-bottom pb-3 mb-3">
                        <p>{{ Str::limit($comment->content, 150) }}</p>
                        <small class="text-muted">
                            On: 
                            @if($comment->article)
                            <a href="{{ route('admin.articles.show', $comment->article->id) }}">
                                {{ Str::limit($comment->article->body, 50) }}
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