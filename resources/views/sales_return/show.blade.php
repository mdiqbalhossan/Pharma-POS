@extends('layouts.app')

@section('title', 'Sale Return Details')

@section('content')
    <div class="page-header transfer">
        <div class="page-title">
            <h4>Sale Return Details</h4>
            <h6>View sale return details</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('sale-returns.index') }}" class="btn btn-added">
                <i data-feather="list" class="me-2"></i>Return List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-sales-split">
                <div class="row w-100">
                    <div class="col-lg-12">
                        <div class="card-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="info-inner">
                                        <h6>Sale Information:</h6>
                                        <p><strong>Invoice No:</strong>
                                            {{ $saleReturn->sale ? $saleReturn->sale->invoice_no : 'N/A' }}
                                        </p>
                                        <p><strong>Customer:</strong>
                                            {{ $saleReturn->sale && $saleReturn->sale->customer ? $saleReturn->sale->customer->name : 'N/A' }}
                                        </p>
                                        <p><strong>Return Date:</strong>
                                            {{ \Carbon\Carbon::parse($saleReturn->created_at)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="info-inner">
                                        <h6>Return Information:</h6>
                                        <p><strong>Medicine:</strong>
                                            {{ $saleReturn->medicine ? $saleReturn->medicine->name : 'N/A' }}</p>
                                        <p><strong>Returned Quantity:</strong> {{ $saleReturn->quantity }}</p>
                                        <p><strong>Status:</strong> Completed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-box table-height"
                style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                    <tr class="top">
                        <td colspan="6" style="padding: 5px;vertical-align: top;">
                            <table style="width: 100%;line-height: inherit;text-align: left;">
                                <tr>
                                    <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom: 20px;">
                                        <b>Return Details:</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="heading" style="background: #F3F2F7;">
                        <td style="padding:5px;vertical-align:top;text-align:left;font-weight: bold;">Medicine</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">Quantity</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">Unit Price</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">Total</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">Discount</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">Tax</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">Grand Total</td>
                    </tr>

                    <tr class="item">
                        <td style="padding:5px;vertical-align:top;text-align:left;border-bottom: 1px solid #ddd;">
                            {{ $saleReturn->medicine ? $saleReturn->medicine->name : 'N/A' }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ $saleReturn->quantity }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ number_format($saleReturn->unit_price, 2) }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ number_format($saleReturn->total_price, 2) }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ number_format($saleReturn->discount, 2) }}%
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ number_format($saleReturn->tax, 2) }}%
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:right;border-bottom: 1px solid #ddd;">
                            {{ number_format($saleReturn->grand_total, 2) }}
                        </td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td
                            style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;border-top: 1px solid #ddd;">
                            Grand Total</td>
                        <td
                            style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;border-top: 1px solid #ddd;">
                            {{ number_format($saleReturn->grand_total, 2) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">Paid Amount</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ number_format($saleReturn->paid_amount, 2) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">Due Amount</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ number_format($saleReturn->due_amount, 2) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">Payment Method</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ ucfirst($saleReturn->payment_method) }}</td>
                    </tr>
                </table>
            </div>

            @if ($saleReturn->note)
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="form-title">Note</div>
                        <div class="invoice-note">
                            <p>{{ $saleReturn->note }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
