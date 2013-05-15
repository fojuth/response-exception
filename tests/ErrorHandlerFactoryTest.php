<?php

use DeSmart\ResponseException\ErrorHandlerFactory;
use DeSmart\ResponseException\Exception as ResponseException;

class ResponseExceptionErrorHandlerFactoryTest extends PHPUnit_Framework_TestCase {

  public function testMake() {
    $callback = ErrorHandlerFactory::make();
    $e = new ResponseException();
    $e->setResponse($expected = range(1, 10));

    $this->assertInstanceOf('Closure', $callback);
    $this->assertEquals($expected, $callback($e));
  }

}
