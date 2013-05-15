<?php namespace DeSmart\ResponseException;

use Illuminate\Support\ServiceProvider;

class ResponseExceptionServiceProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    $app = $this->app;

    $this->app->before(function() use ($app) 
    {
      $app->error(ErrorHandlerFactory::make());
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return array();
  }

}
