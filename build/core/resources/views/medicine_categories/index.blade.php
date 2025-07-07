@extends('layouts.app')

@section('title', __('medicine_categories.title'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine_categories.title'),
        'subtitle' => __('medicine_categories.manage_subtitle'),
        'button' => [
            'text' => __('medicine_categories.create_button'),
            'url' => route('medicine-categories.create'),
            'icon' => 'plus',
        ],
    ])

    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a href="" class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th class="no-sort">{{ __('medicine_categories.sn') }}</th>
                            <th>{{ __('medicine_categories.name') }}</th>
                            <th>{{ __('medicine_categories.slug') }}</th>
                            <th>{{ __('medicine_categories.description') }}</th>
                            <th>{{ __('medicine_categories.created_on') }}</th>
                            <th class="no-sort">{{ __('medicine_categories.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicineCategories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->description ?? __('medicine_categories.na') }}</td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('medicine-categories.edit', $category->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('medicine_categories.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('medicine_categories.delete') }}" data-id="{{ $category->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $category->id }}"
                                            action="{{ route('medicine-categories.destroy', $category->id) }}"
                                            method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
@endpush
