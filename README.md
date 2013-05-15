## Response Exception

Response exception for Laravel4 is.. exception which returns response.

## Install notes

Add `desmart\laravel-layout` as a requirement to composer.json:

```json
{
  "require": {
    "desmart/response-exception": "1.0.*"
  }
}
```

Update your packages with `composer update` or install with `composer install`.

To add error handler add `'DeSmart\ResponseException\ResponseExceptionServiceProvider',` to providers in `app/config/app.php`.

Other way of adding the handler is to add `App::error()` in `app/filters.php`: 

```php
App::error(DeSmart\ResponseException\ErrorHandlerFactory::make());
```

Just remember to add it **after** the registration of other `App::error()` handlers.

## Why ?

Let's take a look at [desmart/laravel-layout](https://github.com/DeSmart/laravel-layout).  It's a complex controller calling many actions.

Doing redirects in one of the actions is quite painful. That's because each action returns only a part of *bigger* response.
The only way to return a response which will overwrite the *big part* is throwing of exception.

That's not the best design (exceptions aren't for that!), but it works and gives a chance to generate complete response from the smallest part of application.

## Use cases

This package is useless for *standard* Laravel applications. 
Probably it fit's best with [desmart/laravel-layout](https://github.com/DeSmart/laravel-layout) since it's a wicked controller.

Also in some edge cases it can be used for situation when some part of application **needs** to send own response during controller dispatch.

## Examples

```php
use DeSmart\ResponseException\Exception as ResponseException;

ResponseException::make('foo'); // sends 'foo' response

// There's an option to make chained exceptions
ResponseException::chain(Redirect::to('/'))
  ->withInput()
  ->fire();
``

## The hack

In Laravel response may by returned in many parts of request cycle:

* before routing (`App::before()`)
* during route dispatch
* when exception is thrown (`App::error`)

Our hack is using exceptions to take advantage of `App::error()`. When error handler returns a value that value is treated as a response and is returned to client. 

Since throwing an exception breaks normal code execution it's the best way to deliver fast a response.

There's a catch. Every exception is logged to file. The only way to get pass it is to register error handler **as the last one**.
Laravel puts every error handler on top of handlers stack. When one of them returns response the others are not called.
