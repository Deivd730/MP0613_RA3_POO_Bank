<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{


    public function __construct(float $amount)
    {
        parent::__construct($amount);
    }

    public function applyTransaction(BankAccountInterface $bank_account_interface): float
    {
        return $bank_account_interface->getBalance() + $this->getAmount();
    }

    public function getTransactionInfo(): string
    {
        return "Deposit of amount: " . $this->getAmount();
    }
}
