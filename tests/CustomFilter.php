<?php

use PHPUnit\Framework\TestCase;
use danielebuso\sanitizer\Contracts\Filter;

class CustomFilter implements Filter
{
    public function apply($value, $options = [])
    {
        return $value . $value;
    }
}
