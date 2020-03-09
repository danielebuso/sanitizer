<?php

namespace danielebuso\sanitizer\Filters;

use danielebuso\sanitizer\Contracts\Filter;

class FilterIf implements Filter
{
    /**
     *  Checks if filters should run if there is value passed that matches.
     *
     *  @param  array   $values
     *  @param  array   $options
     *  @return boolean
     */
    public function apply($values, $options = [])
    {
        return array_key_exists($options[0], $values) && $values[$options[0]] === $options[1];
    }
}
