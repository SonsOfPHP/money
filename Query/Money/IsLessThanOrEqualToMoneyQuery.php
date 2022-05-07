<?php

declare(strict_types=1);

namespace SonsOfPHP\Component\Money\Query\Money;

use SonsOfPHP\Component\Money\MoneyInterface;
use SonsOfPHP\Component\Money\Exception\MoneyException;

/**
 * @author Joshua Estes <joshua@sonsofphp.com>
 */
class IsLessThanOrEqualToMoneyQuery implements MoneyQueryInterface
{
    private MoneyInterface $money;

    public function __construct(MoneyInterface $money)
    {
        $this->money = $money;
    }

    /**
     * {@inheritdoc}
     */
    public function queryFrom(MoneyInterface $money)
    {
        if (!$money->getCurrency()->isEqualTo($this->money->getCurrency())) {
            throw new MoneyException('Cannot use different currencies');
        }

        return $money->getAmount()->isLessThanOrEqualTo($this->money->getAmount());
    }
}
