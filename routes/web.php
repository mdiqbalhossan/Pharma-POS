<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\BarcodeGenerateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeStatementController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MedicineCategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineLeafController;
use App\Http\Controllers\MedicineTypeController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TrialBalanceController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return redirect()->back()->with('success', 'Cache cleared successfully');
});

// Storage Link
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return redirect()->back()->with('success', 'Storage linked successfully');
});

Route::middleware('auth')->group(function () {

    // Language
    Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    //Role
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('expense-categories', ExpenseCategoryController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('medicine-types', MedicineTypeController::class);
    Route::resource('medicine-leafs', MedicineLeafController::class);
    Route::resource('units', UnitController::class);
    Route::resource('medicine-categories', MedicineCategoryController::class);
    Route::resource('medicines', MedicineController::class);

    // AJAX routes for modal forms
    Route::post('/ajax/units/store', [UnitController::class, 'ajaxStore'])->name('units.ajax.store');
    Route::post('/ajax/medicine-categories/store', [MedicineCategoryController::class, 'ajaxStore'])->name('medicine-categories.ajax.store');
    Route::post('/ajax/medicine-types/store', [MedicineTypeController::class, 'ajaxStore'])->name('medicine-types.ajax.store');
    Route::post('/ajax/medicine-leafs/store', [MedicineLeafController::class, 'ajaxStore'])->name('medicine-leafs.ajax.store');
    Route::post('/ajax/suppliers/store', [SupplierController::class, 'ajaxStore'])->name('suppliers.ajax.store');
    Route::post('/ajax/vendors/store', [VendorController::class, 'ajaxStore'])->name('vendors.ajax.store');

    // Stock
    Route::controller(StockController::class)->group(function () {
        Route::get('/manage-stock', 'index')->name('stock.index');
        Route::get('/low-stock', 'lowStock')->name('stock.low-stock');
        Route::get('/out-of-stock', 'outOfStock')->name('stock.out-of-stock');
        Route::get('/upcoming-expired', 'upcomingExpired')->name('stock.upcoming-expired');
        Route::get('/already-expired', 'alreadyExpired')->name('stock.already-expired');
    });

    // Purchase
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases/get-details/{purchase}', [PurchaseController::class, 'getDetails'])->name('purchases.get-details');
    Route::post('purchases/convert/{purchase}', [PurchaseController::class, 'convertPurchaseOrder'])->name('purchases.convert');
    Route::get('purchases/{purchase}/invoice', [PurchaseController::class, 'invoice'])->name('purchases.invoice');
    Route::get('purchases/{purchase}/download', [PurchaseController::class, 'downloadInvoice'])->name('purchases.download');
    Route::get('purchase/order', [PurchaseController::class, 'purchaseOrder'])->name('purchase.order');

    // Purchase Return
    Route::resource('purchase-returns', PurchaseReturnController::class);
    Route::get('purchases/{purchase}/return', [PurchaseReturnController::class, 'createFromPurchase'])->name('purchases.return');

    // Medicine search for purchase
    Route::get('/medicines-search', [AjaxController::class, 'searchMedicines'])->name('medicines.search');

    // Stock Adjustment
    Route::resource('stock-adjustments', StockAdjustmentController::class);

    // Print Barcode
    Route::controller(BarcodeGenerateController::class)->group(function () {
        Route::get('/print-barcode', 'index')->name('print.barcode');
        Route::get('/search-medicine', 'searchMedicine')->name('barcode.search-medicine');
        Route::post('/generate-barcode', 'generateBarcode')->name('barcode.generate');
    });

    // Account
    Route::resource('accounts', AccountController::class);
    // Transaction
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions', 'index')->name('transactions.index');
        Route::get('/transactions/{transaction}', 'show')->name('transactions.show');
    });
    // Trial Balance
    Route::get('/trial-balance', [TrialBalanceController::class, 'index'])->name('trial-balance.index');
    Route::get('/trial-balance/print', [TrialBalanceController::class, 'print'])->name('trial-balance.print');
    Route::get('/trial-balance/download', [TrialBalanceController::class, 'download'])->name('trial-balance.download');

    // Balance Sheet
    Route::get('/balance-sheet', [BalanceSheetController::class, 'index'])->name('balance-sheet.index');
    Route::get('/balance-sheet/print', [BalanceSheetController::class, 'print'])->name('balance-sheet.print');
    Route::get('/balance-sheet/download', [BalanceSheetController::class, 'download'])->name('balance-sheet.download');

    // Income Statement
    Route::get('/income-statement', [IncomeStatementController::class, 'index'])->name('income-statement.index');
    Route::get('/income-statement/print', [IncomeStatementController::class, 'print'])->name('income-statement.print');
    Route::get('/income-statement/download', [IncomeStatementController::class, 'download'])->name('income-statement.download');

    // POS
    Route::controller(PosController::class)->group(function () {
        Route::get('/pos', 'index')->name('pos.index');
        Route::get('/pos/search', 'search')->name('pos.search');
        Route::post('/pos/customer/store', 'storeCustomer')->name('pos.customer.store');
        Route::get('/pos/medicine/{id}', 'getMedicine')->name('pos.medicine');
        Route::get('/pos/alternate-medicines/{id}', 'getAlternateMedicines')->name('pos.alternate-medicines');
        Route::get('/pos/search-orders', 'searchOrders')->name('pos.search.orders');
        Route::get('/pos/get-orders', 'getOrders')->name('pos.get.orders');
    });

    // Sales
    Route::controller(SalesController::class)->group(function () {
        Route::get('/sales', 'index')->name('sales.index');
        Route::post('/sales', 'store')->name('sales.store');
        Route::get('/sales/{sale}', 'show')->name('sales.show');
        Route::get('/sales/{sale}/invoice', 'invoice')->name('sales.invoice');
        Route::get('/sales/{sale}/download', 'downloadInvoice')->name('sales.download.invoice');
        Route::get('/sales/{sale}/details', 'getOrderDetails')->name('sales.details');
        Route::get('/sales/{sale}/products', 'getOrderProducts')->name('sales.products');
        Route::get('/sales/{sale}/receipt', 'getOrderReceipt')->name('sales.receipt');
    });

    // Sale Return
    Route::resource('sale-returns', SaleReturnController::class);
    Route::get('sales/{sale}/return', [SaleReturnController::class, 'createFromSale'])->name('sales.return');

    // Settings
    Route::controller(SettingController::class)->group(function () {
        Route::get('/site-settings', 'siteSettings')->name('settings.site');
        Route::post('/site-settings', 'updateSiteSettings')->name('settings.site.update');
        Route::get('/company-settings', 'companySettings')->name('settings.company');
        Route::post('/company-settings', 'updateCompanySettings')->name('settings.company.update');
        Route::get('/email-settings', 'emailSettings')->name('settings.email');
        Route::post('/email-settings', 'updateEmailSettings')->name('settings.email.update');
        Route::post('/email-settings/test', 'sendTestEmail')->name('settings.email.test');
        Route::get('/payment-settings', 'paymentSettings')->name('settings.payment');
        Route::post('/payment-settings', 'updatePaymentSettings')->name('settings.payment.update');
    });

    // Reports
    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports/sales', 'salesReport')->name('reports.sales');
        Route::get('/reports/purchases', 'purchaseReport')->name('reports.purchases');
        Route::get('/reports/inventory', 'inventoryReport')->name('reports.inventory');
        Route::get('/reports/invoices', 'invoiceReport')->name('reports.invoices');
        Route::get('/reports/suppliers', 'supplierReport')->name('reports.suppliers');
        Route::get('/reports/customers', 'customerReport')->name('reports.customers');
        Route::get('/reports/expenses', 'expenseReport')->name('reports.expenses');
        Route::get('/reports/income', 'incomeReport')->name('reports.income');
        Route::get('/reports/tax', 'taxReport')->name('reports.tax');
        Route::get('/reports/profit-loss', 'profitLossReport')->name('reports.profit-loss');
    });
});

require __DIR__ . '/auth.php';
