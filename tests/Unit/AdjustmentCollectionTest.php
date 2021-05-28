<?php

declare(strict_types=1);

/**
 * Contains the AdjustmentCollectionTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-28
 *
 */

namespace Vanilo\Adjustments\Tests\Unit;

use Countable;
use Vanilo\Adjustments\Contracts\AdjustmentCollection as AdjustmentCollectionContracts;
use Vanilo\Adjustments\Support\AdjustmentCollection;
use Vanilo\Adjustments\Tests\TestCase;

class AdjustmentCollectionTest extends TestCase
{
    /** @test */
    public function it_implements_the_interface()
    {
        $this->assertInstanceOf(AdjustmentCollectionContracts::class, new AdjustmentCollection());
    }

    /** @test */
    public function it_is_empty_by_default()
    {
        $c = new AdjustmentCollection();

        $this->assertTrue($c->isEmpty());
        $this->assertEmpty($c);
        $this->assertFalse($c->isNotEmpty());
    }

    /** @test */
    public function it_is_countable()
    {
        $c = new AdjustmentCollection();

        $this->assertInstanceOf(Countable::class, $c);
        $this->assertCount(0, $c);
    }
}
