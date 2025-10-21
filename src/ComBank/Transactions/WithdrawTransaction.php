<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function __construct(float $amount)
    {
        return parent::__construct($amount);
    }

    public function applyTransaction(BankAccountInterface $bank_account_interface): float
    {
        return $bank_account_interface->getBalance() - $this->getAmount();
    }

    public function getTransactionInfo(): string
    {
        return "Withdrawal of amount: " . $this->getAmount();
    }
}
