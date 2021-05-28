<?php

declare(strict_types=1);

/**
 * Contains the AdjustmentCollection class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-28
 *
 */

namespace Vanilo\Adjustments\Support;

use Vanilo\Adjustments\Contracts\Adjustment;
use Vanilo\Adjustments\Contracts\AdjustmentCollection as AdjustmentCollectionContract;
use Vanilo\Adjustments\Contracts\AdjustmentType;

class AdjustmentCollection implements AdjustmentCollectionContract
{
    private array $items = [];

    public function total(): float
    {
        // TODO: Implement total() method.
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function add(Adjustment $adjustment): void
    {
        // TODO: Implement add() method.
    }

    public function remove(Adjustment $adjustment): void
    {
        // TODO: Implement remove() method.
    }

    public function byType(AdjustmentType $type): AdjustmentCollectionContract
    {
        // TODO: Implement byType() method.
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function count()
    {
        return count($this->items);
    }
}
