@extends('admin.layouts.navbar')

@section('title', 'News Details - ' . $news->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-newspaper me-2"></i>
            News Details
        </h1>
        <div class="btn-group">
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to News
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <!-- News Image -->
                    @if($news->image)
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 300px; width: auto;">
                    </div>
                    @endif

                    <!-- News Title -->
                    <h2 class="mb-3">{{ $news->title }}</h2>

                    <!-- News Point -->
                    <h2 class="mb-3">{{ $news->point }} points</h2>

                    <!-- News Content -->
                    <div class="news-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- News Information -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        News Information
                    </h6>
                </div>
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>Created:</strong></div>
                        <div class="col-sm-7">{{ $news->created_at->format('M d, Y') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>Updated:</strong></div>
                        <div class="col-sm-7">{{ $news->updated_at->format('M d, Y') }}</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5"><strong>Word Count:</strong></div>
                        <div class="col-sm-7">{{ str_word_count($news->content) }} words</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-1"></i>
                        Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit News
                        </a>
                        
                        
                            <form method="POST" action="{{ route('admin.news.update', $news) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $news->title }}">
                                <input type="hidden" name="content" value="{{ $news->content }}">
                            </form>
                        
                        
                        <form method="POST" action="{{ route('admin.news.destroy', $news) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this news? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete News
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection