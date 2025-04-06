@extends('layouts.app')

@section('title', 'Stock Adjustment Details')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Stock Adjustment Details</h4>
                <h6>View adjustment information</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to Adjustments</a>
                </div>
            </li>
            <li>
                <a href="{{ route('stock-adjustments.edit', $stockAdjustment->id) }}" class="btn btn-primary"><i
                        data-feather="edit" class="me-2"></i>Edit</a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Adjustment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Medicine:</label>
                                <p>{{ $stockAdjustment->medicine ? $stockAdjustment->medicine->name : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Date:</label>
                                <p>{{ \Carbon\Carbon::parse($stockAdjustment->date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Type:</label>
                                <p>
                                    @if ($stockAdjustment->type == 'addition')
                                        <span class="badge bg-success">Addition</span>
                                    @elseif($stockAdjustment->type == 'reduction')
                                        <span class="badge bg-danger">Reduction</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Quantity:</label>
                                <p>{{ $stockAdjustment->quantity }}</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="fw-bold">Reason:</label>
                                <p>{{ $stockAdjustment->reason }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="fw-bold">Note:</label>
                                <p>{{ $stockAdjustment->note ?? 'No notes provided.' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Created By:</label>
                                <p>{{ $stockAdjustment->creator ? $stockAdjustment->creator->name : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Created At:</label>
                                <p>{{ \Carbon\Carbon::parse($stockAdjustment->created_at)->format('d M Y H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="fw-bold">Last Updated:</label>
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
