<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default Walk in Customer
        Customer::create([
            'id'                   => 0,
            'name'                 => 'Walk in Customer',
            'email'                => 'walkin@example.com',
            'phone'                => '0000000000',
            'address'              => 'N/A',
            'city'                 => 'N/A',
            'state'                => 'N/A',
            'zip'                  => 'N/A',
            'opening_balance'      => 0,
            'opening_balance_type' => 'credit',
        ]);

        $this->call([
            PermissionSeeder::class,
            DummyDataSeeder::class,
            AccountSeeder::class,
            SettingsSedder::class,
        ]);

        // Create default User
        $user = User::create([
            'name'     => 'Mr Admin',
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('admin');
    }
}
