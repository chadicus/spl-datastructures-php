<?php
namespace ChadicusTest\Spl\DataStructures;

use Chadicus\Spl\DataStructures\Bag;

/**
 * Unit tests for the \Chadicus\Spl\DataStructures\Bag class.
 *
 * @coversDefaultClass \Chadicus\Spl\DataStructures\Bag
 */
final class BagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Verify basic behavior of add().
     *
     * @test
     * @covers ::add
     * @uses \Chadicus\Spl\DataStructures\Bag::jsonSerialize
     *
     * @return void
     */
    public function add()
    {
        $bag = new Bag();
        $this->assertSame($bag, $bag->add('foo'));
        $this->assertSame(['foo'], $bag->jsonSerialize());
    }

    /**
     * Verify basic behavior of remove().
     *
     * @test
     * @covers ::remove
     * @uses \Chadicus\Spl\DataStructures\Bag
     *
     * @return void
     */
    public function remove()
    {
        $bag = new Bag();
        $bag->add('a')->add('b')->add('c');
        $this->assertSame(3, $bag->count());
        $this->assertTrue(in_array($bag->remove(), ['a', 'b', 'c']));
        $this->assertSame(2, $bag->count());
    }

    /**
     * Verify behavior of remove() with empty bag.
     *
     * @test
     * @covers ::remove
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Bag is empty
     *
     * @return void
     */
    public function removeEmpty()
    {
        (new Bag())->remove();
    }

    /**
     * Verify basic behavior of count().
     *
     * @test
     * @covers ::count
     * @uses \Chadicus\Spl\DataStructures\Bag::add
     *
     * @return void
     */
    public function testCount()
    {
        $bag = new Bag();
        foreach (['a', 'b', 'c'] as $key => $value) {
            $this->assertSame($key, $bag->count());
            $bag->add($value);
        }
    }

    /**
     * Verify basic behavior of isEmpty();
     *
     * @test
     * @covers ::isEmpty
     * @uses \Chadicus\Spl\DataStructures\Bag::add
     *
     * @return void
     */
    public function testIsEmpty()
    {
        $bag = new Bag();
        $this->assertTrue($bag->isEmpty());
        $bag->add('foo');
        $this->assertFalse($bag->isEmpty());
    }

    /**
     * Verify basic behavior of jsonSerialize()
     *
     * @test
     * @covers ::jsonSerialize
     * @uses \Chadicus\Spl\DataStructures\Bag::add
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $bag = new Bag();
        $bag->add('a')->add('b')->add('c');
        $this->assertSame([], array_diff(['a', 'b', 'c'], $bag->jsonSerialize()));
    }

    /**
     * Verify \Iterator implementation.
     *
     * @test
     * @covers ::rewind
     * @covers ::current
     * @covers ::key
     * @covers ::next
     * @covers ::valid
     * @uses \Chadicus\Spl\DataStructures\Bag::add
     *
     * @return void
     */
    public function iteratator()
    {
        $bag = new Bag();
        $bag->add('a')->add('b')->add('c');
        foreach ($bag as $key => $value) {
            $this->assertTrue(in_array($value, ['a', 'b', 'c']));
        }
    }

    /**
     * Verify basic behavior of clear().
     *
     * @test
     * @covers ::clear
     * @uses \Chadicus\Spl\DataStructures\Bag
     *
     * @return void
     */
    public function clear()
    {
        $bag = new Bag();
        $bag->add('a')->add('b')->add('c');
        $this->assertFalse($bag->isEmpty());
        $bag->clear();
        $this->assertTrue($bag->isEmpty());
        $this->assertSame([], $bag->jsonSerialize());
    }
}
