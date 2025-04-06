<?php
namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function siteSettings()
    {
        $settings = [
            'site_name'               => Setting::get('site_name') ?? 'Pharmacy POS',
            'currency'                => Setting::get('currency') ?? 'USD',
            'currency_symbol'         => Setting::get('currency_symbol') ?? '$',
            'date_format'             => Setting::get('date_format') ?? 'Y-m-d',
            'time_format'             => Setting::get('time_format') ?? 'H:i:s',
            'default_tax'             => Setting::get('default_tax') ?? '0',
            'invoice_prefix'          => Setting::get('invoice_prefix') ?? 'INV',
            'invoice_footer'          => Setting::get('invoice_footer') ?? 'Thank you for your business!',
            'default_language'        => Setting::get('default_language') ?? 'en',
            'timezone'                => Setting::get('timezone') ?? 'UTC',
            'low_stock_alert'         => Setting::get('low_stock_alert') ?? '10',
            'barcode_type'            => Setting::get('barcode_type') ?? 'CODE128',
            'maintenance_mode'        => Setting::get('maintenance_mode') ?? '0',
            'allow_backorder'         => Setting::get('allow_backorder') ?? '0',
            'stock_expiry_alert_days' => Setting::get('stock_expiry_alert_days') ?? '30',
            'site_logo'               => Setting::get('site_logo') ?? '',
            'favicon'                 => Setting::get('favicon') ?? '',
        ];

        return view('settings.site_settings', compact('settings'));
    }

    public function updateSiteSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name'               => 'required|string|max:255',
            'currency'                => 'required|string|max:3',
            'currency_symbol'         => 'required|string|max:5',
            'date_format'             => 'required|string|max:20',
            'time_format'             => 'required|string|max:20',
            'default_tax'             => 'required|numeric',
            'invoice_prefix'          => 'required|string|max:10',
            'invoice_footer'          => 'nullable|string',
            'default_language'        => 'required|string|max:5',
            'timezone'                => 'required|string|max:50',
            'low_stock_alert'         => 'required|integer|min:1',
            'barcode_type'            => 'required|string|max:20',
            'maintenance_mode'        => 'nullable|string|in:0,1',
            'allow_backorder'         => 'nullable|string|in:0,1',
            'stock_expiry_alert_days' => 'nullable|integer|min:1',
        ]);

        // Handle site logo upload
        if ($request->hasFile('site_logo')) {
            $request->validate([
                'site_logo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::exists('public/' . $oldLogo)) {
                Storage::delete('public/' . $oldLogo);
            }

            $path = $request->file('site_logo')->store('site', 'public');
            Setting::set('site_logo', $path);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $request->validate([
                'favicon' => 'image|mimes:ico,png|max:1024',
            ]);

            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && Storage::exists('public/' . $oldFavicon)) {
                Storage::delete('public/' . $oldFavicon);
            }

            $path = $request->file('favicon')->store('site', 'public');
            Setting::set('favicon', $path);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        // Set checkbox values to 0 if not provided
        if (! isset($validated['maintenance_mode'])) {
            Setting::set('maintenance_mode', '0');
        }

        if (! isset($validated['allow_backorder'])) {
            Setting::set('allow_backorder', '0');
        }

        return redirect()->back()->with('success', 'Site settings updated successfully!');
    }

    public function companySettings()
    {
        $settings = [
            'company_name'                  => Setting::get('company_name') ?? 'Pharmacy Name',
            'company_email'                 => Setting::get('company_email') ?? 'info@example.com',
            'company_phone'                 => Setting::get('company_phone') ?? '+1234567890',
            'company_address'               => Setting::get('company_address') ?? '',
            'company_city'                  => Setting::get('company_city') ?? '',
            'company_state'                 => Setting::get('company_state') ?? '',
            'company_zip'                   => Setting::get('company_zip') ?? '',
            'company_country'               => Setting::get('company_country') ?? '',
            'tax_number'                    => Setting::get('tax_number') ?? '',
            'registration_number'           => Setting::get('registration_number') ?? '',
            'invoice_logo'                  => Setting::get('invoice_logo') ?? '',
            'opening_time'                  => Setting::get('opening_time') ?? '09:00',
            'closing_time'                  => Setting::get('closing_time') ?? '18:00',
            'facebook_link'                 => Setting::get('facebook_link') ?? '',
            'twitter_link'                  => Setting::get('twitter_link') ?? '',
            'instagram_link'                => Setting::get('instagram_link') ?? '',
            'linkedin_link'                 => Setting::get('linkedin_link') ?? '',
            'website_link'                  => Setting::get('website_link') ?? '',
            'pharmacist_license'            => Setting::get('pharmacist_license') ?? '',
            'prescription_required_message' => Setting::get('prescription_required_message') ?? 'Prescription is required for this medicine.',
        ];

        return view('settings.company', compact('settings'));
    }

    public function updateCompanySettings(Request $request)
    {
        $validated = $request->validate([
            'company_name'                  => 'required|string|max:255',
            'company_email'                 => 'required|email|max:255',
            'company_phone'                 => 'required|string|max:20',
            'company_address'               => 'nullable|string|max:255',
            'company_city'                  => 'nullable|string|max:100',
            'company_state'                 => 'nullable|string|max:100',
            'company_zip'                   => 'nullable|string|max:20',
            'company_country'               => 'nullable|string|max:100',
            'tax_number'                    => 'nullable|string|max:50',
            'registration_number'           => 'nullable|string|max:50',
            'opening_time'                  => 'nullable|string|max:10',
            'closing_time'                  => 'nullable|string|max:10',
            'facebook_link'                 => 'nullable|string|max:255',
            'twitter_link'                  => 'nullable|string|max:255',
            'instagram_link'                => 'nullable|string|max:255',
            'linkedin_link'                 => 'nullable|string|max:255',
            'website_link'                  => 'nullable|string|max:255',
            'pharmacist_license'            => 'nullable|string|max:50',
            'prescription_required_message' => 'nullable|string',
        ]);

        // Handle invoice logo upload
        if ($request->hasFile('invoice_logo')) {
            $request->validate([
                'invoice_logo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $oldLogo = Setting::get('invoice_logo');
            if ($oldLogo && Storage::exists('public/' . $oldLogo)) {
                Storage::delete('public/' . $oldLogo);
            }

            $path = $request->file('invoice_logo')->store('company', 'public');
            Setting::set('invoice_logo', $path);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Company settings updated successfully!');
    }

    public function emailSettings()
    {
        $settings = [
            'mail_mailer'       => Setting::get('mail_mailer') ?? 'smtp',
            'mail_host'         => Setting::get('mail_host') ?? 'smtp.mailtrap.io',
            'mail_port'         => Setting::get('mail_port') ?? '2525',
            'mail_username'     => Setting::get('mail_username') ?? '',
            'mail_password'     => Setting::get('mail_password') ?? '',
            'mail_encryption'   => Setting::get('mail_encryption') ?? 'tls',
            'mail_from_address' => Setting::get('mail_from_address') ?? 'info@pharmacy.com',
            'mail_from_name'    => Setting::get('mail_from_name') ?? 'Pharmacy POS',
        ];

        return view('settings.email', compact('settings'));
    }

    public function updateEmailSettings(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer'       => 'required|string|max:20',
            'mail_host'         => 'required|string|max:255',
            'mail_port'         => 'required|string|max:10',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_encryption'   => 'nullable|string|max:10',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name'    => 'required|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Email settings updated successfully!');
    }

    public function paymentSettings()
    {
        $settings = [
            'payment_cash_enabled'   => Setting::get('payment_cash_enabled') ?? '1',
            'payment_card_enabled'   => Setting::get('payment_card_enabled') ?? '1',
            'payment_bank_enabled'   => Setting::get('payment_bank_enabled') ?? '1',
            'bank_details'           => Setting::get('bank_details') ?? '',
            'payment_cheque_enabled' => Setting::get('payment_cheque_enabled') ?? '0',
            'payment_other_enabled'  => Setting::get('payment_other_enabled') ?? '0',
            'payment_other_label'    => Setting::get('payment_other_label') ?? 'Other',
        ];

        return view('settings.payment', compact('settings'));
    }

    public function updatePaymentSettings(Request $request)
    {
        $validated = $request->validate([
            'payment_cash_enabled'   => 'nullable|in:0,1',
            'payment_card_enabled'   => 'nullable|in:0,1',
            'payment_bank_enabled'   => 'nullable|in:0,1',
            'bank_details'           => 'nullable|string',
            'payment_cheque_enabled' => 'nullable|in:0,1',
            'payment_other_enabled'  => 'nullable|in:0,1',
            'payment_other_label'    => 'nullable|string|max:50',
        ]);

        // Set checkbox values to 0 if not provided
        $checkboxes = [
            'payment_cash_enabled',
            'payment_card_enabled',
            'payment_bank_enabled',
            'payment_cheque_enabled',
            'payment_other_enabled',
        ];

        foreach ($checkboxes as $checkbox) {
            Setting::set($checkbox, isset($validated[$checkbox]) ? '1' : '0');
        }

        // Set other values
        foreach ($validated as $key => $value) {
            if (! in_array($key, $checkboxes)) {
                Setting::set($key, $value);
            }
        }

        return redirect()->back()->with('success', 'Payment settings updated successfully!');
    }

    public function sendTestEmail(Request $request)
    {
        // Validate the input
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            // Get the current email settings
            $mail_mailer       = Setting::get('mail_mailer');
            $mail_host         = Setting::get('mail_host');
            $mail_port         = Setting::get('mail_port');
            $mail_username     = Setting::get('mail_username');
            $mail_password     = Setting::get('mail_password');
            $mail_encryption   = Setting::get('mail_encryption');
            $mail_from_address = Setting::get('mail_from_address');
            $mail_from_name    = Setting::get('mail_from_name');

            // Temporarily set the mail configuration
            Config::set('mail.default', $mail_mailer);
            Config::set('mail.mailers.' . $mail_mailer . '.host', $mail_host);
            Config::set('mail.mailers.' . $mail_mailer . '.port', $mail_port);
            Config::set('mail.mailers.' . $mail_mailer . '.username', $mail_username);
            Config::set('mail.mailers.' . $mail_mailer . '.password', $mail_password);
            Config::set('mail.mailers.' . $mail_mailer . '.encryption', $mail_encryption);
            Config::set('mail.from.address', $mail_from_address);
            Config::set('mail.from.name', $mail_from_name);

            // Send the test email
            Mail::to($request->test_email)->send(new TestMail());

            return redirect()->back()->with('email_success', 'Test email sent successfully to ' . $request->test_email);
        } catch (Exception $e) {
            return redirect()->back()
                ->with('email_error', 'Failed to send test email.')
                ->with('error_details', $e->getMessage());
        }
    }
}
