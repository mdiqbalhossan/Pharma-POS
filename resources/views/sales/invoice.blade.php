<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('index.Sale') }} {{ __('index.Invoice No:') }} #{{ $sale->sale_no }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/sale_invoice.css') }}">
    <style>
        @isset($extra_css)
            {!! $extra_css !!}
        @endisset
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo"><img src="{{ $logo ?? photo_url(setting('invoice_logo')) }}" alt="Logo"
                    class="logo-img he-50p">
                <h2 class="m-0">{{ setting('company_name') }}</h2>
                <p class="m-0">{{ setting('company_address') }}</p>
                <p class="m-0">{{ setting('company_phone') }}</p>
                <p class="m-0">{{ setting('company_email') }}</p>
            </div>
            <div class="company-info">
                <h2 class="m-0">{{ __('index.Sale Invoice') }}</h2>
                <p class="m-0">{{ __('index.Invoice No:') }} #{{ $sale->sale_no }}</p>
                <p class="m-0">{{ __('index.Date:') }} {{ date('d M, Y', strtotime($sale->sale_date)) }}</p>
                <p class="m-0">{{ __('index.Status') }}: {{ ucfirst($sale->status) }}</p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="invoice-details">
            <div class="customer-details">
                <h3>{{ __('index.Customer Information') }}:</h3>
                <p class="m-0"><strong>{{ $sale->customer->name }}</strong></p>
                @if ($sale->customer->email)
                    <p class="m-0">{{ __('index.Email:') }} {{ $sale->customer->email }}</p>
                @endif
                @if ($sale->customer->phone)
                    <p class="m-0">{{ __('index.Phone Number:') }} {{ $sale->customer->phone }}</p>
                @endif
                @if ($sale->customer->address)
                    <p class="m-0">{{ __('index.Address') }}: {{ $sale->customer->address }}</p>
                @endif
            </div>
            <div class="sale-details">
                <h3>{{ __('index.Payment Method') }}:</h3>
                <p class="m-0">{{ __('index.Method') }}: {{ $sale->payment_method }}</p>
                <p class="m-0">{{ __('index.Status') }}: @php
                    $paymentStatus = __('index.Paid');
                    if ($sale->amount_due > 0 && $sale->amount_paid == 0) {
                        $paymentStatus = __('index.Unpaid');
                    } elseif ($sale->amount_due > 0) {
                        $paymentStatus = __('index.Partial');
                    }
                @endphp {{ $paymentStatus }} </p>
                <p class="m-0">{{ __('index.Staff') }}: {{ $sale->user->name ?? __('index.N/A') }}</p>
            </div>
            <div class="clear"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('index.Medicine') }}</th>
                    <th>{{ __('index.Qty') }}</th>
                    <th>{{ __('index.Unit Price') }}</th>
                    <th class="text-right">{{ __('index.Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->medicines as $index => $medicine)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->pivot->quantity }} {{ $medicine->unit->name }}</td>
                        <td>{{ show_amount($medicine->pivot->price) }}</td>
                        <td class="text-right">{{ show_amount($medicine->pivot->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals">
            <div class="totals-row">
                <span>{{ __('index.Sub Total') }}:</span><span>{{ show_amount($sale->total_amount) }}</span>
            </div>
            <div class="totals-row"><span>{{ __('index.Tax') }}
                    ({{ $sale->tax_percentage }}%):</span><span>{{ show_amount($sale->tax_amount) }}</span></div>
            <div class="totals-row"><span>{{ __('index.Discount') }}
                    ({{ $sale->discount_percentage }}%):</span><span>{{ show_amount($sale->discount_amount) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Shipping') }}:</span><span>{{ show_amount($sale->shipping_amount) }}</span>
            </div>
            <div class="totals-row grand-total">
                <span>{{ __('index.Grand Total') }}:</span><span>{{ show_amount($sale->grand_total) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Amount Paid') }}:</span><span>{{ show_amount($sale->amount_paid) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Due') }}:</span><span>{{ show_amount($sale->amount_due) }}</span>
            </div>
        </div>
        <div class="clear"></div>
        @if ($sale->note)
            <div class="notes">
                <h3>{{ __('index.Note') }}:</h3>
                <p>{!! $sale->note !!}</p>
            </div>
        @endif
        <div class="barcode text-center">
            <div class="barcode-container">{!! $sale->barcode !!} </div>
        </div>
        <div class="footer">
            <p>{{ setting('invoice_footer') ?? __('index.Thank You For Shopping With Us. Please Come Again') }}</p>
            <p>{{ __('index.**VAT against this challan is payable through central registration. Thank you for your business!') }}
            </p>
            <div class="no-print"><button onclick="window.print()">{{ __('index.Print Receipt') }}</button></div>
        </div>
    </div>
</body>

</html>
