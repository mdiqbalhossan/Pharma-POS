<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('index.Purchase') }} {{ __('index.Invoice No:') }} #{{ $purchase->invoice_no }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/purchase_invoice.css') }}" />
    {{-- For dynamic css use internal css --}}
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
                    class="logo-img he-100p">
                <h2 class="m-0">{{ setting('company_name') }}</h2>
                <p class="m-0">{{ setting('company_address') }}</p>
                <p class="m-0">{{ setting('company_phone') }}</p>
                <p class="m-0">{{ setting('company_email') }}</p>
            </div>
            <div class="company-info">
                <h2 class="m-0">{{ __('index.Purchase Invoice') }}</h2>
                <p class="m-0">{{ __('index.Invoice No:') }} #{{ $purchase->invoice_no }}</p>
                <p class="m-0">{{ __('index.Date:') }} {{ date('d M, Y', strtotime($purchase->date)) }}</p>
                <p class="m-0">{{ __('purchase.Type') }}: {{ ucfirst($purchase->type) }}</p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="invoice-details">
            <div class="supplier-details">
                <h3>{{ __('index.Supplier Information') }}:</h3>
                <p class="m-0"><strong>{{ $purchase->supplier->name }}</strong></p>
                @if ($purchase->supplier->email)
                    <p class="m-0">{{ __('index.Email:') }} {{ $purchase->supplier->email }}</p>
                    @endif@if ($purchase->supplier->phone)
                        <p class="m-0">{{ __('index.Phone Number:') }} {{ $purchase->supplier->phone }}</p>
                        @endif@if ($purchase->supplier->address)
                            <p class="m-0">{{ __('index.Address') }}: {{ $purchase->supplier->address }}</p>
                        @endif
            </div>
            <div class="purchase-details">
                <h3>{{ __('index.Payment Method') }}:</h3>
                <p class="m-0">{{ __('index.Method') }}: {{ $purchase->payment_method }}</p>
                <p class="m-0">{{ __('index.Status') }}: @php
                    $paymentStatus = __('index.Paid');
                    if ($purchase->due_amount > 0 && $purchase->paid_amount == 0) {
                        $paymentStatus = __('index.Unpaid');
                    } elseif ($purchase->due_amount > 0) {
                        $paymentStatus = __('index.Partial');
                    }
                @endphp {{ $paymentStatus }} </p>
            </div>
            <div class="clear"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('index.Medicine') }}</th>
                    <th>{{ __('index.Batch No') }}</th>
                    <th>{{ __('index.Expiry Date') }}</th>
                    <th>{{ __('index.Qty') }}</th>
                    <th>{{ __('index.Unit Price') }}</th>
                    <th class="text-right">{{ __('index.Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase->medicines as $index => $medicine)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->pivot->batch_no }}</td>
                        <td>{{ date('d M, Y', strtotime($medicine->pivot->expiry_date)) }}</td>
                        <td>{{ $medicine->pivot->quantity }}</td>
                        <td>{{ show_amount($medicine->pivot->unit_price) }}</td>
                        <td class="text-right">{{ show_amount($medicine->pivot->grand_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals">
            <div class="totals-row">
                <span>{{ __('index.Sub Total') }}:</span><span>{{ show_amount($purchase->subtotal) }}</span>
            </div>
            <div class="totals-row"><span>{{ __('index.Tax') }}:</span><span>{{ show_amount($purchase->tax) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Discount') }}:</span><span>{{ show_amount($purchase->discount) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Shipping') }}:</span><span>{{ show_amount($purchase->shipping) }}</span>
            </div>
            <div class="totals-row grand-total">
                <span>{{ __('index.Grand Total') }}:</span><span>{{ show_amount($purchase->grand_total) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Amount Paid') }}:</span><span>{{ show_amount($purchase->paid_amount) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Due') }}:</span><span>{{ show_amount($purchase->due_amount) }}</span>
            </div>
        </div>
        <div class="clear"></div>
        @if ($purchase->note)
            <div class="notes">
                <h3>{{ __('index.Note') }}:</h3>
                <p>{!! $purchase->note !!}</p>
            </div>
        @endif
        <div class="footer">
            <p>{{ setting('invoice_footer') ?? __('index.Thank you for your business!') }}</p>
            <div class="no-print"><button onclick="window.print()">{{ __('index.Print Invoice') }}</button></div>
        </div>
    </div>
</body>

</html>
