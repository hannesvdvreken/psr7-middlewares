
**No longer maintained**

Create callable middlewares instead. Signature:

```php
function (RequestInterface $request, ResponseInterface $response $next) {
    // Do something with the request before passing it on.
    ...

    // Pass on to next middleware.
    $response = $next($request, $response);

    // Do something with the response after the next middleware has been called.
    ...

    // Return ultimate response object.
    return $response;
}
```

# PSR-7 middlewares

[![Latest Version](https://img.shields.io/github/release/hannesvdvreken/psr7-middlewares.svg?style=flat-square)](https://github.com/hannesvdvreken/psr7-middlewares/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/hannesvdvreken/psr7-middlewares/master.svg?style=flat-square)](https://travis-ci.org/hannesvdvreken/psr7-middlewares)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/hannesvdvreken/psr7-middlewares.svg?style=flat-square)](https://scrutinizer-ci.com/g/hannesvdvreken/psr7-middlewares/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/hannesvdvreken/psr7-middlewares.svg?style=flat-square)](https://scrutinizer-ci.com/g/hannesvdvreken/psr7-middlewares)

Stackable middlewares for PSR-7 HTTP message objects.

## Installation

```
composer require hannesvdvreken/psr7-middlewares
```

## Description

This package is a small library that helps you to construct a decorated array of middlewares.

There are 2 types of middlewares:

A `Kernel`, which is a middleware which can pass on the Request and Response object to the next layer.
A `Core` object is usually the last layer of a list of middlewares.
A core will always return a PSR-7 `ResponseInterface` object and never pass on
the given `RequestInterface` object to a next layer. It will never have a next middleware set.

The `Builder` object helps in creating a composed `Core` which consists of a specified list of layers.
Note that the builder object is immutable:
thus it returns a different mutated object after each `push` and `unshift` call.

```php
use Psr7Stack\Builder;

$builder = new Builder();

$session = new SessionMiddleware();
$throttle = new TrottleMiddleware();
$app = new App();

$builder = $buider->push($session)->push($throttle)->push($app);

$stack = $builder->resolve();
```

The returned `Stack` object can also be created with the static factory method `create`.

```php
use Psr7Stack\Stack;

$stack = Stack::create([$session, $throttle, $app]);
```

The Stack object itself is also a Core middleware, so it can be used in a different composition of middlewares.
This is how you can send a Request object through the different layers of middlewares:

```php
$psrResponse = $stack->handle($psrRequest);
```

## Extending

Creating a Core yourself:

```php
use Psr7Stack\Core;
use Psr\Http\Message\RequestInterface;

class App implements Core
{
    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @request \Psr\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        // Call the router and return the response.
        return $response;
    }
}
```

Creating a Kernel:

```php
use Psr7Stack\Kernel;
use Psr7Stack\Traits\NextCore;

class SessionMiddleware implements Kernel
{
    // Use trait to implement the setNextCore method.
    use NextCore;

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @request \Psr\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        // Call the next core and return the response.
        $response = $this->next->handle($request);

        // Do something with the response and return it.
        ...

        return $response;
    }
}
```

## Middlewares

### Existing

- League/route application core

### Ideas for more middlewares

- Robots middleware. To return an environment specific robots.txt file.
- Any type of framework application
- Throttle middleware
- CORS middleware
- Cache middleware
- IP based Firewall middleware
- Logger middleware

## Contributing

Contributions are welcome. See the [contributions file](CONTRIBUTING.md) to know how to contribute.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
