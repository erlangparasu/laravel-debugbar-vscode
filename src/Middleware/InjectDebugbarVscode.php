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
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->debugbarvscode->boot();

        try {
            /** @var \Illuminate\Http\Response $response */
            $response = $next($request);
        } catch (Exception $e) {
            $response = $this->handleException($request, $e);
        } catch (Error $error) {
            $e = new FatalThrowableError($error);
            $response = $this->handleException($request, $e);
        }

        // Modify the response to add the buttons
        $this->debugbarvscode->modifyResponse($request, $response);

        return $response;
    }

    /**
     * Handle the given exception.
     *
     * (Copy from Illuminate\Routing\Pipeline by Taylor Otwell)
     *
     * @param $passable
     * @param  Exception $e
     * @return mixed
     * @throws Exception
     */
    protected function handleException($passable, Exception $e)
    {
        if (! $this->container->bound(ExceptionHandler::class) || ! $passable instanceof Request) {
            throw $e;
        }
        $handler = $this->container->make(ExceptionHandler::class);
        $handler->report($e);
        return $handler->render($passable, $e);
    }
}
