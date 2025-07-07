# Store Implementation

This document explains how the store-specific data feature works in the Pharmacy Management System.

## Overview

The system now supports multiple stores/outlets, with data segregation by store. This allows:

-   Managing multiple pharmacy outlets from a single system
-   Keeping data (inventory, sales, purchases, etc.) separate by store
-   Switching between stores easily

## Key Components

1. **Store Migration**

    - Each store has its own record in the `stores` table
    - Related tables now have a `store_id` foreign key

2. **Store Middleware**

    - Checks if a store is selected in the session
    - Redirects to store selection page if no store is selected
    - Applied to all authenticated routes

3. **Store Selection**

    - Users select a store on login
    - Store ID is saved in the session
    - Users can change stores at any time

4. **HasStore Trait**
    - Models use this trait to automatically:
        - Save the current store_id when creating records
        - Apply a global scope to only show records for the current store
        - Add a store() relationship method

## Database Structure

The following tables have been updated with a `store_id` column:

-   medicines
-   medicine_categories
-   medicine_types
-   medicine_leafs
-   units
-   sales
-   purchases
-   customers
-   suppliers
-   vendors
-   expenses
-   expense_categories
-   accounts
-   transactions
-   stock_adjustments
-   sale_returns
-   purchase_returns

## Developer Guidelines

### Adding Store Support to a Model

1. Import the trait at the top of your model:

    ```php
    use App\Models\Traits\HasStore;
    ```

2. Add the trait to your model class:

    ```php
    use HasStore;
    ```

3. Add `store_id` to the fillable array:
    ```php
    protected $fillable = [
        'name',
        'store_id',
        // other fields...
    ];
    ```

### Bypassing the Store Filter

If you need to query across all stores, you can remove the global scope:

```php
$allRecords = YourModel::withoutGlobalScope('store')->get();
```

### Store Selection Flow

1. User logs in
2. StoreMiddleware checks if a store is selected
3. If not, redirects to the store selection page
4. User selects a store
5. Store ID is saved in the session
6. All database operations are now scoped to that store

## Frontend Integration

The current store is displayed in the navigation bar with a dropdown to change stores.

## Routes

-   `/select-store` - Shows the store selection page
-   `/set-store` - Sets the selected store in the session
-   `/change-store` - Clears the current store and goes to the selection page
