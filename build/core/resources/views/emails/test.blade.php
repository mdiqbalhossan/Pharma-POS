{{-- This is email template thats why use internal css --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tested Email Send</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /*
        * This is email template thats why use internal css
        * Responsive media query for mobile
        */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 20px !important;
            }

            .button {
                padding: 12px 20px !important;
                font-size: 16px !important;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table class="container" width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #2c3e50; padding: 30px 20px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">🚀 {{ setting('company_name') }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 30px 20px; color: #333333;">
                            <h2 style="margin-top: 0;">Test Email from {{ setting('site_name') }}</h2>
                            <p style="line-height: 1.6;">
                                Hello,
                            </p>
                            <p style="line-height: 1.6;">
                                This is a test email sent from your {{ setting('site_name') }} application.
                            </p>
                            <p style="line-height: 1.6;">
                                If you received this email, it means your email configuration is working correctly!
                            </p>
                            <p style="line-height: 1.6;">
                                Date and time sent: {{ now()->format('Y-m-d H:i:s') }}
                            </p>
                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/') }}" target="_blank" class="button"
                                    style="background-color: #3498db; color: #ffffff; text-decoration: none; padding: 14px 28px; font-size: 18px; border-radius: 5px; display: inline-block;">Explore
                                    Now</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background-color: #ecf0f1; padding: 20px; font-size: 14px; color: #777777;">
                            <p style="margin: 0;">This is an automated message. Please do not reply to this email.</p>
                            <p style="margin: 5px 0;">© {{ date('Y') }} {{ setting('site_name') }}</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
