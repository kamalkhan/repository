<?php

namespace Bhittani\Repository;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected $repo;
    protected $config;

    protected function setUp()
    {
        $this->config = [
            'one' => 'one_value',
            'two' => [
                'two_one' => 'two_one_value',
                'two_two' => 'two_two_value',
            ],
            'three' => [
                'three_one' => 'three_one_value',
                'three_two' => [
                    'three_two_one' => 'three_two_one_value',
                ],
                'three_three' => 'three_three_value',
            ],
        ];

        $this->repo = new Repository($this->config);
    }

    /** @test */
    public function it_implements_RepositoryInterface()
    {
        $this->assertInstanceOf(RepositoryInterface::class, $this->repo);
    }

    /** @test */
    public function it_instantiates_with_optional_array()
    {
        $repo = new Repository(['foo' => 'bar']);

        $this->assertInstanceOf(RepositoryInterface::class, $repo);
    }

    /** @test */
    public function it_returns_the_entire_repository_as_an_array()
    {
        $this->assertEquals($this->config, $this->repo->all());
    }

    /** @test */
    public function it_can_determine_whether_a_given_key_exists()
    {
        $this->assertEquals(true, $this->repo->has('one'));
        $this->assertEquals(false, $this->repo->has('one.two'));
        $this->assertEquals(true, $this->repo->has('two'));
        $this->assertEquals(true, $this->repo->has('two.two_one'));
        $this->assertEquals(false, $this->repo->has('two.two_one.two_one_one'));
        $this->assertEquals(true, $this->repo->has('two.two_two'));
        $this->assertEquals(false, $this->repo->has('two.two_two.two_two_one'));
        $this->assertEquals(false, $this->repo->has('two.three'));
        $this->assertEquals(true, $this->repo->has('three.three_one'));
        $this->assertEquals(true, $this->repo->has('three.three_two'));
        $this->assertEquals(true, $this->repo->has('three.three_two.three_two_one'));
        $this->assertEquals(true, $this->repo->has('three.three_three'));
        $this->assertEquals(false, $this->repo->has('three.four'));
        $this->assertEquals(false, $this->repo->has('foo'));
        $this->assertEquals(false, $this->repo->has('foo.bar'));
        $this->assertEquals(false, $this->repo->has('foo.bar.baz'));
    }

    /** @test */
    public function it_returns_a_value_for_a_given_key()
    {
        $this->assertEquals('one_value', $this->repo->get('one'));
        $this->assertEquals('one_value', $this->repo->get('one', 'one'));
        $this->assertEquals('two_one_value', $this->repo->get('two.two_one'));
        $this->assertEquals('two_one_value', $this->repo->get('two.two_one', 'two'));
        $this->assertEquals('three_two_one_value', $this->repo->get('three.three_two.three_two_one'));
        $this->assertEquals('three_two_one_value', $this->repo->get('three.three_two.three_two_one', 'three'));
    }

    /** @test */
    public function it_returns_null_if_given_key_is_not_found()
    {
        $this->assertEquals(null, $this->repo->get('lorem'));
        $this->assertEquals(null, $this->repo->get('lorem.ipsum'));
        $this->assertEquals(null, $this->repo->get('one.two'));
    }

    /** @test */
    public function it_can_return_a_default_value_if_given_key_is_not_found()
    {
        $this->assertEquals([], $this->repo->get('lorem', []));
        $this->assertEquals(1, $this->repo->get('lorem.ipsum', 1));
        $this->assertEquals(0, $this->repo->get('one.two', 0));
    }

    /** @test */
    public function it_sets_a_value_for_a_given_key()
    {
        $this->assertEquals(null, $this->repo->get('foo'));
        $this->repo->set('foo', 'bar');
        $this->assertEquals('bar', $this->repo->get('foo'));
        $this->assertEquals('bar', $this->repo->get('foo', 'foo'));

        $this->assertEquals(null, $this->repo->get('beep.boop'));
        $this->repo->set('beep.boop', 'baz');
        $this->assertEquals('baz', $this->repo->get('beep.boop'));
        $this->assertEquals('baz', $this->repo->get('beep.boop', 'boop'));

        $this->assertEquals('one_value', $this->repo->get('one'));
        $this->repo->set('one', 'foo');
        $this->assertEquals('foo', $this->repo->get('one'));
        $this->assertEquals('foo', $this->repo->get('one', 'one'));

        $this->assertEquals($this->config['two'], $this->repo->get('two'));
        $this->repo->set('two', ['foo' => 'bar', 'bar' => 'baz']);
        $this->assertEquals('two_one_value', $this->repo->get('two.two_one'));
        $this->assertEquals('two_two_value', $this->repo->get('two.two_two'));
        $this->assertEquals('bar', $this->repo->get('two.foo'));
        $this->assertEquals('bar', $this->repo->get('two.foo', 'foo'));
        $this->assertEquals('baz', $this->repo->get('two.bar'));
        $this->assertEquals('baz', $this->repo->get('two.bar', 'bar'));

        // Three levels deep
        $this->assertEquals(null, $this->repo->get('a.b.c'));
        $this->repo->set('a.b.c', 'd');
        $this->assertEquals(['b' => ['c' => 'd']], $this->repo->get('a'));
        $this->assertEquals(['c' => 'd'], $this->repo->get('a.b'));
        $this->assertEquals('d', $this->repo->get('a.b.c'));
        $this->assertNull($this->repo->get('b'));
    }

    /** @test */
    public function it_can_preset_default_value_for_a_given_key()
    {
        $this->assertEquals(null, $this->repo->get('default'));
        $this->repo->preset('default', 'burp');
        $this->assertEquals('burp', $this->repo->get('default'));

        $this->assertEquals('two_one_value', $this->repo->get('two.two_one'));
        $this->repo->preset('two.two_one', 1);
        $this->assertEquals('two_one_value', $this->repo->get('two.two_one'));
    }

    /** @test */
    public function it_appends_a_value_on_to_a_key_value()
    {
        $this->assertEquals(null, $this->repo->get('foo'));
        $this->repo->append('foo', 'foo');
        $this->assertEquals(['foo'], $this->repo->get('foo'));
        $this->repo->append('foo', 'bar');
        $this->assertEquals(['foo', 'bar'], $this->repo->get('foo'));
        $this->repo->append('foo', 'baz');
        $this->assertEquals(['foo', 'bar', 'baz'], $this->repo->get('foo'));

        $this->assertEquals('two_one_value', $this->repo->get('two.two_one'));
        $this->repo->append('two.two_one', 'two_one_value2');
        $this->assertEquals(['two_one_value', 'two_one_value2'], $this->repo->get('two.two_one'));

        $this->assertEquals('one_value', $this->repo->get('one'));
        $this->repo->append('one', 'foo');
        $this->assertEquals(['one_value', 'foo'], $this->repo->get('one'));
    }

    /** @test */
    public function it_prepends_a_value_on_to_a_key_value()
    {
        $this->assertEquals(null, $this->repo->get('foo'));
        $this->repo->prepend('foo', 'foo');
        $this->assertEquals(['foo'], $this->repo->get('foo'));
        $this->repo->prepend('foo', 'bar');
        $this->assertEquals(['bar', 'foo'], $this->repo->get('foo'));
        $this->repo->prepend('foo', 'baz');
        $this->assertEquals(['baz', 'bar', 'foo'], $this->repo->get('foo'));

        $this->assertEquals('two_one_value', $this->repo->get('two.two_one'));
        $this->repo->prepend('two.two_one', 'two_one_value2');
        $this->assertEquals(['two_one_value2', 'two_one_value'], $this->repo->get('two.two_one'));

        $this->assertEquals('one_value', $this->repo->get('one'));
        $this->repo->prepend('one', 'foo');
        $this->assertEquals(['foo', 'one_value'], $this->repo->get('one'));
    }

    /** @test */
    public function it_increments_a_value()
    {
        $this->repo->set('counter', 0);
        $this->repo->increment('counter');
        $this->assertEquals(1, $this->repo->get('counter'));
        $this->repo->increment('counter');
        $this->assertEquals(2, $this->repo->get('counter'));
    }

    /** @test */
    public function it_increments_a_value_if_key_isnt_set()
    {
        $this->assertFalse($this->repo->has('counter'));
        $this->repo->increment('counter');
        $this->assertEquals(1, $this->repo->get('counter'));
        $this->repo->increment('counter');
        $this->assertEquals(2, $this->repo->get('counter'));
    }

    /** @test */
    public function it_increments_a_value_by_a_given_step_size()
    {
        $this->repo->increment('counter', 5);
        $this->assertEquals(5, $this->repo->get('counter'));
        $this->repo->increment('counter', 2);
        $this->assertEquals(7, $this->repo->get('counter'));
    }

    /** @test */
    public function it_decrements_a_value()
    {
        $this->repo->set('counter', 0);
        $this->repo->decrement('counter');
        $this->assertEquals(-1, $this->repo->get('counter'));
        $this->repo->decrement('counter');
        $this->assertEquals(-2, $this->repo->get('counter'));
    }

    /** @test */
    public function it_decrements_a_value_if_key_isnt_set()
    {
        $this->assertFalse($this->repo->has('counter'));
        $this->repo->decrement('counter');
        $this->assertEquals(-1, $this->repo->get('counter'));
        $this->repo->decrement('counter');
        $this->assertEquals(-2, $this->repo->get('counter'));
    }

    /** @test */
    public function it_decrements_a_value_by_a_given_step_size()
    {
        $this->repo->decrement('counter', 5);
        $this->assertEquals(-5, $this->repo->get('counter'));
        $this->repo->decrement('counter', 2);
        $this->assertEquals(-7, $this->repo->get('counter'));
    }
}
