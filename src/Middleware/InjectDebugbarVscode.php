<?php

namespace ErlangParasu\DebugbarVscode\Middleware;

use Error;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use ErlangParasu\DebugbarVscode\LaravelDebugbarVscode;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class InjectDebugbarVscode
{
    /**
     * The App container
     *
     * @var Container
     */
    protected $container;

    /**
     * The DebugBarVscode instance
     *
     * @var LaravelDebugbarVscode
     */
    protected $debugbarvscode;

    /**
     * Create a new middleware instance.
     *
     * @param  Container $container
     * @param  LaravelDebugbarVscode $debugbarvscode
     */
    public function __construct(Container $container, LaravelDebugbarVscode $debugbarvscode)
    {
        $this->container = $container;
        $this->debugbarvscode = $debugbarvscode;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->debugbarvscode->boot();

        $response = $next($request);

        // Modify the response to add the Debugbar
        $this->debugbarvscode->modifyResponse($request, $response);
        return $response;
    }
}
