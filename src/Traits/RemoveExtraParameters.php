<?php

namespace Alvarofpp\ExpandRequest\Traits;

trait RemoveExtraParameters
{
    /**
     * RemoveExtraParameters constructor.
     * Creates the list of accepted parameters.
     */
    public function __construct()
    {
        parent::__construct();
        if (!property_exists($this, 'accept')) {
            $values = array_merge(array_keys($this->rules()), array_keys($this->attributes()));
            $this->accept = array_unique($values);
        }
    }

    /**
     * Filters the parameters, selecting only those listed in $accept.
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $all = parent::all();
        $keysAccepted = array_intersect(array_keys($all), $this->accept);

        return array_intersect_key($all, array_flip($keysAccepted));
    }
}
