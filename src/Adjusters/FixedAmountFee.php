<?php

declare(strict_types=1);

/**
 * Contains the FixedAmountFee class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-28
 *
 */

namespace Vanilo\Adjustments\Adjusters;

use Vanilo\Adjustments\Contracts\Adjustable;
use Vanilo\Adjustments\Contracts\Adjuster;

class FixedAmountFee implements Adjuster
{
    public static function fromAdjustable(Adjustable $adjustable): Adjuster
    {
        return new self();
    }

    public function calculate(): float
    {
        // TODO: Implement calculate() method.
    }
}
