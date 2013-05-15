<?php

use Mockery as m;
use DeSmart\ResponseException\ResponseChain as Chain;

class ResponseExceptionResponseChainTest extends PHPUnit_Framework_TestCase {

  public function tearDown() {
    m::close();
  }

  public function testObjectCallsWithoutFiring() {
    $object = m::mock('mock');
    $object->shouldReceive('foo')->never();

    $exception = m::mock('DeSmart\ResponseException\Exception');
    $exception->shouldReceive('setResponse')->never();

    $chain = new Chain($object, $exception);
    $chain->foo(1, 2, 'bar');
  }

  public function testObjectCallsWithFiring() {
    $object = m::mock('mock');
    $object->shouldReceive('foo')->once()->with(1, 2, 'bar');
    $object->shouldReceive('bar')->once()->with('foo');

    $exception = m::mock('DeSmart\ResponseException\Exception');
    $exception->shouldReceive('setResponse')->once()->with($object);

    $chain = new Chain($object, $exception);
    $chain->foo(1, 2, 'bar')
      ->bar('foo');

    $this->setExpectedException('DeSmart\ResponseException\Exception');
    $chain->fire();
  }

}
