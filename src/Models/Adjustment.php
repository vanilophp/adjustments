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
use Vanilo\Adjustments\Contracts\Adjustable;
use Vanilo\Adjustments\Contracts\Adjuster;
use Vanilo\Adjustments\Contracts\Adjustment as AdjustmentContract;
use Vanilo\Adjustments\Contracts\AdjustmentType;

/**
 * @property int $id
 * @property string $type
 * @property string $adjustable_type
 * @property int $adjustable_id
 * @property string $adjuster
 * @property null|string $origin
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

    public function getType(): AdjustmentType
    {
        return $this->type;
    }

    public function getAdjustable(): Adjustable
    {
        // TODO: Implement getAdjustable() method.
    }

    public function getAdjuster(): Adjuster
    {
        // TODO: Implement getAdjuster() method.
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isCharge(): bool
    {
        return $this->amount < 0;
    }

    public function isCredit(): bool
    {
        return $this->amount > 0;
    }

    public function isIncluded(): bool
    {
        return (bool) $this->is_included;
    }

    public function isLocked(): bool
    {
        return (bool) $this->is_locked;
    }

    public function lock(): void
    {
        $this->is_locked = true;
        $this->save();
    }

    public function unlock(): void
    {
        $this->is_locked = false;
        $this->save();
    }
}
