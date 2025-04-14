<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('index.Purchase') }} {{ __('index.Invoice No:') }} #{{ $purchase->invoice_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .logo {
            float: left;
            max-width: 350px;
        }

        .company-info {
            float: right;
            text-align: right;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .supplier-details {
            width: 50%;
            float: left;
        }

        .purchase-details {
            width: 50%;
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        table th {
            background-color: #f8f8f8;
        }

        .totals {
            float: right;
            width: 350px;
        }

        .totals-row {
            width: 100%;
            clear: both;
            padding: 5px 0;
        }

        .totals-row span:first-child {
            float: left;
        }

        .totals-row span:last-child {
            float: right;
        }

        .totals-row.grand-total {
            font-weight: bold;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }

        .payment-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .notes {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            text-align: center;
        }

        .barcode {
            margin-top: 20px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }

            .m-0 {
                margin: 0;
            }

            body {
                padding: 0;
                margin: 0;
            }

            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 10px;
                max-width: 100%;
            }

            /* Ensure proper alignment in PDF */
            .totals-row {
                margin-bottom: 5px;
            }

            .clear {
                clear: both;
                height: 0;
                overflow: hidden;
            }
        }

        @isset($extra_css)
            {!! $extra_css !!}
        @endisset
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo">
                <img src="{{ $logo ?? photo_url(setting('invoice_logo')) }}" alt="Logo" style="width: 100px;"
                    class="logo-img">
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
                @endif
                @if ($purchase->supplier->phone)
                    <p class="m-0">{{ __('index.Phone Number:') }} {{ $purchase->supplier->phone }}</p>
                @endif
                @if ($purchase->supplier->address)
                    <p class="m-0">{{ __('index.Address') }}: {{ $purchase->supplier->address }}</p>
                @endif
            </div>
            <div class="purchase-details">
                <h3>{{ __('index.Payment Method') }}:</h3>
                <p class="m-0">{{ __('index.Method') }}: {{ $purchase->payment_method }}</p>
                <p class="m-0">{{ __('index.Status') }}:
                    @php
                        $paymentStatus = __('index.Paid');
                        if ($purchase->due_amount > 0 && $purchase->paid_amount == 0) {
                            $paymentStatus = __('index.Unpaid');
                        } elseif ($purchase->due_amount > 0) {
                            $paymentStatus = __('index.Partial');
                        }
                    @endphp
                    {{ $paymentStatus }}
                </p>
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
                <span>{{ __('index.Sub Total') }}:</span>
                <span>{{ show_amount($purchase->subtotal) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Tax') }}:</span>
                <span>{{ show_amount($purchase->tax) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Discount') }}:</span>
                <span>{{ show_amount($purchase->discount) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Shipping') }}:</span>
                <span>{{ show_amount($purchase->shipping) }}</span>
            </div>
            <div class="totals-row grand-total">
                <span>{{ __('index.Grand Total') }}:</span>
                <span>{{ show_amount($purchase->grand_total) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Amount Paid') }}:</span>
                <span>{{ show_amount($purchase->paid_amount) }}</span>
            </div>
            <div class="totals-row">
                <span>{{ __('index.Due') }}:</span>
                <span>{{ show_amount($purchase->due_amount) }}</span>
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
            <div class="no-print">
                <button onclick="window.print()">{{ __('index.Print Invoice') }}</button>
            </div>
        </div>
    </div>
</body>

</html>
