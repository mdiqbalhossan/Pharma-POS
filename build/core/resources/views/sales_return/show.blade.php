{{-- Here inline css is used because of print pdf --}}
@extends('layouts.app')

@section('title', __('index.Sale Return Details'))

@section('content')
    <div class="page-header transfer">
        <div class="page-title">
            <h4>{{ __('index.Sale Return Details') }}</h4>
            <h6>{{ __('index.View sale return details') }}</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('sale-returns.index') }}" class="btn btn-added">
                <i data-feather="list" class="me-2"></i>{{ __('index.Return List') }}
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
                                        <h6>{{ __('index.Sale Information:') }}</h6>
                                        <p><strong>{{ __('index.Invoice No:') }}</strong>
                                            {{ $saleReturn->sale ? $saleReturn->sale->invoice_no : __('index.N/A') }}
                                        </p>
                                        <p><strong>{{ __('index.Customer:') }}</strong>
                                            {{ $saleReturn->sale && $saleReturn->sale->customer ? $saleReturn->sale->customer->name : __('index.N/A') }}
                                        </p>
                                        <p><strong>{{ __('index.Return Date:') }}</strong>
                                            {{ \Carbon\Carbon::parse($saleReturn->created_at)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="info-inner">
                                        <h6>{{ __('index.Return Information:') }}</h6>
                                        <p><strong>{{ __('index.Medicine:') }}</strong>
                                            {{ $saleReturn->medicine ? $saleReturn->medicine->name : __('index.N/A') }}</p>
                                        <p><strong>{{ __('index.Returned Quantity:') }}</strong>
                                            {{ $saleReturn->quantity }}</p>
                                        <p><strong>{{ __('index.Status:') }}</strong> {{ __('index.Completed') }}</p>
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
                                        <b>{{ __('index.Return Details:') }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="heading" style="background: #F3F2F7;">
                        <td style="padding:5px;vertical-align:top;text-align:left;font-weight: bold;">
                            {{ __('index.Medicine') }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('index.Quantity') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('index.Unit Price') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('index.Total') }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('index.Discount') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('index.Tax') }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('index.Grand Total') }}</td>
                    </tr>

                    <tr class="item">
                        <td style="padding:5px;vertical-align:top;text-align:left;border-bottom: 1px solid #ddd;">
                            {{ $saleReturn->medicine ? $saleReturn->medicine->name : __('index.N/A') }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ $saleReturn->quantity }}
                            {{ $saleReturn->medicine ? $saleReturn->medicine->unit->name : '' }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ show_amount($saleReturn->unit_price) }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ show_amount($saleReturn->total_price) }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ $saleReturn->discount }}%
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ $saleReturn->tax }}%
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:right;border-bottom: 1px solid #ddd;">
                            {{ show_amount($saleReturn->grand_total) }}
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
                            {{ __('index.Grand Total') }}</td>
                        <td
                            style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;border-top: 1px solid #ddd;">
                            {{ show_amount($saleReturn->grand_total) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('index.Paid Amount') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ show_amount($saleReturn->paid_amount) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('index.Due Amount') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ show_amount($saleReturn->due_amount) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('index.Payment Method') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ __(ucfirst($saleReturn->payment_method)) }}</td>
                    </tr>
                </table>
            </div>

            @if ($saleReturn->note)
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="form-title">{{ __('index.Note') }}</div>
                        <div class="invoice-note">
                            <p>{{ $saleReturn->note }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
