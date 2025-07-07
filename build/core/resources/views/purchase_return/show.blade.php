{{-- Here inline css is used because of print pdf --}}
@extends('layouts.app')

@section('title', __('purchase_return.purchase_return_details'))

@section('content')
    <div class="page-header transfer">
        <div class="page-title">
            <h4>{{ __('purchase_return.purchase_return_details') }}</h4>
            <h6>{{ __('purchase_return.view_purchase_return_details') }}</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('purchase-returns.index') }}" class="btn btn-added">
                <i data-feather="list" class="me-2"></i>{{ __('purchase_return.return_list') }}
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
                                        <h6>{{ __('purchase_return.purchase_information') }}</h6>
                                        <p><strong>{{ __('purchase_return.invoice_no') }}</strong>
                                            {{ $purchaseReturn->purchase ? $purchaseReturn->purchase->invoice_no : __('purchase_return.na') }}
                                        </p>
                                        <p><strong>{{ __('purchase_return.supplier') }}</strong>
                                            {{ $purchaseReturn->purchase && $purchaseReturn->purchase->supplier ? $purchaseReturn->purchase->supplier->name : __('purchase_return.na') }}
                                        </p>
                                        <p><strong>{{ __('purchase_return.return_date') }}</strong>
                                            {{ \Carbon\Carbon::parse($purchaseReturn->created_at)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="info-inner">
                                        <h6>{{ __('purchase_return.return_information') }}</h6>
                                        <p><strong>{{ __('purchase_return.medicine') }}</strong>
                                            {{ $purchaseReturn->medicine ? $purchaseReturn->medicine->name : __('purchase_return.na') }}
                                        </p>
                                        <p><strong>{{ __('purchase_return.returned_quantity_label') }}</strong>
                                            {{ $purchaseReturn->quantity }}</p>
                                        <p><strong>{{ __('purchase_return.status') }}</strong>
                                            {{ __('purchase_return.completed') }}</p>
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
                                        <b>{{ __('purchase_return.return_details_label') }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="heading" style="background: #F3F2F7;">
                        <td style="padding:5px;vertical-align:top;text-align:left;font-weight: bold;">
                            {{ __('purchase_return.medicine') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('purchase_return.quantity') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('purchase_return.unit_price') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('purchase_return.total') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('purchase_return.discount_heading') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:center;font-weight: bold;">
                            {{ __('purchase_return.tax_heading') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('purchase_return.grand_total_heading') }}</td>
                    </tr>

                    <tr class="item">
                        <td style="padding:5px;vertical-align:top;text-align:left;border-bottom: 1px solid #ddd;">
                            {{ $purchaseReturn->medicine ? $purchaseReturn->medicine->name : __('purchase_return.na') }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ $purchaseReturn->quantity }}
                            {{ $purchaseReturn->medicine ? $purchaseReturn->medicine->unit->name : '' }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ show_amount($purchaseReturn->unit_price) }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ show_amount($purchaseReturn->total_price) }}
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ show_amount($purchaseReturn->discount) }}%
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:center;border-bottom: 1px solid #ddd;">
                            {{ show_amount($purchaseReturn->tax) }}%
                        </td>
                        <td style="padding:5px;vertical-align:top;text-align:right;border-bottom: 1px solid #ddd;">
                            {{ show_amount($purchaseReturn->grand_total) }}
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
                            {{ __('purchase_return.grand_total_heading') }}</td>
                        <td
                            style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;border-top: 1px solid #ddd;">
                            {{ show_amount($purchaseReturn->grand_total) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('purchase_return.paid_amount_label') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ show_amount($purchaseReturn->paid_amount) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('purchase_return.due_amount_label') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ show_amount($purchaseReturn->due_amount) }}</td>
                    </tr>

                    <tr class="total">
                        <td style="padding:5px;vertical-align:top;text-align:left;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:center;"></td>
                        <td style="padding:5px;vertical-align:top;text-align:right;font-weight: bold;">
                            {{ __('purchase_return.payment_method_label') }}</td>
                        <td style="padding:5px;vertical-align:top;text-align:right;">
                            {{ ucfirst($purchaseReturn->payment_method) }}</td>
                    </tr>
                </table>
            </div>

            @if ($purchaseReturn->note)
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="form-title">{{ __('purchase_return.note_heading') }}</div>
                        <div class="invoice-note">
                            <p>{{ $purchaseReturn->note }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
