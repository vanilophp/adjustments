<?php

declare(strict_types=1);

/**
 * Contains the Adjuster interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-27
 *
 */

namespace Vanilo\Adjustments\Contracts;

interface Adjuster
{
    public static function fromAdjustable(Adjustable $adjustable): Adjuster;

    public function calculate(): float;
}
