<?php

declare(strict_types=1);

/**
 * Contains the Adjustable interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-27
 *
 */

namespace Vanilo\Adjustments\Contracts;

interface Adjustable
{
    public static function findById($id): ?Adjustable;

    public function adjustments(): AdjustmentCollection;

    public function recalculateAdjustments(): void;
}
