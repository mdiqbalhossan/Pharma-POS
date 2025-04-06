<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Balance Sheet</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .date-range {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .summary {
            margin-top: 30px;
            padding: 10px;
            border: 1px solid #000;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Balance Sheet</h1>
        <h3>{{ config('app.name') }}</h3>
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
                                <td class="text-right">{{ number_format($account['balance'], 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total Assets</td>
                        <td class="text-right">{{ number_format($totalAssets, 2) }}</td>
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
                                <td class="text-right">{{ number_format($account['balance'], 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td><strong>Total Liabilities</strong></td>
                        <td class="text-right">{{ number_format($totalLiabilities, 2) }}</td>
                    </tr>

                    <!-- Equity -->
                    @foreach ($accountBalances as $account)
                        @if ($account['type'] === 'equity')
                            <tr>
                                <td>{{ $account['name'] }}</td>
                                <td class="text-right">{{ number_format($account['balance'], 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td><strong>Total Equity</strong></td>
                        <td class="text-right">{{ number_format($totalEquity, 2) }}</td>
                    </tr>

                    <!-- Net Income -->
                    <tr>
                        <td><strong>Net Income</strong></td>
                        <td class="text-right">{{ number_format($netIncome, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total Liabilities & Equity</td>
                        <td class="text-right">{{ number_format($totalLiabilitiesAndEquity, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="summary">
        <strong>Summary:</strong>
        @if ($totalAssets == $totalLiabilitiesAndEquity)
            The balance sheet is balanced. Total Assets ({{ number_format($totalAssets, 2) }}) equals Total Liabilities
            & Equity ({{ number_format($totalLiabilitiesAndEquity, 2) }}).
        @else
            The balance sheet is not balanced. Total Assets ({{ number_format($totalAssets, 2) }}) does not equal Total
            Liabilities & Equity ({{ number_format($totalLiabilitiesAndEquity, 2) }}).
        @endif
    </div>

    <div class="footer">
        <p>Generated on: {{ date('d M Y H:i:s') }}</p>
    </div>
</body>

</html>
