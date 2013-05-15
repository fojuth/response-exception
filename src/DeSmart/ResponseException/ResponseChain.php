<?php namespace DeSmart\ResponseException;

class ResponseChain {

  private $object;

  /**
   * @var object $object
   * @var DeSmart\ResponseException\Exception $exception
   */
  private $exception;

  private $calls = array();

  public function __construct($object, Exception $exception) {
    $this->object = $object;
    $this->exception = $exception;
  }

  public function __call($name, $arguments) {
    $this->calls[] = compact('name', 'arguments');

    return $this;
  }

  public function fire() {

    foreach($this->calls as $call) {
      call_user_func_array(array($this->object, $call['name']), $call['arguments']);
    }

    $this->exception->setResponse($this->object);

    throw $this->exception;
  }

}
