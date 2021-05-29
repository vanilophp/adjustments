<?php

declare(strict_types=1);

/**
 * Contains the AdjustmentTypeProxy class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-27
 *
 */

namespace Vanilo\Adjustments\Models;

use Konekt\Concord\Proxies\EnumProxy;

/**
 * @method static AdjustmentType PROMOTION()
 * @method static AdjustmentType SHIPPING()
 * @method static AdjustmentType TAX()
 *
 * @method bool isPromotion()
 * @method bool isShipping()
 * @method bool isTax()
 */
class AdjustmentTypeProxy extends EnumProxy
{
}
