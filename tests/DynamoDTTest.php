<?php

use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

final class DynamoDTTest extends TestCase
{
    public function testCreateFromgetDefault()
    {
        $this->assertInstanceOf(
            DynamoDT::class,
            new DynamoDT(DynamoDT::getDefault())
        );
    }

    public function testCreateFromString()
    {
        $this->assertInstanceOf(
            DynamoDT::class,
            new DynamoDT(DynamoDT::getDefault('NOW'))
        );
    }

    public function testCreateFromShow()
    {
        $dstr = '2000-01-01T02:03:04.000005+0000';
        $d1 = new DynamoDT($dstr);
        $d2 = new DynamoDT($d1);
        $this->assertInstanceOf(DynamoDT::class, $d2);
        $this->assertEquals('2000-01-01T02:03:04.000005+0000', $d2);
    }

    public function testZeroDate()
    {
        $d = DynamoDT::zeroDate();
        $this->assertInstanceOf(DynamoDT::class, $d);
        $this->assertTrue($d->isZero());
    }

    public function testEq()
    {
        $dstr = '2000-01-01T02:03:04.000005+0000';
        $d1 = new DynamoDT($dstr);
        $d2 = new DynamoDT($dstr);
        $this->assertEquals(
            $d1, // implicit to string
            $d2 // implicit to string
        );
        $this->assertTrue($d1->eq($d2));
        $d3 = new DynamoDT(DynamoDT::getDefault());
        $this->assertNotEquals(
            $d1, // implicit to string
            $d3 // implicit to string
        );
        $this->assertFalse($d1->eq($d3));
    }

    public function testGt()
    {
        $dstr1 = '2000-01-01T02:03:04.000006+0000';
        $dstr2 = '2000-01-01T02:03:04.000005+0000';
        $d1 = new DynamoDT($dstr1);
        $d2 = new DynamoDT($dstr2);
        $this->assertTrue($d1->gt($d2));
        $this->assertFalse($d2->gt($d1));
        $dstr3 = '2000-01-01T02:03:04.000006+0000';
        $d3 = new DynamoDT($dstr3);
        $this->assertFalse($d1->gt($d3));
    }

    public function testLt()
    {
        $dstr1 = '2000-01-01T02:03:04.000005+0000';
        $dstr2 = '2000-01-01T02:03:04.000006+0000';
        $d1 = new DynamoDT($dstr1);
        $d2 = new DynamoDT($dstr2);
        $this->assertTrue($d1->lt($d2));
        $this->assertFalse($d2->lt($d1));
        $dstr3 = '2000-01-01T02:03:04.000005+0000';
        $d3 = new DynamoDT($dstr3);
        $this->assertFalse($d1->lt($d3));
    }

    public function testMove()
    {
        $dstr1 = '2000-01-01T02:03:04.000005+0000';
        $mstr1 = '2000-01-02T02:03:04.000005+0000';
        $d1 = new DynamoDT($dstr1);
        $m1 = $d1->move('+1 day');
        $this->assertEquals(
            $mstr1,
            $m1 // implicit to string
        );
    }

    public function testShow()
    {
        $dstr1 = '2000-01-01T02:03:04.000005+0000';
        $d1 = new DynamoDT($dstr1);
        $this->assertEquals($dstr1, $d1->show());
    }
}
