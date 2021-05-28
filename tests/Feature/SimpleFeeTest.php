<?php

declare(strict_types=1);

/**
 * Contains the SimpleFeeTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-28
 *
 */

namespace Vanilo\Adjustments\Tests\Feature;

use Vanilo\Adjustments\Models\Adjustment;
use Vanilo\Adjustments\Tests\Examples\Order;
use Vanilo\Adjustments\Tests\TestCase;

class SimpleFeeTest extends TestCase
{
    /** @test */
    public function a_simple_fee_can_be_added_to_an_adjustable_order()
    {
        $order = Order::create(['items_total' => 10.99]);
        $order->addAdjustment(new Adjustment());

    }
}
