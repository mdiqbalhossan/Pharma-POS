<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Income Statement</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/income_statement.css') }}">
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
