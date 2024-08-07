<?php

declare(strict_types=1);

namespace SonsOfPHP\Component\Money\Operator\Money;

use SonsOfPHP\Component\Money\Exception\MoneyException;
use SonsOfPHP\Component\Money\Money;
use SonsOfPHP\Contract\Money\MoneyInterface;
use SonsOfPHP\Contract\Money\MoneyOperatorInterface;

/**
 * @author Joshua Estes <joshua@sonsofphp.com>
 */
class AddMoneyOperator implements MoneyOperatorInterface
{
    public function __construct(private readonly MoneyInterface $money) {}

    public function apply(MoneyInterface $money): MoneyInterface
    {
        if (!$this->money->getCurrency()->isEqualTo($money->getCurrency())) {
            throw new MoneyException('Cannot add amounts together from different currencies');
        }

        $amount = $money->getAmount()->add($this->money->getAmount());

        return new Money($amount, $money->getCurrency());
    }
}
