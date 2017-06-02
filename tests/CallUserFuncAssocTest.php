<?php
/*
 * This file is part of the devtronic/call-user-func-assoc package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Tests\CUFA;

use PHPUnit\Framework\TestCase;

/**
 * Class CallUserFuncAssocTest
 * @package Devtronic\Tests\CUFA
 */
class CallUserFuncAssocTest extends TestCase
{
    public function testSimple()
    {
        $result = call_user_func_assoc([$this, 'helloFunction'], ['Julian', 23]);

        $expected = "Hello, my name is Julian, and I'm 23 years old";
        $this->assertSame($expected, $result);

        $result = call_user_func_assoc([$this, 'helloFunction'], [33, 'Hans']);

        $expected = "Hello, my name is 33, and I'm Hans years old";
        $this->assertSame($expected, $result);
    }

    public function testAssoc()
    {
        $result = call_user_func_assoc([$this, 'helloFunction'], [
            'name' => 'Julian',
            'age' => 23,
        ]);

        $expected = "Hello, my name is Julian, and I'm 23 years old";
        $this->assertSame($expected, $result);

        $result = call_user_func_assoc([$this, 'helloFunction'], [
            'age' => 33,
            'name' => 'Hans',
        ]);

        $expected = "Hello, my name is Hans, and I'm 33 years old";
        $this->assertSame($expected, $result);
    }

    public function testOptionalParameters()
    {
        $result = call_user_func_assoc([$this, 'optionalHello'], [
            'name' => 'Julian',
        ]);

        $expected = "Hello, my name is Julian, and I'm *not set* years old";
        $this->assertSame($expected, $result);

        $result = call_user_func_assoc([$this, 'optionalHello'], [
            'age' => 23,
            'name' => 'Julian',
        ]);

        $expected = "Hello, my name is Julian, and I'm 23 years old";
        $this->assertSame($expected, $result);
    }

    public function testStringFunction()
    {
        $test = 'test';
        $expected = strrev($test);
        $result = call_user_func_assoc('strrev', ['str' => $test]);
        $this->assertSame($expected, $result);
        $result = call_user_func_assoc('strrev', [$test]);
        $this->assertSame($expected, $result);
    }

    public function testAnonymousFunction()
    {
        $closure = function ($name) {
            return 'Hello ' . $name;
        };

        $expected = 'Hello Julian';
        $result = call_user_func_assoc($closure, ['name' => 'Julian']);

        $this->assertSame($expected, $result);
    }

    public function testFailing()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('$function must be an instance of string, array or callable, object given.');
        call_user_func_assoc(new \stdClass(), []);
    }


    /**
     * @param string $name
     * @param mixed $age
     * @return string
     */
    public function helloFunction($name, $age)
    {
        return sprintf("Hello, my name is %s, and I'm %s years old", $name, $age);
    }

    /**
     * @param string $name
     * @param mixed $age
     * @return string
     */
    public function optionalHello($name, $age = '*not set*')
    {
        return sprintf("Hello, my name is %s, and I'm %s years old", $name, $age);
    }

}