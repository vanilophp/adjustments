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
use Vanilo\Adjustments\Contracts\Adjustable;
use Vanilo\Adjustments\Contracts\AdjustmentCollection as AdjustmentCollectionContract;

/**
 * @method static Order create(array $attributes = [])
 */
class Order extends Model implements Adjustable
{
    protected $guarded = ['created_at', 'updated_at'];

    public static function findById($id): ?Adjustable
    {
        return self::find($id);
    }

    public function adjustments(): AdjustmentCollectionContract
    {
        // TODO: Implement adjustments() method.
    }

    public function recalculateAdjustments(): void
    {
        // TODO: Implement recalculateAdjustments() method.
    }
}
