<?php

namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount implements BankAccountInterface
{
    private $balance;
    private $status;
    

    /**
     * Summary of __construct
     * @param float $initialBalance
     */
    public function __construct(float $initialBalance = 0.0)
    {
        // initialize balance
        $this->balance = $initialBalance;
        $this->status = BankAccountInterface::STATUS_OPEN;
        
    }

    public function transaction(BankTransactionInterface $transaction): void {}

    public function reopenAccount()
    {
        $this->status = BankAccountInterface::STATUS_OPEN;
    }
    public function closeAccount()
    {
        $this->status = BankAccountInterface::STATUS_CLOSED;
    }
    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $newBalance): void {}
}
