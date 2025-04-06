<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trial Balance Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
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

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .date-range {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Trial Balance Report</h1>
        <p>{{ config('app.name') }}</p>
    </div>

    <div class="date-range">
        <strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to
        {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Account Name</th>
                <th>Type</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account['name'] }}</td>
                    <td>{{ ucfirst($account['type']) }}</td>
                    <td class="text-right">{{ number_format($account['debit'], 2) }}</td>
                    <td class="text-right">{{ number_format($account['credit'], 2) }}</td>
                    <td class="text-right {{ $account['balance'] < 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($account['balance'], 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ number_format($totalDebit, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalCredit, 2) }}</strong></td>
                <td class="text-right {{ $totalBalance < 0 ? 'text-danger' : 'text-success' }}">
                    <strong>{{ number_format($totalBalance, 2) }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generated on: {{ now()->format('d M Y H:i:s') }}
    </div>
</body>

</html>
