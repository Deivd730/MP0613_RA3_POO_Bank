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
        $this->status = BankAccountInterface::STATUS_OPEN;
        $this->balance = $initialBalance;

    }

    public function transaction(BankTransactionInterface $bankTransaction): void
    {
        if (!$this->isOpen()) {
        }
        try {
            $newBalance = $bankTransaction->applyTransaction($this);
            $this->setBalance($newBalance);
        } catch (InvalidOverdraftFundsException $e) {
        }
    }

    public function isOpen()
    {
        $this->status = BankAccountInterface::STATUS_OPEN;
    }

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

    public function setBalance(float $newBalance): void
    {
        $this->balance = $newBalance;
    }
}
