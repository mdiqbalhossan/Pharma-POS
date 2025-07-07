@extends('layouts.app')

@section('title', __('account.account_details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('account.account_details'),
        'subtitle' => __('account.manage_your_accounts'),
        'button' => [
            'text' => __('account.back'),
            'url' => route('accounts.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ __('account.account_details') }}</h5>
                    <div>
                        <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-primary btn-sm">
                            <i data-feather="edit" class="me-1"></i>{{ __('account.edit') }}
                        </a>
                        <a class="btn btn-danger btn-sm confirm-text" href="javascript:void(0);" data-bs-toggle="tooltip"
                            data-id="{{ $account->id }}">
                            <i data-feather="trash-2" class="me-1"></i>{{ __('account.delete') }}
                        </a>
                        <form id="delete-form-{{ $account->id }}" action="{{ route('accounts.destroy', $account->id) }}"
                            method="POST" class="d-none">
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
                                    <th width="40%">{{ __('account.name') }}</th>
                                    <td>{{ $account->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('account.type') }}</th>
                                    <td>{{ $account->type }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('account.status') }}</th>
                                    <td>
                                        @if ($account->is_active)
                                            <span class="badge bg-success">{{ __('account.active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('account.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('account.description') }}</th>
                                    <td>{{ $account->description ?? __('account.na') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('account.created_on') }}</th>
                                    <td>{{ $account->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('account.last_updated') }}</th>
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
