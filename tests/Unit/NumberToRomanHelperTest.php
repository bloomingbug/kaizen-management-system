<?php

namespace Tests\Unit;

use TypeError;
use PHPUnit\Framework\TestCase;

class NumberToRomanHelperTest extends TestCase
{
    public function testRomanConversion()
    {
        $this->assertEquals('I', number2Roman(1));
        $this->assertEquals('II', number2Roman(2));
        $this->assertEquals('III', number2Roman(3));
        $this->assertEquals('IV', number2Roman(4));
        $this->assertEquals('V', number2Roman(5));
        $this->assertEquals('VI', number2Roman(6));
        $this->assertEquals('VII', number2Roman(7));
        $this->assertEquals('VIII', number2Roman(8));
        $this->assertEquals('IX', number2Roman(9));
        $this->assertEquals('X', number2Roman(10));
        $this->assertEquals('XI', number2Roman(11));
        $this->assertEquals('XII', number2Roman(12));
        $this->assertEquals('XL', number2Roman(40));
        $this->assertEquals('L', number2Roman(50));
        $this->assertEquals('XC', number2Roman(90));
        $this->assertEquals('C', number2Roman(100));
        $this->assertEquals('CD', number2Roman(400));
        $this->assertEquals('D', number2Roman(500));
        $this->assertEquals('CM', number2Roman(900));
        $this->assertEquals('M', number2Roman(1000));
        $this->assertEquals('MCMXCIV', number2Roman(1994));
    }

    public function testRomanConversionWithZero()
    {
        $this->assertEquals('', number2Roman(0));
    }

    public function testRomanConversionWithNonNumericParameter()
    {
        $this->expectException(TypeError::class);
        number2Roman('test');
    }
}
