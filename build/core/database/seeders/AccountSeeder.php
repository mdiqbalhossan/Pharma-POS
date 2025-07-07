<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'        => 'Cash Account',
                'type'        => 'asset',
                'description' => 'Tracks cash transactions',
            ],
            [
                'name'        => 'Bank Account',
                'type'        => 'asset',
                'description' => 'Records transactions through the bank',
            ],
            [
                'name'        => 'Accounts Receivable',
                'type'        => 'asset',
                'description' => 'Tracks money owed by customers on credit sales',
            ],
            [
                'name'        => 'Inventory Account',
                'type'        => 'asset',
                'description' => 'Holds stock value of medicines',
            ],
            [
                'name'        => 'Accounts Payable',
                'type'        => 'liability',
                'description' => 'Tracks money the pharmacy owes to suppliers',
            ],
            [
                'name'        => 'Sales Revenue',
                'type'        => 'income',
                'description' => 'Records pharmacy\'s earnings from medicine sales',
            ],
            [
                'name'        => 'Expenses (Rent, Salaries, etc.)',
                'type'        => 'expense',
                'description' => 'Tracks pharmacy\'s operational costs',
            ],
        ];
    }
}
