@extends('admin.layouts.navbar')

@section('title', 'Edit News - ' . $news->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>
            Edit News
        </h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to News
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $news->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="6" 
                                      required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Point -->
                        <div class="mb-3">
                            <label for="point" class="form-label">Points <span class="text-danger">*</span></label>
                            <input type="number" 
                                class="form-control @error('point') is-invalid @enderror" 
                                id="point" 
                                name="point" 
                                value="{{ old('point', $news->point ?? '') }}" 
                                min="0" 
                                step="1" 
                                required>
                            @error('point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($news->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div>
                                <img src="{{ asset('storage/' . $news->image) }}" 
                                     alt="{{ $news->title }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                            </div>
                        </div>
                        @endif

                        <!-- New Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                {{ $news->image ? 'Change Image' : 'Add Image' }}
                            </label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported formats: PNG, SVG. Max size: 2MB</div>
                        </div>

                        <!-- New Image Preview -->
                        <div class="mb-3" id="imagePreview" style="display: none;">
                            <label class="form-label">New Image Preview</label>
                            <div>
                                <img id="preview" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>

                        

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update News
                            </button>
                            <a href="{{ route('admin.news.show', $news) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        News Details
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Created:</strong> {{ $news->created_at->format('M d, Y g:i A') }}</p>
                    <p class="mb-1"><strong>Last Updated:</strong> {{ $news->updated_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-1"></i>
                        Tips
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Keep titles concise and descriptive
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use paragraphs for better readability
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
});
</script>
@endsection