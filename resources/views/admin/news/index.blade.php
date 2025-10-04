@extends('admin.layouts.navbar')

@section('title', 'News Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-newspaper me-2"></i>
            News Management
        </h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create News
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if($news->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th >Image</th>
                                <th>Title & Content</th>
                                <th >Created</th>
                                <th >Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $item)
                            <tr>
                                <td class="fw-bold">#{{ $item->id }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" 
                                             alt="{{ $item->title }}" 
                                             class="img-thumbnail" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <h6 class="mb-1">{{ $item->title }}</h6>
                                    <small class="text-muted">{{ Str::limit($item->content, 80) }}</small>
                                </td>
                                
                                <td>
                                    <small>{{ $item->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.news.show', $item) }}" 
                                            class="btn btn btn-outline-info" 
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                         <a href="{{ route('admin.news.edit', $item) }}" 
                                            class="btn btn btn-outline-warning" 
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form method="POST" 
                                            action="{{ route('admin.news.destroy', $item) }}" 
                                            class="d-inline" 
                                            onsubmit="return confirm('Are you sure you want to delete this news?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h4>No News Found</h4>
                    <p class="text-muted">Start by creating your first news article.</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create News
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection