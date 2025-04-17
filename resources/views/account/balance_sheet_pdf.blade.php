<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Balance Sheet</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/balance_sheet.css') }}">
</head>

<body>
    <div class="company-info">
        <img src="{{ photo_url_pdf(setting('invoice_logo')) }}" alt="Company Logo" class="company-logo">
        <div class="company-details">
            <h2>{{ setting('company_name') }}</h2>
            <p>{{ setting('company_address') }}</p>
            <p>{{ setting('company_email') }}</p>
            <p>{{ setting('company_phone') }}</p>
        </div>
    </div>
    <div class="header">
        <h1>Balance Sheet</h1>
    </div>

    <div class="date-range">
        <p>Period: {{ date('d M Y', strtotime($startDate)) }} to {{ date('d M Y', strtotime($endDate)) }}</p>
    </div>

    <div class="row">
        <!-- Assets Section -->
        <div class="col-md-6">
            <h2>Assets</h2>
            <table>
                <thead>
                    <tr>
                        <th>Account</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accountBalances as $account)
                        @if ($account['type'] === 'asset')
                            <tr>
                                <td>{{ $account['name'] }}</td>
                                <td class="text-right">{{ show_amount($account['balance']) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total Assets</td>
                        <td class="text-right">{{ show_amount($totalAssets) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Liabilities & Equity Section -->
        <div class="col-md-6">
            <h2>Liabilities & Equity</h2>
            <table>
                <thead>
                    <tr>
                        <th>Account</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Liabilities -->
                    @foreach ($accountBalances as $account)
                        @if ($account['type'] === 'liability')
                            <tr>
                                <td>{{ $account['name'] }}</td>
                                <td class="text-right">{{ show_amount($account['balance']) }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td><strong>Total Liabilities</strong></td>
                        <td class="text-right">{{ show_amount($totalLiabilities) }}</td>
                    </tr>

                    <!-- Equity -->
                    @foreach ($accountBalances as $account)
                        @if ($account['type'] === 'equity')
                            <tr>
                                <td>{{ $account['name'] }}</td>
                                <td class="text-right">{{ show_amount($account['balance']) }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td><strong>Total Equity</strong></td>
                        <td class="text-right">{{ show_amount($totalEquity) }}</td>
                    </tr>

                    <!-- Net Income -->
                    <tr>
                        <td><strong>Net Income</strong></td>
                        <td class="text-right">{{ show_amount($netIncome) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total Liabilities & Equity</td>
                        <td class="text-right">{{ show_amount($totalLiabilitiesAndEquity) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="summary">
        <strong>Summary:</strong>
        @if ($totalAssets == $totalLiabilitiesAndEquity)
            The balance sheet is balanced. Total Assets ({{ show_amount($totalAssets) }}) equals Total Liabilities
            & Equity ({{ show_amount($totalLiabilitiesAndEquity) }}).
        @else
            The balance sheet is not balanced. Total Assets ({{ show_amount($totalAssets) }}) does not equal Total
            Liabilities & Equity ({{ show_amount($totalLiabilitiesAndEquity) }}).
        @endif
    </div>

    <div class="footer">
        <p>Generated on: {{ date('d M Y H:i:s') }}</p>
    </div>
</body>

</html>
