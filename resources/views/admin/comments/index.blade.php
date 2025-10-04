@extends('admin.layouts.navbar')

@section('title', 'Comments Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-comments me-2"></i>
                    Comments Management
                </h1>
            </div>
        </div>
    </div>

   

                                    

    <!-- Comments Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                
                   
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    
                                    <th>ID</th>
                                    <th>Content</th>
                                    <th>Author</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($comments as $comment)
                                <tr>
                                    
                                    <td class="fw-bold">#{{ $comment->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                {{-- <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span> --}}
                                                </div>
                                            </div>
                                            <div>
                                                
                                                <div class="text-muted small">{{ Str::limit($comment->content, 25) }}</div>
                                           
                                        </div>
                                    </td> 
                                    <td>
                                        <div>
                                        <div class="fw-bold">{{ $comment->user->name }}</div>
                                        <div class="text-muted small">{{ Str::limit($comment->user->email, 25) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            {{ $comment->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.comments.show', $comment) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                           
                                        <form method="POST" action="{{ route('admin.comments.delete', $comment) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"class="btn btn-sm btn-outline-danger" 
                                                    {{-- title="Delete User" --}}
                                                    href=""
                                                    onclick="confirmDelete({{ $comment->id }})">
                                                <i class="fas fa-trash"></i>
                                        </button> 
                                    </form>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <p class="mb-0">No comments found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $comments->firstItem() ?? 0 }} to {{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} results
                        </div>   
                    </div>
                </div>
            </div>
             <div>
             {{ $comments->links() }}
            </div>
        </div>
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

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.025);
}

.avatar {
    flex-shrink: 0;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Update select all checkbox when individual checkboxes change
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === userCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
        });
    });
});

function confirmDelete(userId) {
    if (confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection






