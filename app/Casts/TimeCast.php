<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TimeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value !== null) {
            // If $value is a string, parse it into a DateTime object
            if (is_string($value)) {
                $value = \Carbon\Carbon::parse($value);
            }
            return $value->format('H:i:s A');
        } else {
            return null;
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value !== null) {
            // If $value is a string, parse it into a DateTime object
            if (is_string($value)) {
                $value = \Carbon\Carbon::parse($value);
            }
            return $value->format('H:i:s');
        } else {
            return null;
        }
    }
}
