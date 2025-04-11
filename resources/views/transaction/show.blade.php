@extends('layouts.app')

@section('title', __('Transaction Details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Transaction Details'),
        'subtitle' => __('View transaction information'),
        'button' => [
            'text' => __('Back'),
            'url' => route('accounts.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ __('Transaction Information') }}</h5>
                    <div>
                        <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-primary btn-sm">
                            <i data-feather="edit" class="me-1"></i>{{ __('Edit') }}
                        </a>
                        <a class="btn btn-danger btn-sm confirm-text" href="javascript:void(0);" data-bs-toggle="tooltip"
                            data-id="{{ $account->id }}">
                            <i data-feather="trash-2" class="me-1"></i>{{ __('Delete') }}
                        </a>
                        <form id="delete-form-{{ $account->id }}" action="{{ route('accounts.destroy', $account->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('Name') }}</th>
                                    <td>{{ $account->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Type') }}</th>
                                    <td>{{ $account->type }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Status') }}</th>
                                    <td>
                                        @if ($account->is_active)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('Description') }}</th>
                                    <td>{{ $account->description ?? __('N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Created At') }}</th>
                                    <td>{{ $account->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Last Updated') }}</th>
                                    <td>{{ $account->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
