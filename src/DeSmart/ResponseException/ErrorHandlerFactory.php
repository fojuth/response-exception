<?php namespace DeSmart\ResponseException;

class ErrorHandlerFactory {

  public static function make() {

    return function(Exception $e) {
      return $e->getResponse();
    };
  }

}
