<?php

declare(strict_types=1);

/**
 * Contains the AdjustmentTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-27
 *
 */

namespace Vanilo\Adjustments\Tests;

use Vanilo\Adjustments\Contracts\Adjustment as AdjustmentContract;
use Vanilo\Adjustments\Models\Adjustment;
use Vanilo\Adjustments\Models\AdjustmentType;

class AdjustmentTest extends TestCase
{
    /** @test */
    public function it_can_be_created_with_minimal_fields()
    {
        $adjustment = Adjustment::create([
            'type' => AdjustmentType::TAX,
            'adjustable_type' => 'order',
            'adjustable_id' => 1,
            'adjuster' => 'fixed_amount',
            'title' => 'Sales tax',
        ]);

        $this->assertInstanceOf(Adjustment::class, $adjustment);
        $this->assertInstanceOf(AdjustmentContract::class, $adjustment);
    }

    /** @test */
    public function the_type_field_is_an_enum()
    {
        $adjustment = Adjustment::create([
            'type' => AdjustmentType::TAX,
            'adjustable_type' => 'order',
            'adjustable_id' => 1,
            'adjuster' => 'fixed_amount',
            'title' => 'Sales tax',
        ]);

        $this->assertInstanceOf(AdjustmentType::class, $adjustment->type);
        $this->assertTrue($adjustment->type->equals(AdjustmentType::TAX()));
    }

    /** @test */
    public function is_not_locked_by_default()
    {
        $adjustment = Adjustment::create([
            'type' => AdjustmentType::TAX,
            'adjustable_type' => 'order',
            'adjustable_id' => 1,
            'adjuster' => 'fixed_amount',
            'title' => 'Sales tax',
        ])->fresh();

        $this->assertFalse($adjustment->is_locked);
    }

    /** @test */
    public function is_not_included_by_default()
    {
        $adjustment = Adjustment::create([
            'type' => AdjustmentType::TAX,
            'adjustable_type' => 'order',
            'adjustable_id' => 1,
            'adjuster' => 'fixed_amount',
            'title' => 'Sales tax',
        ])->fresh();

        $this->assertFalse($adjustment->is_included);
    }

    /** @test */
    public function all_mutable_fields_can_be_mass_assigned()
    {
        $adjustment = Adjustment::create([
            'type' => AdjustmentType::SHIPPING,
            'adjustable_type' => 'order',
            'adjustable_id' => 22791,
            'adjuster' => 'fixed_amount',
            'adjuster_identifier' => 'xgs123',
            'title' => 'Shipping',
            'description' => 'UPS Ground Delivery (1-3 days)',
            'data' => ['yo' => 'mo', 'do' => 'jo'],
            'amount' => 3.99,
            'is_locked' => true,
            'is_included' => true,
        ]);

        $this->assertEquals(AdjustmentType::SHIPPING, $adjustment->type->value());
        $this->assertEquals('order', $adjustment->adjustable_type);
        $this->assertEquals(22791, $adjustment->adjustable_id);
        $this->assertEquals('fixed_amount', $adjustment->adjuster);
        $this->assertEquals('xgs123', $adjustment->adjuster_identifier);
        $this->assertEquals('Shipping', $adjustment->title);
        $this->assertEquals('UPS Ground Delivery (1-3 days)', $adjustment->description);
        $this->assertEquals(['yo' => 'mo', 'do' => 'jo'], $adjustment->data);
        $this->assertEquals(3.99, $adjustment->amount);
        $this->assertTrue($adjustment->is_locked);
        $this->assertTrue($adjustment->is_included);
    }

    /** @test */
    public function all_mutable_fields_can_be_set()
    {
        $adjustment = new Adjustment();

        $adjustment->type = AdjustmentType::PROMOTION;
        $adjustment->adjustable_type = 'order_item';
        $adjustment->adjustable_id = 225487;
        $adjustment->adjuster = 'fixed_amount';
        $adjustment->adjuster_identifier = 555;
        $adjustment->title = 'Discount';
        $adjustment->description = 'Boxing Day Sale';
        $adjustment->data = ['be' => 'ba', 'bu' => 'bi'];
        $adjustment->amount = 11;
        $adjustment->is_locked = true;
        $adjustment->is_included = true;

        $this->assertEquals(AdjustmentType::PROMOTION, $adjustment->type->value());
        $this->assertEquals('order_item', $adjustment->adjustable_type);
        $this->assertEquals(225487, $adjustment->adjustable_id);
        $this->assertEquals('fixed_amount', $adjustment->adjuster);
        $this->assertEquals('555', $adjustment->adjuster_identifier);
        $this->assertEquals('Discount', $adjustment->title);
        $this->assertEquals('Boxing Day Sale', $adjustment->description);
        $this->assertIsArray($adjustment->data);
        $this->assertEquals(['be' => 'ba', 'bu' => 'bi'], $adjustment->data);
        $this->assertEquals(11, $adjustment->amount);
        $this->assertTrue($adjustment->is_locked);
        $this->assertTrue($adjustment->is_included);
    }
}
