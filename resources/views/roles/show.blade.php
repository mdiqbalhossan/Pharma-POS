@extends('layouts.app')

@section('title', 'Role Permissions')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Role Permissions',
        'subtitle' => 'View role permissions',
    ])

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $role->name }} Role</h5>
            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                <i data-feather="edit" class="me-2"></i> Edit Role
            </a>
        </div>
        <div class="card-body">
            <h6 class="mb-3">Assigned Permissions</h6>

            @if (count($rolePermissions) > 0)
                <div class="accordion" id="permissionsAccordion">
                    @php
                        $permissionGroups = $permissions->groupBy('group_name');
                        $index = 0;
                    @endphp

                    @foreach ($permissionGroups as $group => $groupPermissions)
                        @php $index++; @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index > 1 ? 'collapsed' : '' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                    aria-expanded="{{ $index === 1 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $index }}">
                                    <span class="fw-bold text-capitalize">{{ str_replace('_', ' ', $group) }}</span>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}"
                                class="accordion-collapse collapse {{ $index === 1 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $index }}" data-bs-parent="#permissionsAccordion">
                                <div class="accordion-body">
                                    <div class="row g-3">
                                        @foreach ($groupPermissions as $permission)
                                            @php
                                                $parts = explode('-', $permission->name);
                                                $action = end($parts);
                                                $hasPermission = in_array($permission->id, $rolePermissions);
                                            @endphp
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <div class="d-flex align-items-center">
                                                    @if ($hasPermission)
                                                        <i data-feather="check-circle" class="text-success me-2"></i>
                                                    @else
                                                        <i data-feather="circle" class="text-muted me-2"></i>
                                                    @endif
                                                    <span
                                                        class="text-capitalize">{{ str_replace('_', ' ', $action) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <p class="mb-0">No permissions assigned to this role.</p>
                </div>
            @endif

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="me-2"></i> Back to Roles
                </a>
            </div>
        </div>
    </div>
@endsection
