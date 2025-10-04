@extends('admin.layouts.navbar')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard Overview
                </h1>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ now()->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_users'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Articles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_posts'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Comments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_comments'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Users -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{-- <i class="fas fa-users me-2"></i> --}}
                        Recent Users
                    </h6>
                    <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_users']) && count($stats['recent_users']) > 0)
                        @foreach($stats['recent_users'] as $user)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="avatar me-3">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                            </div>
                            {{-- <div class="text-muted small">
                                {{ $user->created_at->diffForHumans() }}
                            </div> --}}
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>No recent users found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        {{-- <i class="fas fa-newspaper me-2"></i> --}}
                        Recent Articles
                    </h6>
                    <a href="{{ route('admin.articles') }}" class="btn btn-success btn-sm"><i class="fas fa-eye me-1"></i>
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_articles']) && count($stats['recent_articles']) > 0)
                        @foreach($stats['recent_articles'] as $article)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="fw-bold mb-1">
                                {{ Str::limit($article->title ?? $article->body, 40) }}
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-user me-1"></i>
                                by {{ $article->user->name ?? 'Unknown' }}
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-clock me-1"></i>
                                {{ $article->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-newspaper fa-3x mb-3"></i>
                            <p>No recent articles found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-info">
                        {{-- <i class="fas fa-comments me-2"></i> --}}
                        Recent Comments
                    </h6>
                    <a href="{{ route('admin.comments') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_comments']) && count($stats['recent_comments']) > 0)
                        @foreach($stats['recent_comments'] as $comment)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="fw-bold mb-1">
                                {{ Str::limit($comment->content, 50) }}
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-user me-1"></i>
                                by {{ $comment->user->name ?? 'Anonymous' }}
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>No recent comments found</p>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Additional Row for Charts or Other Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-area me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-user-plus fa-2x mb-2 d-block"></i>
                                Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.articles') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                                Create Article
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.comments') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="fas fa-comment-dots fa-2x mb-2 d-block"></i>
                                Review Comments
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-warning w-100 py-3">
                                <i class="fas fa-cog fa-2x mb-2 d-block"></i>
                                Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>
@endsection