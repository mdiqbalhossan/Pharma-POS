<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Income Statement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .date-range {
            margin-bottom: 20px;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .summary {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .company-logo {
            width: 100px;
        }

        .company-details {
            margin-left: 10px;
        }

        .company-details h2 {
            margin: 0;
            font-size: 18px;
        }

        .company-details p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="company-info">
        <img src="{{ photo_url_pdf(setting('invoice_logo')) }}" alt="Company Logo" class="company-logo">
        <div class="company-details">
            <h2>{{ setting('company_name') }}</h2>
            <p>{{ setting('company_address') }}</p>
            <p>{{ setting('company_email') }}</p>
        </div>
    </div>

    <div class="header">
        <h1>Income Statement</h1>
        <p>For the period {{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} to
            {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</p>
    </div>

    <div class="section">
        <h2>Revenue</h2>
        <table>
            <thead>
                <tr>
                    <th>Account</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($revenueBreakdown as $revenue)
                    <tr>
                        <td>{{ $revenue['name'] }}</td>
                        <td class="text-right">{{ show_amount($revenue['amount']) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Revenue</strong></td>
                    <td class="text-right"><strong>{{ show_amount($totalRevenue) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="section">
        <h2>Expenses</h2>
        <table>
            <thead>
                <tr>
                    <th>Account</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenseBreakdown as $expense)
                    <tr>
                        <td>{{ $expense['name'] }}</td>
                        <td class="text-right">{{ show_amount($expense['amount']) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Expenses</strong></td>
                    <td class="text-right"><strong>{{ show_amount($totalExpenses) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="summary">
        <h3>Net Income</h3>
        <p>
            @if ($netIncome >= 0)
                The business made a profit of {{ show_amount($netIncome) }} during this period.
            @else
                The business incurred a loss of {{ show_amount(abs($netIncome)) }} during this period.
            @endif
        </p>
    </div>

    <div class="footer">
        <p>This is a computer-generated report. No signature is required.</p>
        <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
    </div>
</body>

</html>
