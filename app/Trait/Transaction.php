<?php
namespace App\Trait;

use App\Models\Transaction as ModelsTransaction;

trait Transaction
{
    /**
     * Generate a unique transaction ID
     *
     * @return string
     */
    private function generateTransactionId()
    {
        return 'TRX-' . str_pad(ModelsTransaction::count() + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Save a transaction
     *
     * @param array $data['account_id', 'type', 'amount', 'transaction_date', 'description']
     * @return \App\Models\Transaction
     */
    private function saveTransaction(array $data)
    {
        ModelsTransaction::create([
            'transaction_id'   => $this->generateTransactionId(),
            'account_id'       => $data['account_id'],
            'type'             => $data['type'],
            'amount'           => $data['amount'],
            'transaction_date' => $data['transaction_date'],
            'description'      => $data['description'],
        ]);
    }

    /**
     * Update a transaction
     *
     * @param array $data['account_id', 'type', 'amount', 'transaction_date', 'description']
     * @return \App\Models\Transaction
     */
    private function updateTransaction(array $data)
    {
        $transaction = ModelsTransaction::find($data['id']);
        $transaction->update([
            'account_id'       => $data['account_id'],
            'type'             => $data['type'],
            'amount'           => $data['amount'],
            'transaction_date' => $data['transaction_date'],
            'description'      => $data['description'],
        ]);
        return $transaction;
    }
}
