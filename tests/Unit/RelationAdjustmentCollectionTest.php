<?php

declare(strict_types=1);

/**
 * Contains the RelationAdjustmentCollectionTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-29
 *
 */

namespace Vanilo\Adjustments\Tests\Unit;

use Countable;
use InvalidArgumentException;
use stdClass;
use Vanilo\Adjustments\Adjusters\SimpleShippingFee;
use Vanilo\Adjustments\Contracts\AdjustmentCollection;
use Vanilo\Adjustments\Models\Adjustment;
use Vanilo\Adjustments\Models\AdjustmentType;
use Vanilo\Adjustments\Support\RelationAdjustmentCollection;
use Vanilo\Adjustments\Tests\Examples\Order;
use Vanilo\Adjustments\Tests\TestCase;

class RelationAdjustmentCollectionTest extends TestCase
{
    /** @test */
    public function it_implements_the_interface()
    {
        $this->assertInstanceOf(
            AdjustmentCollection::class,
            new RelationAdjustmentCollection(new Order())
        );
    }

    /** @test */
    public function it_is_empty_by_default()
    {
        $c = new RelationAdjustmentCollection(new Order());

        $this->assertTrue($c->isEmpty());
        $this->assertEmpty($c);
        $this->assertFalse($c->isNotEmpty());
    }

    /** @test */
    public function it_is_countable()
    {
        $c = new RelationAdjustmentCollection(new Order());

        $this->assertInstanceOf(Countable::class, $c);
        $this->assertCount(0, $c);
    }

    /** @test */
    public function items_can_be_added_to_it()
    {
        $order = new Order();
        $collection = new RelationAdjustmentCollection($order);

        $collection->add(new SimpleShippingFee($order));
        $this->assertCount(1, $collection);
        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($collection->isNotEmpty());
    }

    /** @test */
    public function an_item_can_be_removed_from_it()
    {
        $collection = new RelationAdjustmentCollection();

        $adjustment = new Adjustment();
        $collection->add($adjustment);
        $this->assertCount(1, $collection);

        $collection->remove($adjustment);
        $this->assertCount(0, $collection);
    }

    /** @test */
    public function the_total_can_be_retrieved()
    {
        $collection = new RelationAdjustmentCollection();

        $collection->add(new Adjustment(['amount' => 32.21]));
        $collection->add(new Adjustment(['amount' => 21.32]));

        $this->assertEquals(53.53, $collection->total());
    }

    /** @test */
    public function items_can_be_accessed_as_array_members()
    {
        $collection = new RelationAdjustmentCollection();

        $collection->add(new Adjustment(['type' => AdjustmentType::PROMOTION, 'amount' => 10]));
        $collection->add(new Adjustment(['type' => AdjustmentType::SHIPPING, 'amount' => 4.79]));

        $this->assertInstanceOf(Adjustment::class, $collection[0]);
        $this->assertEquals(AdjustmentType::PROMOTION, $collection[0]->getType()->value());
        $this->assertEquals(10, $collection[0]->getAmount());

        $this->assertInstanceOf(Adjustment::class, $collection[1]);
        $this->assertEquals(AdjustmentType::SHIPPING, $collection[1]->getType()->value());
        $this->assertEquals(4.79, $collection[1]->getAmount());
    }

    /** @test */
    public function existence_of_array_items_can_be_checked_using_isset()
    {
        $collection = new RelationAdjustmentCollection();

        $collection->add(new Adjustment());
        $collection->add(new Adjustment());

        $this->assertTrue(isset($collection[0]));
        $this->assertTrue(isset($collection[1]));
        $this->assertFalse(isset($collection[2]));
    }

    /** @test */
    public function items_can_directly_set_via_array_mutator()
    {
        $collection = new RelationAdjustmentCollection();

        $collection[0] = new Adjustment();

        $this->assertInstanceOf(Adjustment::class, $collection[0]);
        $this->assertCount(1, $collection);
    }

    /** @test */
    public function only_adjustment_object_instances_are_accepted_in_the_array_mutator()
    {
        $collection = new RelationAdjustmentCollection();

        $this->expectException(InvalidArgumentException::class);
        $collection[0] = new stdClass();
    }

    /** @test */
    public function items_can_be_unset()
    {
        $collection = new RelationAdjustmentCollection();

        $collection->add(new Adjustment(['amount' => 3]));
        $collection->add(new Adjustment(['amount' => 4]));

        $this->assertCount(2, $collection);

        unset($collection[1]);
        $this->assertCount(1, $collection);
        $this->assertEquals(3, $collection[0]->getAmount());
    }

    /** @test */
    public function items_can_be_filtered_by_type()
    {
        $c = new RelationAdjustmentCollection();

        $c->add(new Adjustment(['type' => AdjustmentType::PROMOTION]));
        $c->add(new Adjustment(['type' => AdjustmentType::PROMOTION]));
        $c->add(new Adjustment(['type' => AdjustmentType::PROMOTION]));

        $c->add(new Adjustment(['type' => AdjustmentType::TAX]));
        $c->add(new Adjustment(['type' => AdjustmentType::TAX]));

        $c->add(new Adjustment(['type' => AdjustmentType::SHIPPING]));

        $this->assertCount(6, $c);

        $promotions = $c->byType(AdjustmentType::PROMOTION());
        $this->assertInstanceOf(AdjustmentCollection::class, $promotions);
        $this->assertCount(3, $promotions);

        $taxes = $c->byType(AdjustmentType::TAX());
        $this->assertInstanceOf(AdjustmentCollection::class, $taxes);
        $this->assertCount(2, $taxes);

        $shippingFees = $c->byType(AdjustmentType::SHIPPING());
        $this->assertInstanceOf(AdjustmentCollection::class, $shippingFees);
        $this->assertCount(1, $shippingFees);
    }
}
