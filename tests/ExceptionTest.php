<?php

use Mockery as m;
use DeSmart\ResponseException\Exception as ResponseException;
use DeSmart\ResponseException\ResponseChain as Chain;

class ResponseExceptionExceptionTest extends PHPUnit_Framework_TestCase {

  public function tearDown() {
    m::close();
  }

  public function testSetters() {
    $e = new ResponseException();
    $e->setResponse($expected = range(1, 10));

    $this->assertEquals($expected, $e->getResponse());
  }

  public function testMake() {
    $this->setExpectedException('DeSmart\ResponseException\Exception');
    ResponseException::make('foo');
  }

  public function testChain() {
    $chain = ResponseException::chain('test');

    $this->assertInstanceOf('DeSmart\ResponseException\ResponseChain', $chain);
  }

  public function testChaining() {
    $object = m::mock('mock');
    $object->shouldReceive('foo')->with(1, 2, 'foo')->once();
    $object->shouldReceive('bar')->with('var')->once();

    $this->setExpectedException('DeSmart\ResponseException\Exception');
    ResponseException::chain($object)
      ->foo(1, 2, 'foo')
      ->bar('var')
      ->fire();
  }

}
