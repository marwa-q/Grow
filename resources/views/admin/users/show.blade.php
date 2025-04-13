<!-- resources/views/admin/users/show.blade.php -->
@extends('admin.layout')

@section('title', 'User Details')

@section('page-title', 'User Details')

@section('styles')
<style>
    .user-detail-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .user-detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    
    .profile-img-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }
    
    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .user-role-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .user-details-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.05);
        border: none;
    }
    
    .user-details-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        padding: 12px 20px;
        color: #495057;
        width: 200px;
    }
    
    .user-details-table td {
        padding: 12px 20px;
        border-top: 1px solid #f1f1f1;
        vertical-align: middle;
        color: #333;
        font-weight: 500;
    }
    
    .user-details-table tr:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .back-button:hover {
        transform: translateX(-5px);
    }
    
    .action-button {
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .action-button i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary back-button">
            <i class="fas fa-arrow-left me-2"></i> Back to Users List
        </a>
    </div>

    <div class="user-detail-card card">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">User Information: {{ $user->full_name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="profile-img-container mb-3">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" class="profile-img">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=random" class="profile-img">
                        @endif
                        <span class="user-role-badge {{ $user->isAdmin() ? 'bg-primary' : 'bg-secondary' }} text-white">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <h4 class="mt-3">{{ $user->full_name }}</h4>
                </div>
                
                <div class="col-md-8">
                    <table class="table user-details-table">
                        <tbody>
                            <tr>
                                <th>
                                    <i class="fas fa-user text-primary me-2"></i> First Name
                                </th>
                                <td>{{ $user->first_name }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-user text-primary me-2"></i> Last Name
                                </th>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-envelope text-info me-2"></i> Email
                                </th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-phone text-success me-2"></i> Phone
                                </th>
                                <td>{{ $user->phone ?: 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-user-tag text-warning me-2"></i> Role
                                </th>
                                <td>{{ ucfirst($user->role) }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-calendar-plus text-danger me-2"></i> Registration Date
                                </th>
                                <td>{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-edit text-secondary me-2"></i> Last Update
                                </th>
                                <td>{{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i') : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning action-button">
                            <i class="fas fa-edit me-1"></i> Edit User
                        </a>
                        
                        <button type="button" class="btn btn-danger action-button" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash me-1"></i> Delete User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                </div>
                <p class="text-center fs-5">Are you sure you want to delete the user <strong>{{ $user->full_name }}</strong>?</p>
                <p class="text-center text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection