@extends('layouts.app')

@section('title', __('Stock Adjustment Details'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('Stock Adjustment Details') }}</h4>
                <h6>{{ __('View adjustment information') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('Back to Adjustments') }}</a>
                </div>
            </li>
            <li>
                <a href="{{ route('stock-adjustments.edit', $stockAdjustment->id) }}" class="btn btn-primary"><i
                        data-feather="edit" class="me-2"></i>{{ __('Edit') }}</a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Collapse') }}" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Adjustment Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Medicine') }}:</label>
                                <p>{{ $stockAdjustment->medicine ? $stockAdjustment->medicine->name : __('N/A') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Date') }}:</label>
                                <p>{{ \Carbon\Carbon::parse($stockAdjustment->date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Type') }}:</label>
                                <p>
                                    @if ($stockAdjustment->type == 'addition')
                                        <span class="badge bg-success">{{ __('Addition') }}</span>
                                    @elseif($stockAdjustment->type == 'reduction')
                                        <span class="badge bg-danger">{{ __('Reduction') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Quantity') }}:</label>
                                <p>{{ $stockAdjustment->quantity }}</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Reason') }}:</label>
                                <p>{{ $stockAdjustment->reason }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Note') }}:</label>
                                <p>{{ $stockAdjustment->note ?? __('No notes provided.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Created By') }}:</label>
                                <p>{{ $stockAdjustment->creator ? $stockAdjustment->creator->name : __('N/A') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Created At') }}:</label>
                                <p>{{ \Carbon\Carbon::parse($stockAdjustment->created_at)->format('d M Y H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">{{ __('Last Updated') }}:</label>
                                <p>{{ \Carbon\Carbon::parse($stockAdjustment->updated_at)->format('d M Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
@endpush
