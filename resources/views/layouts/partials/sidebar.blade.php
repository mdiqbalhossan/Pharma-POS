<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @canany(['dashboard-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.main') }}</h6>
                        <ul>
                            @can('dashboard-index')
                                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard') }}"
                                        class="{{ request()->is('dashboard') ? 'subdrop active' : '' }}"><i
                                            data-feather="grid"></i><span>{{ __('sidebar.dashboard') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['sales-index', 'sale-returns.*', 'pos-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.sales') }}</h6>
                        <ul>
                            @can('sales-index')
                                <li class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
                                    <a href="{{ route('sales.index') }}"
                                        class="{{ request()->routeIs('sales.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="shopping-cart"></i><span>{{ __('sidebar.sales') }}</span></a>
                                </li>
                            @endcan
                            @can('sale_return-index')
                                <li class="{{ request()->routeIs('sale-returns.*') ? 'active' : '' }}">
                                    <a href="{{ route('sale-returns.index') }}"
                                        class="{{ request()->routeIs('sale-returns.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="refresh-cw"></i><span>{{ __('sidebar.sale_returns') }}</span></a>
                                </li>
                            @endcan
                            @can('pos-index')
                                <li class="{{ request()->routeIs('pos.*') ? 'active' : '' }}">
                                    <a href="{{ route('pos.index') }}"
                                        class="{{ request()->routeIs('pos.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="hard-drive"></i><span>{{ __('sidebar.pos') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['reports-sales', 'reports-purchases', 'reports-inventory', 'reports-invoices',
                    'reports-suppliers', 'reports-customers', 'reports-expenses', 'reports-income', 'reports-tax',
                    'reports-profit_loss'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.reports') }}</h6>
                        <ul>
                            @can('reports-sales')
                                <li class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                                    <a href="{{ route('reports.sales') }}"
                                        class="{{ request()->routeIs('reports.sales') ? 'subdrop active' : '' }}"><i
                                            data-feather="bar-chart-2"></i><span>{{ __('sidebar.sales_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-purchases')
                                <li class="{{ request()->routeIs('reports.purchases') ? 'active' : '' }}">
                                    <a href="{{ route('reports.purchases') }}"
                                        class="{{ request()->routeIs('reports.purchases') ? 'subdrop active' : '' }}"><i
                                            data-feather="pie-chart"></i><span>{{ __('sidebar.purchase_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-inventory')
                                <li class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}">
                                    <a href="{{ route('reports.inventory') }}"
                                        class="{{ request()->routeIs('reports.inventory') ? 'subdrop active' : '' }}"><i
                                            data-feather="inbox"></i><span>{{ __('sidebar.inventory_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-invoices')
                                <li class="{{ request()->routeIs('reports.invoices') ? 'active' : '' }}"><a
                                        href="{{ route('reports.invoices') }}"><i
                                            data-feather="file"></i><span>{{ __('sidebar.invoice_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-suppliers')
                                <li class="{{ request()->routeIs('reports.suppliers') ? 'active' : '' }}"><a
                                        href="{{ route('reports.suppliers') }}"><i
                                            data-feather="user-check"></i><span>{{ __('sidebar.supplier_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-customers')
                                <li class="{{ request()->routeIs('reports.customers') ? 'active' : '' }}"><a
                                        href="{{ route('reports.customers') }}"><i
                                            data-feather="user"></i><span>{{ __('sidebar.customer_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-expenses')
                                <li class="{{ request()->routeIs('reports.expenses') ? 'active' : '' }}"><a
                                        href="{{ route('reports.expenses') }}"><i
                                            data-feather="file"></i><span>{{ __('sidebar.expense_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-income')
                                <li class="{{ request()->routeIs('reports.income') ? 'active' : '' }}"><a
                                        href="{{ route('reports.income') }}"><i
                                            data-feather="bar-chart"></i><span>{{ __('sidebar.income_report') }}</span></a>
                                </li>
                            @endcan
                            @can('reports-tax')
                                <li class="{{ request()->routeIs('reports.tax') ? 'active' : '' }}"><a
                                        href="{{ route('reports.tax') }}"><i
                                            data-feather="database"></i><span>{{ __('sidebar.tax_report') }}</span></a></li>
                            @endcan
                            @can('reports-profit_loss')
                                <li class="{{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}"><a
                                        href="{{ route('reports.profit-loss') }}"><i
                                            data-feather="pie-chart"></i><span>{{ __('sidebar.profit_loss') }}</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['medicine_types-index', 'medicine_leafs-index', 'units-index', 'medicine_categories-index',
                    'medicines-index', 'barcode-print', 'stock-index', 'stock-low_stock', 'stock-out_of_stock',
                    'stock-upcoming_expired', 'stock-already_expired', 'stock_adjustments-index', 'purchases-index',
                    'purchase.order', 'purchase_returns-index', 'customers-index', 'suppliers-index', 'vendors-index',
                    'expenses-index', 'expense_categories-index', 'accounts-index', 'transactions-index',
                    'trial_balance-index', 'balance_sheet-index', 'income_statement-index', 'user-index', 'roles-index',
                    'settings-site', 'settings-company', 'settings-email', 'settings-payment'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.medicine_management') }}</h6>
                        <ul>
                            @can('medicine_types-index')
                                <li class="{{ request()->routeIs('medicine-types.*') ? 'active' : '' }}"><a
                                        href="{{ route('medicine-types.index') }}"
                                        class="{{ request()->routeIs('medicine-types.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="user-check"></i><span>{{ __('sidebar.medicine_types') }}</span></a>
                                </li>
                            @endcan
                            @can('medicine_leafs-index')
                                <li class="{{ request()->routeIs('medicine-leafs.*') ? 'active' : '' }}"><a
                                        href="{{ route('medicine-leafs.index') }}"
                                        class="{{ request()->routeIs('medicine-leafs.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="shield"></i><span>{{ __('sidebar.medicine_leafs') }}</span></a></li>
                            @endcan
                            @can('units-index')
                                <li class="{{ request()->routeIs('units.*') ? 'active' : '' }}"><a
                                        href="{{ route('units.index') }}"
                                        class="{{ request()->routeIs('units.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="box"></i><span>{{ __('sidebar.units') }}</span></a></li>
                            @endcan
                            @can('medicine_categories-index')
                                <li class="{{ request()->routeIs('medicine-categories.*') ? 'active' : '' }}"><a
                                        href="{{ route('medicine-categories.index') }}"
                                        class="{{ request()->routeIs('medicine-categories.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="box"></i><span>{{ __('sidebar.medicine_categories') }}</span></a>
                                </li>
                            @endcan
                            @can('medicines-index')
                                <li class="{{ request()->routeIs('medicines.*') ? 'active' : '' }}"><a
                                        href="{{ route('medicines.index') }}"
                                        class="{{ request()->routeIs('medicines.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="list"></i><span>{{ __('sidebar.medicine_list') }}</span></a></li>
                            @endcan
                            @can('barcode-print')
                                <li class="{{ request()->routeIs('print.barcode') ? 'active' : '' }}"><a
                                        href="{{ route('print.barcode') }}"
                                        class="{{ request()->routeIs('print.barcode') ? 'subdrop active' : '' }}"><i
                                            data-feather="printer"></i><span>{{ __('sidebar.print_barcode') }}</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['stock-index', 'stock-low_stock', 'stock-out_of_stock', 'stock-upcoming_expired',
                    'stock-already_expired', 'stock_adjustments-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.stock') }}</h6>
                        <ul>
                            @can('stock-index')
                                <li class="{{ request()->routeIs('stock.index') ? 'active' : '' }}"><a
                                        href="{{ route('stock.index') }}"
                                        class="{{ request()->routeIs('stock.index') ? 'subdrop active' : '' }}"><i
                                            data-feather="package"></i><span>{{ __('sidebar.manage_stock') }}</span></a>
                                </li>
                            @endcan
                            @can('stock-low_stock')
                                <li class="{{ request()->routeIs('stock.low-stock') ? 'active' : '' }}"><a
                                        href="{{ route('stock.low-stock') }}"
                                        class="{{ request()->routeIs('stock.low-stock') ? 'subdrop active' : '' }}"><i
                                            data-feather="package"></i><span>{{ __('sidebar.low_stock') }}</span></a>
                                </li>
                            @endcan
                            @can('stock-out_of_stock')
                                <li class="{{ request()->routeIs('stock.out-of-stock') ? 'active' : '' }}"><a
                                        href="{{ route('stock.out-of-stock') }}"
                                        class="{{ request()->routeIs('stock.out-of-stock') ? 'subdrop active' : '' }}"><i
                                            data-feather="package"></i><span>{{ __('sidebar.out_of_stock') }}</span></a>
                                </li>
                            @endcan
                            @can('stock-upcoming_expired')
                                <li class="{{ request()->routeIs('stock.upcoming-expired') ? 'active' : '' }}"><a
                                        href="{{ route('stock.upcoming-expired') }}"
                                        class="{{ request()->routeIs('stock.upcoming-expired') ? 'subdrop active' : '' }}"><i
                                            data-feather="package"></i><span>{{ __('sidebar.upcoming_expired') }}</span></a>
                                </li>
                            @endcan
                            @can('stock-already_expired')
                                <li class="{{ request()->routeIs('stock.already-expired') ? 'active' : '' }}"><a
                                        href="{{ route('stock.already-expired') }}"
                                        class="{{ request()->routeIs('stock.already-expired') ? 'subdrop active' : '' }}"><i
                                            data-feather="package"></i><span>{{ __('sidebar.already_expired') }}</span></a>
                                </li>
                            @endcan
                            @can('stock_adjustments-index')
                                <li class="{{ request()->routeIs('stock-adjustments.*') ? 'active' : '' }}"><a
                                        href="{{ route('stock-adjustments.index') }}"
                                        class="{{ request()->routeIs('stock-adjustments.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="clipboard"></i><span>{{ __('sidebar.stock_adjustment') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['purchases-index', 'purchases-order', 'purchase_returns-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.purchases') }}</h6>
                        <ul>
                            @can('purchases-index')
                                <li class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}"><a
                                        href="{{ route('purchases.index') }}"
                                        class="{{ request()->routeIs('purchases.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="shopping-bag"></i><span>{{ __('sidebar.purchases') }}</span></a>
                                </li>
                            @endcan
                            @can('purchases-order')
                                <li class="{{ request()->routeIs('purchase.order') ? 'active' : '' }}"><a
                                        href="{{ route('purchase.order') }}"
                                        class="{{ request()->routeIs('purchase.order') ? 'subdrop active' : '' }}"><i
                                            data-feather="file-minus"></i><span>{{ __('sidebar.purchase_order') }}</span></a>
                                </li>
                            @endcan
                            @can('purchase_returns-index')
                                <li class="{{ request()->routeIs('purchase-returns.*') ? 'active' : '' }}"><a
                                        href="{{ route('purchase-returns.index') }}"
                                        class="{{ request()->routeIs('purchase-returns.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="refresh-cw"></i><span>{{ __('sidebar.purchase_return') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['customers-index', 'suppliers-index', 'vendors-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.peoples') }}</h6>
                        <ul>
                            @can('customers-index')
                                <li class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"><a
                                        href="{{ route('customers.index') }}"
                                        class="{{ request()->routeIs('customers.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="user"></i><span>{{ __('sidebar.customers') }}</span></a></li>
                            @endcan
                            @can('suppliers-index')
                                <li class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}"><a
                                        href="{{ route('suppliers.index') }}"
                                        class="{{ request()->routeIs('suppliers.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="users"></i><span>{{ __('sidebar.suppliers') }}</span></a></li>
                            @endcan
                            @can('vendors-index')
                                <li class="{{ request()->routeIs('vendors.*') ? 'active' : '' }}"><a
                                        href="{{ route('vendors.index') }}"
                                        class="{{ request()->routeIs('vendors.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="users"></i><span>{{ __('sidebar.vendors') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['expenses-index', 'expense_categories-index', 'accounts-index', 'transactions-index',
                    'trial_balance-index', 'balance_sheet-index', 'income_statement-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.finance_accounts') }}</h6>
                        <ul>
                            @can('expenses-index')
                                <li
                                    class="submenu {{ request()->routeIs('expenses.*') || request()->routeIs('expense-categories.*') ? 'active' : '' }}">
                                    <a href="javascript:void(0);"
                                        class="{{ request()->routeIs('expenses.*') || request()->routeIs('expense-categories.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="file-text"></i><span>{{ __('sidebar.expenses') }}</span><span
                                            class="menu-arrow"></span></a>
                                    <ul>
                                        @can('expenses-index')
                                            <li class="{{ request()->routeIs('expenses.*') ? 'active' : '' }}"><a
                                                    href="{{ route('expenses.index') }}">{{ __('sidebar.expenses') }}</a></li>
                                        @endcan
                                        @can('expense_categories-index')
                                            <li class="{{ request()->routeIs('expense-categories.*') ? 'active' : '' }}"><a
                                                    href="{{ route('expense-categories.index') }}">{{ __('sidebar.expense_category') }}</a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('accounts-index')
                                <li class="{{ request()->routeIs('accounts.*') ? 'active' : '' }}"><a
                                        href="{{ route('accounts.index') }}"
                                        class="{{ request()->routeIs('accounts.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="user"></i><span>{{ __('sidebar.accounts') }}</span></a></li>
                            @endcan
                            @can('transactions-index')
                                <li class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}"><a
                                        href="{{ route('transactions.index') }}"
                                        class="{{ request()->routeIs('transactions.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="repeat"></i><span>{{ __('sidebar.transactions') }}</span></a></li>
                            @endcan
                            @can('trial_balance-index')
                                <li class="{{ request()->routeIs('trial-balance.*') ? 'active' : '' }}"><a
                                        href="{{ route('trial-balance.index') }}"
                                        class="{{ request()->routeIs('trial-balance.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="credit-card"></i><span>{{ __('sidebar.trial_balance') }}</span></a>
                                </li>
                            @endcan
                            @can('balance_sheet-index')
                                <li class="{{ request()->routeIs('balance-sheet.*') ? 'active' : '' }}"><a
                                        href="{{ route('balance-sheet.index') }}"
                                        class="{{ request()->routeIs('balance-sheet.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="dollar-sign"></i><span>{{ __('sidebar.balance_sheet') }}</span></a>
                                </li>
                            @endcan
                            @can('income_statement-index')
                                <li class="{{ request()->routeIs('income-statement.*') ? 'active' : '' }}"><a
                                        href="{{ route('income-statement.index') }}"
                                        class="{{ request()->routeIs('income-statement.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="corner-down-right"></i><span>{{ __('sidebar.income_statement') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['user-index', 'roles-index'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.user_management') }}</h6>
                        <ul>
                            @can('user-index')
                                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><a
                                        href="{{ route('users.index') }}"
                                        class="{{ request()->routeIs('users.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="user-check"></i><span>{{ __('sidebar.users') }}</span></a>
                                </li>
                            @endcan
                            @can('roles-index')
                                <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><a
                                        href="{{ route('roles.index') }}"
                                        class="{{ request()->routeIs('roles.*') ? 'subdrop active' : '' }}"><i
                                            data-feather="shield"></i><span>{{ __('sidebar.roles_permissions') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['settings-site', 'settings-company', 'settings-email', 'settings-payment'])
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{ __('sidebar.settings') }}</h6>
                        <ul>
                            @can('settings-site')
                                <li class="{{ request()->routeIs('settings.site') ? 'active' : '' }}"><a
                                        href="{{ route('settings.site') }}"
                                        class="{{ request()->routeIs('settings.site') ? 'subdrop active' : '' }}"><i
                                            data-feather="settings"></i><span>{{ __('sidebar.site_settings') }}</span></a>
                                </li>
                            @endcan
                            @can('settings-company')
                                <li class="{{ request()->routeIs('settings.company') ? 'active' : '' }}"><a
                                        href="{{ route('settings.company') }}"
                                        class="{{ request()->routeIs('settings.company') ? 'subdrop active' : '' }}"><i
                                            data-feather="briefcase"></i><span>{{ __('sidebar.company_settings') }}</span></a>
                                </li>
                            @endcan
                            @can('settings-email')
                                <li class="{{ request()->routeIs('settings.email') ? 'active' : '' }}"><a
                                        href="{{ route('settings.email') }}"
                                        class="{{ request()->routeIs('settings.email') ? 'subdrop active' : '' }}"><i
                                            data-feather="mail"></i><span>{{ __('sidebar.email_settings') }}</span></a>
                                </li>
                            @endcan
                            @can('settings-payment')
                                <li class="{{ request()->routeIs('settings.payment') ? 'active' : '' }}"><a
                                        href="{{ route('settings.payment') }}"
                                        class="{{ request()->routeIs('settings.payment') ? 'subdrop active' : '' }}"><i
                                            data-feather="credit-card"></i><span>{{ __('sidebar.payment_settings') }}</span></a>
                                </li>
                            @endcan
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout_form').submit();"><i
                                        data-feather="log-out"></i><span>{{ __('sidebar.logout') }}</span> </a>
                                <form method="POST" action="{{ route('logout') }}" id="logout_form">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
