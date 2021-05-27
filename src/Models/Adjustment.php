<?php

declare(strict_types=1);

/**
 * Contains the Adjustment class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-27
 *
 */

namespace Vanilo\Adjustments\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Konekt\Enum\Eloquent\CastsEnums;
use Vanilo\Adjustments\Contracts\Adjustment as AdjustmentContract;

/**
 * @property int $id
 * @property string $type
 * @property string $adjustable_type
 * @property int $adjustable_id
 * @property string $adjuster
 * @property null|string $adjuster_identifier
 * @property array $data
 * @property string $title
 * @property null|string $description
 * @property float $amount
 * @property boolean $is_locked
 * @property boolean $is_included
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Adjustment extends Model implements AdjustmentContract
{
    use CastsEnums;

    protected $table = 'adjustments';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $enums = [
        'type' => 'AdjustmentTypeProxy@enumClass',
    ];

    protected $casts = [
        'data' => 'json',
        'is_locked' => 'boolean',
        'is_included' => 'boolean',
    ];

    protected $attributes = [
        'amount' => 0,
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (null === $model->data) {
                $model->data = [];
            }
        });
    }
}
