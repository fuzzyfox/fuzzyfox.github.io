<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Sqids\Sqids;

/** @mixin Model */
trait HasSqids
{
    protected Sqids $sqids;

    protected int $sqidsMinLength = 12;

    public function getSqids(): Sqids
    {
        return $this->sqids ??= new Sqids(minLength: $this->sqidsMinLength);
    }

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey(): string
    {
        $key = parent::getRouteKey();

        if (! is_int($key)) {
            throw new \Exception('Cannot use the '.__CLASS__.' trait with models that have `'.gettype($key).'` route keys');
        }

        return $this->getSqids()->encode([crc32(static::class), $key]);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (is_null($field) || $field === $this->getRouteKeyName()) {
            $decodedValue = $this->getSqids()->decode($value);

            if (! $decodedValue || $decodedValue[0] !== crc32(static::class)) {
                return null;
            }

            $value = $decodedValue[1];
            $field = $this->getRouteKeyName();
        }

        return $this->resolveRouteBindingQuery($this, $value, $field)->first();
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if (is_null($field)) {
            $decodedValue = $this->getSqids()->decode($value);

            if (! $decodedValue || $decodedValue[0] !== crc32(static::class)) {
                return parent::resolveRouteBindingQuery($query, null);
            }

            $value = $decodedValue[1];
            $field === $this->getRouteKeyName();
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }
}
