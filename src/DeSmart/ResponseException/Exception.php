<?php namespace DeSmart\ResponseException;

use Exception as BaseException;

class Exception extends BaseException {

  private $response;

  public function getResponse() {
    return $this->response;
  }

  public function setResponse($response) {
    $this->response = $response;
  }

  public static function make($response) {
    $obj = new static();
    $obj->setResponse($response);

    throw $obj;
  }

  public static function chain($object) {
    return new ResponseChain($object, new static());
  }

}
