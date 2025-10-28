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
use PHPUnit\Runner\InvalidOrderException;

class BankAccount implements BankAccountInterface
{
    private $balance;
    private $status;
    private $overdraft;


    /**
     * Summary of __construct
     * @param float $initialBalance
     */
    public function __construct(float $initialBalance = 0.0)
    {
        // initialize balance
        $this->balance = $initialBalance;
        $this->status = BankAccountInterface::STATUS_OPEN;
        $this->overdraft = new NoOverdraft();
    }

    public function transaction(BankTransactionInterface $bankTransaction): void
    {
        if (!$this->isOpen()) {
        }
        try {
            $newBalance = $bankTransaction->applyTransaction($this);
            $this->setBalance($newBalance);
        } catch (InvalidOverdraftFundsException $e) {
            throw new FailedTransactionException("Erorr transaction: Insufficient balance to complete the withdrawal.", 0, $e);
        }
    }

    public function isOpen(): bool
    {
        return $this->status == BankAccountInterface::STATUS_OPEN;
    }

    public function reopenAccount(): void
    {
        if ($this->isOpen()) {
            throw new BankAccountException("La cuenta ya esta habieta");
        }
        $this->status = BankAccountInterface::STATUS_OPEN;
    }
    public function closeAccount(): void
    {
        $this->status = BankAccountInterface::STATUS_CLOSED;
    }
    public function getBalance(): float
    {
        return $this->balance;
    }
    public function getOverdraft(): OverdraftInterface
    {
        return $this->overdraft;
    }

    public function applyOverdraft(OverdraftInterface $overdraft): void
    {
        if (!$this->isOpen()) {
        }

        $this->overdraft = $overdraft;
    }

    public function setBalance(float $newBalance): void
    {
        $this->balance = $newBalance;
    }
}
