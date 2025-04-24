<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Site Settings
        $siteSettings = [
            'site_name'               => 'Pharmacy POS',
            'currency'                => 'USD',
            'currency_symbol'         => '$',
            'date_format'             => 'Y-m-d',
            'time_format'             => 'H:i:s',
            'default_tax'             => '0',
            'invoice_prefix'          => 'INV',
            'invoice_footer'          => 'Thank you for your business!',
            'default_language'        => 'en',
            'timezone'                => 'UTC',
            'low_stock_alert'         => '10',
            'barcode_type'            => 'CODE128',
            'maintenance_mode'        => '0',
            'allow_backorder'         => '0',
            'stock_expiry_alert_days' => '30',
            'pagination_limit'        => '10',
            'purchase_prefix'         => 'PUR',
            'return_prefix'           => 'RET',
            'sale_prefix'             => 'SAL',
            'default_account'         => '1',
            'site_logo'               => 'site/logo.png',
            'favicon'                 => 'site/favicon.png',
        ];

        // Company Settings
        $companySettings = [
            'company_name'                  => 'Pharmacy Name',
            'company_email'                 => 'info@example.com',
            'company_phone'                 => '+1234567890',
            'company_address'               => '',
            'company_city'                  => '',
            'company_state'                 => '',
            'company_zip'                   => '',
            'company_country'               => '',
            'tax_number'                    => '',
            'registration_number'           => '',
            'opening_time'                  => '09:00',
            'closing_time'                  => '18:00',
            'facebook_link'                 => '',
            'twitter_link'                  => '',
            'instagram_link'                => '',
            'linkedin_link'                 => '',
            'website_link'                  => '',
            'pharmacist_license'            => '',
            'prescription_required_message' => 'Prescription is required for this medicine.',
            'invoice_logo'                  => 'company/logo.png',
        ];

        // Email Settings
        $emailSettings = [
            'mail_mailer'       => 'smtp',
            'mail_host'         => 'smtp.mailtrap.io',
            'mail_port'         => '2525',
            'mail_username'     => '',
            'mail_password'     => '',
            'mail_encryption'   => 'tls',
            'mail_from_address' => 'info@pharmacy.com',
            'mail_from_name'    => 'Pharmacy POS',
        ];

        // Payment Settings
        $paymentSettings = [
            'payment_cash_enabled'   => '1',
            'payment_card_enabled'   => '1',
            'payment_bank_enabled'   => '1',
            'bank_details'           => '',
            'payment_cheque_enabled' => '0',
            'payment_other_enabled'  => '0',
            'payment_other_label'    => 'Other',
        ];

        // Merge all settings
        $allSettings = array_merge(
            $siteSettings,
            $companySettings,
            $emailSettings,
            $paymentSettings
        );

        // Save all settings
        foreach ($allSettings as $key => $value) {
            Setting::set($key, $value);
        }

        $this->command->info('Settings seeded successfully!');
    }
}
