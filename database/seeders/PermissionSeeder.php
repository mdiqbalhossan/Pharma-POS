<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard'           => [
                'index',
            ],
            'pos'                 => [
                'index',
                'view_orders',
                'reset_order',
                'show_transaction',
            ],
            'sales'               => [
                'history',
                'invoice',
                'view',
                'return',
                'index',
                'create',
                'edit',
                'delete',
                'download',
            ],
            'sale_return'         => [
                'index',
                'create',
                'edit',
                'view',
                'delete',
            ],
            'reports'             => [
                'index',
                'sales',
                'purchases',
                'expenses',
                'inventory',
                'invoices',
                'suppliers',
                'customers',
                'income',
                'tax',
                'profit_loss',
            ],
            'expenses'            => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'expense_categories'  => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'medicine_types'      => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'medicine_leafs'      => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'units'               => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'medicine_categories' => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'medicines'           => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'barcode'             => [
                'print',
                'generate',
            ],
            'stock'               => [
                'index',
                'low_stock',
                'out_of_stock',
                'upcoming_expired',
                'already_expired',
            ],
            'stock_adjustments'   => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'purchases'           => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
                'invoice',
                'download',
                'convert',
                'order',
            ],
            'purchase_returns'    => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'customers'           => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'suppliers'           => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'vendors'             => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'accounts'            => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'transactions'        => [
                'index',
                'view',
            ],
            'trial_balance'       => [
                'index',
                'print',
                'download',
            ],
            'balance_sheet'       => [
                'index',
                'print',
                'download',
            ],
            'income_statement'    => [
                'index',
                'print',
                'download',
            ],
            'user'                => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'roles'               => [
                'index',
                'create',
                'edit',
                'delete',
                'view',
            ],
            'settings'            => [
                'site',
                'company',
                'email',
                'payment',
            ],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::create([
                    'group_name' => $module,
                    'name'       => $module . '-' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }

        $role = Role::create([
            'name'       => 'admin',
            'guard_name' => 'web',
        ]);

        $role->givePermissionTo(Permission::all());
    }
}
