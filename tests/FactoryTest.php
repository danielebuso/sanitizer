<?php

use PHPUnit\Framework\TestCase;
use danielebuso\sanitizer\Laravel\Factory;
use danielebuso\sanitizer\Sanitizer;

class FactoryTest extends TestCase
{
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules, [
            'capitalize'  => \danielebuso\sanitizer\Filters\Capitalize::class,
            'escape'      => \danielebuso\sanitizer\Filters\EscapeHTML::class,
            'format_date' => \danielebuso\sanitizer\Filters\FormatDate::class,
            'lowercase'   => \danielebuso\sanitizer\Filters\Lowercase::class,
            'uppercase'   => \danielebuso\sanitizer\Filters\Uppercase::class,
            'trim'        => \danielebuso\sanitizer\Filters\Trim::class,
        ]);
        return $sanitizer->sanitize();
    }

    public function test_custom_closure_filter()
    {
        $factory = new Factory;
        $factory->extend('hash', function ($value) {
            return sha1($value);
        });

        $data = [
            'name' => 'TEST',
        ];
        $rules = [
            'name' => 'hash',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertEquals(sha1('TEST'), $newData['name']);
    }

    public function test_custom_class_filter()
    {
        $factory = new Factory;
        $factory->extend('custom', CustomFilter::class);

        $data = [
            'name' => 'TEST',
        ];
        $rules = [
            'name' => 'custom',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertEquals('TESTTEST', $newData['name']);
    }

    public function test_replace_filter()
    {
        $factory = new Factory;
        $factory->extend('trim', function ($value) {
            return sha1($value);
        });

        $data = [
            'name' => 'TEST',
        ];
        $rules = [
            'name' => 'trim',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertEquals(sha1('TEST'), $newData['name']);
    }
}
