<?php

namespace App\Casts;

use App\Exceptions\InvalidCheckTypeException;
use App\Models\Service;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CheckTypeCast implements CastsAttributes
{
    private array $types;

    public function __construct()
    {
        $this->types = Service::types();
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return $this->types[$value];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     * @throws InvalidCheckTypeException
     */
    public function set($model, $key, $value, $attributes)
    {
        $casted = array_search($value, $this->types);

        if (!(bool)$casted) {
            throw new InvalidCheckTypeException($value . ' is not a valid check type');
        }
        return $casted;
    }
}
