@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'User Details',
        'subtitle' => 'View user information',
        'button' => [
            'text' => 'Edit User',
            'url' => route('users.edit', $user->id),
            'icon' => 'edit'
        ]
    ])

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center profile-details">
                        <div class="profile-img mb-3">
                            <i data-feather="user" class="feather-icon"></i>
                        </div>
                        <h4>{{ $user->name }}</h4>
                        <h6>{{ $user->email }}</h6>
                        <p class="text-muted">Member since {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Assigned Roles</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Role Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">No roles assigned</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection 