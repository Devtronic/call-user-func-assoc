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

    public function helloFunction($name, $age)
    {
        return sprintf("Hello, my name is %s, and I'm %s years old", $name, $age);
    }

    public function optionalHello($name, $age = '*not set*')
    {
        return sprintf("Hello, my name is %s, and I'm %s years old", $name, $age);
    }
}