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
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('Name') }}</th>
                                    <td>{{ $transaction->account->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Type') }}</th>
                                    <td>
                                        @if ($transaction->type == 'debit')
                                            <span class="badge bg-danger">{{ __('Debit') }}</span>
                                        @else
                                            <span class="badge bg-success">{{ __('Credit') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Amount') }}</th>
                                    <td>{{ show_amount($transaction->amount) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('Description') }}</th>
                                    <td>{{ $transaction->description ?? __('N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Created At') }}</th>
                                    <td>{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Last Updated') }}</th>
                                    <td>{{ $transaction->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
