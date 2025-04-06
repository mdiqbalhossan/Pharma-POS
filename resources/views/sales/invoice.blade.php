<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Invoice #{{ $sale->sale_no }}</title>
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
            max-width: 150px;
        }

        .company-info {
            float: right;
            text-align: right;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .customer-details {
            width: 50%;
            float: left;
        }

        .sale-details {
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
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
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

        @media print {
            .no-print {
                display: none;
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
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo">
                <h2>Pharmacy</h2>
            </div>
            <div class="company-info">
                <h2>SALES INVOICE</h2>
                <p>Invoice #: {{ $sale->sale_no }}</p>
                <p>Date: {{ date('d M, Y', strtotime($sale->sale_date)) }}</p>
                <p>Status: {{ ucfirst($sale->status) }}</p>
            </div>
            <div class="clear"></div>
        </div>

        <div class="invoice-details">
            <div class="customer-details">
                <h3>Customer Details:</h3>
                <p><strong>{{ $sale->customer->name }}</strong></p>
                @if ($sale->customer->email)
                    <p>Email: {{ $sale->customer->email }}</p>
                @endif
                @if ($sale->customer->phone)
                    <p>Phone: {{ $sale->customer->phone }}</p>
                @endif
                @if ($sale->customer->address)
                    <p>Address: {{ $sale->customer->address }}</p>
                @endif
            </div>
            <div class="sale-details">
                <h3>Payment Info:</h3>
                <p>Method: {{ $sale->payment_method }}</p>
                <p>Status:
                    @php
                        $paymentStatus = 'Paid';
                        if ($sale->amount_due > 0 && $sale->amount_paid == 0) {
                            $paymentStatus = 'Unpaid';
                        } elseif ($sale->amount_due > 0) {
                            $paymentStatus = 'Partial';
                        }
                    @endphp
                    {{ $paymentStatus }}
                </p>
                <p>Staff: {{ $sale->user->name ?? 'N/A' }}</p>
            </div>
            <div class="clear"></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->medicines as $index => $medicine)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->pivot->quantity }}</td>
                        <td>${{ number_format($medicine->pivot->price, 2) }}</td>
                        <td>${{ number_format($medicine->pivot->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>${{ number_format($sale->total_amount, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Tax ({{ $sale->tax_percentage }}%):</span>
                <span>${{ number_format($sale->tax_amount, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Discount ({{ $sale->discount_percentage }}%):</span>
                <span>${{ number_format($sale->discount_amount, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Shipping:</span>
                <span>${{ number_format($sale->shipping_amount, 2) }}</span>
            </div>
            <div class="totals-row grand-total">
                <span>Grand Total:</span>
                <span>${{ number_format($sale->grand_total, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Paid Amount:</span>
                <span>${{ number_format($sale->amount_paid, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Due Amount:</span>
                <span>${{ number_format($sale->amount_due, 2) }}</span>
            </div>
        </div>
        <div class="clear"></div>

        @if ($sale->note)
            <div class="notes">
                <h3>Notes:</h3>
                <p>{!! $sale->note !!}</p>
            </div>
        @endif

        <div class="barcode">
            {!! $sale->barcode !!}
            <p>{{ $sale->sale_no }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>For any inquiries, please contact us.</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Invoice
        </button>
        <a href="{{ url()->previous() }}"
            style="margin-left: 10px; padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 4px; text-decoration: none;">
            Back
        </a>
    </div>
</body>

</html>
