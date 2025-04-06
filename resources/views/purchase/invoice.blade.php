<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice #{{ $purchase->invoice_no }}</title>
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
                <h2>INVOICE</h2>
                <p>Invoice #: {{ $purchase->invoice_no }}</p>
                <p>Date: {{ date('d M, Y', strtotime($purchase->date)) }}</p>
                <p>Type: {{ ucfirst(str_replace('_', ' ', $purchase->type)) }}</p>
            </div>
            <div class="clear"></div>
        </div>

        <div class="invoice-details">
            <div class="supplier-details">
                <h3>Supplier Details:</h3>
                <p><strong>{{ $purchase->supplier->name }}</strong></p>
                @if ($purchase->supplier->email)
                    <p>Email: {{ $purchase->supplier->email }}</p>
                @endif
                @if ($purchase->supplier->phone)
                    <p>Phone: {{ $purchase->supplier->phone }}</p>
                @endif
                @if ($purchase->supplier->address)
                    <p>Address: {{ $purchase->supplier->address }}</p>
                @endif
            </div>
            <div class="purchase-details">
                <h3>Payment Info:</h3>
                <p>Method: {{ $purchase->payment_method }}</p>
                <p>Status:
                    @php
                        $paymentStatus = 'Paid';
                        if ($purchase->due_amount > 0 && $purchase->paid_amount == 0) {
                            $paymentStatus = 'Unpaid';
                        } elseif ($purchase->due_amount > 0) {
                            $paymentStatus = 'Partial';
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
                    <th>Medicine</th>
                    <th>Batch No</th>
                    <th>Expiry Date</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Tax</th>
                    <th>Subtotal</th>
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
                        <td>${{ number_format($medicine->pivot->unit_price, 2) }}</td>
                        <td>${{ number_format($medicine->pivot->discount, 2) }}</td>
                        <td>${{ number_format($medicine->pivot->total_tax, 2) }}</td>
                        <td>${{ number_format($medicine->pivot->grand_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>${{ number_format($purchase->subtotal, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Tax:</span>
                <span>${{ number_format($purchase->total_tax, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Discount:</span>
                <span>${{ number_format($purchase->discount, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Shipping:</span>
                <span>${{ number_format($purchase->shipping, 2) }}</span>
            </div>
            <div class="totals-row grand-total">
                <span>Grand Total:</span>
                <span>${{ number_format($purchase->grand_total, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Paid Amount:</span>
                <span>${{ number_format($purchase->paid_amount, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Due Amount:</span>
                <span>${{ number_format($purchase->due_amount, 2) }}</span>
            </div>
        </div>
        <div class="clear"></div>

        @if ($purchase->note)
            <div class="notes">
                <h3>Notes:</h3>
                <p>{!! $purchase->note !!}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
