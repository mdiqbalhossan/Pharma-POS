@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Edit Role',
        'subtitle' => 'Update role details',
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $role->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label mb-0">Permissions</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary me-2"
                                    id="select-all-btn">Select All</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    id="deselect-all-btn">Deselect All</button>
                            </div>
                        </div>

                        @error('permissions')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

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
                                            <div class="d-flex align-items-center w-100">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input group-select" type="checkbox"
                                                        value="" id="group{{ $index }}"
                                                        data-group="{{ $group }}">
                                                </div>
                                                <span
                                                    class="fw-bold text-capitalize">{{ str_replace('_', ' ', $group) }}</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}"
                                        class="accordion-collapse collapse {{ $index === 1 ? 'show' : '' }}"
                                        aria-labelledby="heading{{ $index }}"
                                        data-bs-parent="#permissionsAccordion">
                                        <div class="accordion-body">
                                            <div class="row g-3">
                                                @foreach ($groupPermissions as $permission)
                                                    @php
                                                        $parts = explode('-', $permission->name);
                                                        $action = end($parts);
                                                    @endphp
                                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input permission-checkbox {{ $group }}-checkbox"
                                                                type="checkbox" name="permissions[]"
                                                                value="{{ $permission->name }}"
                                                                id="permission{{ $permission->id }}"
                                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                            <label class="form-check-label text-capitalize"
                                                                for="permission{{ $permission->id }}">
                                                                {{ str_replace('_', ' ', $action) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/role.js') }}"></script>
@endpush
