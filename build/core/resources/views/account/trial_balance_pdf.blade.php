<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trial Balance Report</title>
    <link rel="stylesheet" href="{{ public_path('../assets/css/pdf/trial_balance.css') }}">
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
        <h1>Trial Balance Report</h1>
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
                    <td class="text-right">{{ show_amount($account['debit']) }}</td>
                    <td class="text-right">{{ show_amount($account['credit']) }}</td>
                    <td class="text-right {{ $account['balance'] < 0 ? 'text-danger' : 'text-success' }}">
                        {{ show_amount($account['balance']) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ show_amount($totalDebit) }}</strong></td>
                <td class="text-right"><strong>{{ show_amount($totalCredit) }}</strong></td>
                <td class="text-right {{ $totalBalance < 0 ? 'text-danger' : 'text-success' }}">
                    <strong>{{ show_amount($totalBalance) }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generated on: {{ now()->format('d M Y H:i:s') }}
    </div>
</body>

</html>
