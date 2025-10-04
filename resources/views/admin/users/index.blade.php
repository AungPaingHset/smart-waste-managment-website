@extends('admin.layouts.navbar')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-users me-2"></i>
                    Users Management
                </h1>
            </div>
        </div>
    </div>

   

                                    

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                
               
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                   
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                 
                                    <th>Posts</th>
                                    <th>Comments</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    
                                    <td class="fw-bold">#{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                
                                        </div>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                            {{ $user->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $user->articles_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info rounded-pill">
                                            {{ $user->comments_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $user->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <p class="mb-0">No users found</p>
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
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {{ $users->links() }}
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
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
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