<!DOCTYPE html>
<html>

<head>
    <title>Test Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .content {
            margin-bottom: 30px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Test Email from {{ config('app.name') }}</h2>
        </div>

        <div class="content">
            <p>Hello,</p>

            <p>This is a test email sent from your {{ config('app.name') }} application.</p>

            <p>If you received this email, it means your email configuration is working correctly!</p>

            <p>Date and time sent: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>

</html>
