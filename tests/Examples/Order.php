<?php

declare(strict_types=1);

/**
 * Contains the Order class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-28
 *
 */

namespace Vanilo\Adjustments\Tests\Examples;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Vanilo\Adjustments\Contracts\Adjustable;
use Vanilo\Adjustments\Contracts\AdjustmentCollection as AdjustmentCollectionContract;
use Vanilo\Adjustments\Models\Adjustment;
use Vanilo\Adjustments\Support\HasAdjustmentsViaRelation;

/**
 * @method static Order create(array $attributes = [])
 */
class Order extends Model implements Adjustable
{
    use HasAdjustmentsViaRelation;

    protected $guarded = ['created_at', 'updated_at'];

    public function itemsTotal(): float
    {
        return 0;
    }

    public function recalculateAdjustments(): void
    {
        // TODO: Implement recalculateAdjustments() method.
    }
}
