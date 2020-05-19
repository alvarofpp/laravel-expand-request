<?php

namespace Alvarofpp\ExpandRequest\Traits;

trait UrlParameters
{
    /**
     * Add url parameters to be validated
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $parameters = $this->route()->parameters();

        if (property_exists($this, 'renameUrlParameters')) {
            $newParameters = [];
            $position = 0;

            foreach ($parameters as $key => $value) {
                if (array_key_exists($position, $this->renameUrlParameters)) {
                    $newParameters[ $this->renameUrlParameters[$position] ] = $value;
                } else {
                    $newParameters[$key] = $value;
                }
                $position++;
            }

            $parameters = $newParameters;
        }

        return array_replace_recursive(
            parent::all(),
            $parameters
        );
    }
}
