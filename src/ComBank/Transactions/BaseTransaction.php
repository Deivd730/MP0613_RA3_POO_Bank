<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:24 PM
 */

use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Support\Traits\AmountValidationTrait;

use function PHPUnit\Framework\throwException;

abstract class BaseTransaction
{

    protected $amount;
    /**
     * Summary of __construct
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        if($amount<=0){
            throw new ZeroAmountException("error");
        }
        $this->amount = $amount;
    }

    /**
     * Summary of getAmount
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
