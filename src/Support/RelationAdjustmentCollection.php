<?php

declare(strict_types=1);

/**
 * Contains the RelationAdjustmentCollection class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-28
 *
 */

namespace Vanilo\Adjustments\Support;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Vanilo\Adjustments\Contracts\Adjustable;
use Vanilo\Adjustments\Contracts\Adjustment;
use Vanilo\Adjustments\Contracts\AdjustmentCollection;
use Vanilo\Adjustments\Contracts\AdjustmentType;

class RelationAdjustmentCollection implements AdjustmentCollection
{
    private Adjustable $model;

    public function __construct(Adjustable $model)
    {
        $this->model = $model;
    }

    public function total(): float
    {
        return floatval($this->eloquentCollection()->sum('amount'));
    }

    public function isEmpty(): bool
    {
        return $this->eloquentCollection()->isEmpty();
    }

    public function isNotEmpty(): bool
    {
        return $this->eloquentCollection()->isNotEmpty();
    }

    public function add(Adjustment $adjustment): void
    {
        $this->relation()->create(
            $this->adjustmentToModelAttributes($adjustment)
        );
    }

    public function remove(Adjustment $adjustment): void
    {
        if ($adjustment instanceof Model) {
            $items = $this->eloquentCollection();
            // This is the dirty part where it's flipping from Adjustment to Model
            $items->each(function (Model $item, $key) use ($adjustment, $items) {
                if ($item->getKey() === $adjustment->getKey()) {
                    $item->delete();
                    $items->forget($key);
                }
            });
        }
    }

    public function byType(AdjustmentType $type): AdjustmentCollection
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
        // TODO: Implement count() method.
    }

    private function adjustmentToModelAttributes(Adjustment $adjustment): array
    {
        return [
            'type' => $adjustment->getType(),
            'adjuster' => $adjustment->getAdjuster(),
            'origin' => $adjustment->getOrigin(),
            'title' => $adjustment->getTitle(),
            'description' => $adjustment->getDescription(),
            'data' => $adjustment->getData(),
            'amount' => $adjustment->getAmount(),
            'is_locked' => $adjustment->isLocked(),
            'is_included' => $adjustment->isIncluded(),
        ];
    }

    private function relation(): MorphMany
    {
        return $this->model->adjustmentsRelation();
    }

    private function eloquentCollection(): Collection
    {
        return $this->model->adjustmentsRelation;
    }
}
